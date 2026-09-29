<?php
namespace App\Http\Controllers\Api\V1\Provider;

use App\Domain\Provider\MembershipContext;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller {
    public function __construct(private MembershipContext $context) {}

    public function index(Request $req) {
        $providerId = $this->context->providerId();
        $monthStart = now()->startOfMonth();
        return response()->json(['data' => [
            'today_bookings' => DB::table('bookings')->where('provider_id', $providerId)
                ->whereDate('starts_at', today())->whereIn('status', ['CONFIRMED', 'COMPLETED'])->count(),
            'upcoming_bookings' => DB::table('bookings')->where('provider_id', $providerId)
                ->where('starts_at', '>', now())->whereIn('status', ['CONFIRMED', 'PAYMENT_REQUIRED'])->count(),
            'new_requests' => DB::table('bookings')->where('provider_id', $providerId)
                ->where('status', 'PENDING_PROVIDER_CONFIRMATION')->count(),
            'pending_payment_verification' => DB::table('payments')->where('provider_id', $providerId)
                ->whereIn('status', ['SUBMITTED', 'UNDER_REVIEW'])->count(),
            'monthly_revenue' => (int) DB::table('payments')->where('provider_id', $providerId)
                ->whereIn('status', ['VERIFIED', 'PARTIALLY_REFUNDED', 'REFUNDED'])
                ->where('created_at', '>=', $monthStart)->sum('amount'),
            'profile_views_month' => DB::table('analytics_events')->where('provider_id', $providerId)
                ->where('event_type', 'profile_view')->where('occurred_at', '>=', $monthStart)->count(),
            'rating' => (float) DB::table('provider_profiles')->where('id', $providerId)->value('rating_avg'),
        ]]);
    }
}
