<?php
namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\{Booking, Review};
use App\Support\AuditLogger;
use Illuminate\Http\Request;

class ReviewController extends Controller {
    /** POST /reviews — فقط حجز مكتمل يخص العميل (يمنع التقييمات الوهمية بنيوياً) */
    public function store(Request $req) {
        $data = $req->validate([
            'booking_id' => 'required|uuid|exists:bookings,id',
            'rating' => 'required|integer|min:1|max:5',
            'body' => 'nullable|string|max:2000',
            'asset_ids' => 'nullable|array|max:5',
        ]);
        $booking = Booking::findOrFail($data['booking_id']);
        abort_unless($booking->customer_id === $req->user()->id, 403);
        abort_unless($booking->status === 'COMPLETED', 422, 'يمكن التقييم بعد اكتمال المناسبة فقط');

        $review = Review::create(['id' => (string) \Illuminate\Support\Str::uuid(),
            'booking_id' => $booking->id, 'customer_id' => $req->user()->id,
            'provider_id' => $booking->provider_id,
            'rating' => $data['rating'], 'body' => $data['body'] ?? null]);
        foreach ($data['asset_ids'] ?? [] as $assetId) {
            $review->media()->create(['asset_id' => $assetId]);
        }
        // تحديث تجميعات التقييم على المزود
        $agg = Review::where('provider_id', $booking->provider_id)->where('status', 'published');
        $booking->provider->forceFill(['rating_avg' => round((float) $agg->avg('rating'), 2),
            'rating_count' => (int) $agg->count()])->save();
        AuditLogger::log($req->user(), 'review.created', 'review', $review->id);
        return response()->json(['data' => ['id' => $review->id]], 201);
    }
}
