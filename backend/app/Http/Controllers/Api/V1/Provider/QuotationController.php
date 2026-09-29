<?php
namespace App\Http\Controllers\Api\V1\Provider;

use App\Domain\Provider\MembershipContext;
use App\Http\Controllers\Controller;
use App\Models\{Quotation, QuotationStatusHistory, QuoteRequest};
use App\Support\AppNotifier;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class QuotationController extends Controller {
    public function __construct(private MembershipContext $context) {}

    /** POST /provider/quotations — إنشاء وإرسال عرض سعر */
    public function store(Request $req) {
        $data = $req->validate([
            'quote_request_id' => 'required|uuid|exists:quote_requests,id',
            'items' => 'required|array|min:1|max:50',
            'items.*.title_i18n' => 'required|array', 'items.*.title_i18n.ar' => 'required|string|max:150',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.unit_amount' => 'required|integer|min:0',
            'discount_amount' => 'nullable|integer|min:0',
            'deposit_amount' => 'nullable|integer|min:0',
            'valid_until' => 'nullable|date|after:today',
            'provider_notes' => 'nullable|string|max:2000',
        ]);
        $qr = QuoteRequest::where('provider_id', $this->context->providerId())
            ->where('status', 'PENDING')->findOrFail($data['quote_request_id']);

        $subtotal = collect($data['items'])->sum(fn ($i) => $i['quantity'] * $i['unit_amount']);
        $discount = (int) ($data['discount_amount'] ?? 0);
        abort_if($discount > $subtotal, 422, 'الخصم يتجاوز الإجمالي');
        $total = $subtotal - $discount;

        $quotation = Quotation::create(['id' => (string) Str::uuid(),
            'quote_request_id' => $qr->id, 'provider_id' => $qr->provider_id,
            'version' => $qr->quotations()->count() + 1, 'status' => 'SENT',
            'currency' => 'SYP', 'subtotal_amount' => $subtotal,
            'discount_amount' => $discount, 'total_amount' => $total,
            'deposit_amount' => (int) ($data['deposit_amount'] ?? (int) round($total * 0.3)),
            'valid_until' => $data['valid_until'] ?? now()->addDays(7),
            'provider_notes' => $data['provider_notes'] ?? null]);
        foreach ($data['items'] as $i => $item) {
            $quotation->items()->create($item + ['line_total' => $item['quantity'] * $item['unit_amount'],
                'sort_order' => $i]);
        }
        $quotation->statusHistory()->create(['from_status' => null, 'to_status' => 'SENT',
            'actor_id' => $req->user()->id, 'created_at' => now()]);
        $qr->forceFill(['status' => 'QUOTED'])->save();
        AppNotifier::send(\App\Models\User::find($qr->customer_id),
            'quote.received', ['quotation_id' => $quotation->id, 'total' => $total]);
        return response()->json(['data' => ['id' => $quotation->id, 'total_amount' => $total,
            'deposit_amount' => $quotation->deposit_amount]], 201);
    }

    public function index() {
        return response()->json(['data' => Quotation::where('provider_id', $this->context->providerId())
            ->with('items')->latest()->get()]);
    }

    public function withdraw(Request $req, Quotation $quotation) {
        abort_unless($quotation->provider_id === $this->context->providerId(), 403);
        abort_unless($quotation->status === 'SENT', 422);
        $quotation->forceFill(['status' => 'WITHDRAWN'])->save();
        $quotation->statusHistory()->create(['from_status' => 'SENT', 'to_status' => 'WITHDRAWN',
            'actor_id' => $req->user()->id, 'created_at' => now()]);
        return response()->json(['data' => ['status' => 'WITHDRAWN']]);
    }
}
