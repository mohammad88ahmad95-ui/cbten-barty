<?php
namespace App\Http\Controllers\Api\V1\Provider;

use App\Domain\Booking\Services\BookingService;
use App\Domain\Provider\MembershipContext;
use App\Http\Controllers\Controller;
use App\Http\Requests\PaymentActionRequest;
use App\Models\Booking;
use Illuminate\Http\Request;

class BookingController extends Controller {
    public function __construct(private MembershipContext $context, private BookingService $bookings) {}

    /** GET /provider/bookings?status= */
    public function index(Request $req) {
        return response()->json(['data' => Booking::with(['customer:id,phone',
                'service:id,title_i18n', 'package:id,name_i18n'])
            ->where('provider_id', $this->context->providerId())
            ->when($req->filled('status'), fn ($q) => $q->where('status', $req->status))
            ->orderBy('starts_at')->paginate(20)]);
    }

    public function show(Request $req, Booking $booking) {
        abort_unless($booking->provider_id === $this->context->providerId(), 403);
        return response()->json(['data' => $booking->load(['customer:id,phone', 'service',
            'package', 'items', 'obligations', 'payments.proofs.asset', 'statusHistory'])]);
    }

    public function accept(Request $req, Booking $booking) {
        abort_unless($booking->provider_id === $this->context->providerId(), 403);
        $this->bookings->acceptByProvider($booking, $req->user());
        return response()->json(['data' => ['id' => $booking->id, 'status' => $booking->fresh()->status]]);
    }

    public function reject(PaymentActionRequest $req, Booking $booking) {
        abort_unless($booking->provider_id === $this->context->providerId(), 403);
        $this->bookings->rejectByProvider($booking, $req->user(), $req->validated('reason'));
        return response()->json(['data' => ['id' => $booking->id, 'status' => 'REJECTED']]);
    }
}
