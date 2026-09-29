<?php
namespace App\Http\Controllers\Api\V1;

use App\Domain\Quotation\Services\QuotationService;
use App\Http\Controllers\Controller;
use App\Models\{ProviderProfile, Quotation, QuotationStatusHistory, QuoteRequest};
use App\Support\AppNotifier;
use Illuminate\Http\Request;

class QuoteController extends Controller {
    /** POST /quote-requests */
    public function store(Request $req) {
        $data = $req->validate([
            'provider_id' => 'required|uuid|exists:provider_profiles,id',
            'service_id' => 'nullable|uuid|exists:services,id',
            'event_id' => 'nullable|uuid|exists:events,id',
            'requirement_id' => 'nullable|uuid|exists:event_service_requirements,id',
            'details' => 'nullable|array',
            'details.starts_at' => 'nullable|date|after:today',
            'details.guest_count' => 'nullable|integer|min:1',
            'details.notes' => 'nullable|string|max:2000',
        ]);
        $provider = ProviderProfile::where('onboarding_status', 'verified')->findOrFail($data['provider_id']);
        $qr = QuoteRequest::create(['id' => (string) \Illuminate\Support\Str::uuid(),
            'customer_id' => $req->user()->id, 'status' => 'PENDING',
            'expires_at' => now()->addDays(7)] + $data);
        AppNotifier::send(\App\Models\User::find($provider->owner_user_id),
            'quote.requested', ['quote_request_id' => $qr->id]);
        return response()->json(['data' => ['id' => $qr->id, 'status' => $qr->status]], 201);
    }

    public function index(Request $req) {
        return response()->json(['data' => QuoteRequest::with(['quotation' => fn ($q) =>
                $q->where('status', '!=', 'DRAFT')->latest()])
            ->where('customer_id', $req->user()->id)->latest()->get()]);
    }

    /** POST /quotations/{quotation}/accept — تحويل بأسعار مجمّدة (Idempotent عبر QuotationService) */
    public function accept(Request $req, Quotation $quotation, QuotationService $svc) {
        $data = $req->validate([
            'resource_id' => 'required|uuid|exists:bookable_resources,id',
            'event_id' => 'nullable|uuid|exists:events,id',
        ]);
        $booking = $svc->accept($quotation, $req->user(), $data['resource_id'], $data['event_id'] ?? null);
        return response()->json(['data' => ['booking_id' => $booking->id, 'status' => $booking->status]]);
    }

    public function reject(Request $req, Quotation $quotation) {
        abort_unless($quotation->quoteRequest->customer_id === $req->user()->id, 403);
        abort_unless(in_array($quotation->status, ['SENT']), 422);
        $quotation->forceFill(['status' => 'REJECTED'])->save();
        $quotation->statusHistory()->create(['from_status' => 'SENT', 'to_status' => 'REJECTED',
            'actor_id' => $req->user()->id, 'created_at' => now()]);
        $quotation->quoteRequest->forceFill(['status' => 'REJECTED'])->save();
        return response()->json(['data' => ['status' => 'REJECTED']]);
    }
}
