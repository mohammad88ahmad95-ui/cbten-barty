<?php
use App\Http\Controllers\Api\V1\{
    AuthController, CatalogController, SearchController, BookingController,
    PaymentController, MediaController, NotificationController, FavoriteController,
    EventController, QuoteController,
};
use App\Http\Controllers\Api\V1\Provider\{
    OnboardingController, ServiceController, ResourceController,
    PaymentAccountController, CalendarController, PaymentController as ProviderPayments,
    AnalyticsController, DashboardController, QuotationController as ProviderQuotes,
    BookingController as ProviderBookings,
};
use App\Http\Controllers\Api\V1\Admin\{
    ProviderVerificationController, PaymentAdminController, StatsController,
};
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {

    // ---------- عام ----------
    Route::post('auth/otp/request', [AuthController::class, 'requestOtp'])->middleware('throttle:6,1');
    Route::post('auth/otp/verify',  [AuthController::class, 'verifyOtp'])->middleware('throttle:10,1');
    Route::post('auth/login',       [AuthController::class, 'login'])->middleware('throttle:6,1');
    Route::post('auth/refresh',     [AuthController::class, 'refresh'])->middleware('throttle:20,1');
    Route::get('catalog/cities',       [CatalogController::class, 'cities']);
    Route::get('catalog/areas',        [CatalogController::class, 'areas']);
    Route::get('catalog/categories',   [CatalogController::class, 'categories']);
    Route::get('catalog/event-types',  fn () => response()->json(['data' =>
        \App\Models\EventType::all(['id', 'slug', 'name_i18n', 'icon'])]));
    Route::get('search',   [SearchController::class, 'search'])->middleware('throttle:60,1');
    Route::get('providers/{provider}',            [CatalogController::class, 'providerShow']);
    Route::get('providers/{provider}/services',   [CatalogController::class, 'providerServices']);
    Route::get('services/{service}',              [CatalogController::class, 'serviceShow']);
    Route::get('services/{service}/availability', [CatalogController::class, 'serviceAvailability']);
    Route::get('banners',  [CatalogController::class, 'banners']);

    Route::middleware('auth:sanctum')->group(function () {

        Route::post('auth/logout', [AuthController::class, 'logout']);
        Route::get('me', [AuthController::class, 'me']);

        // ---------- العميل ----------
        Route::apiResource('events', EventController::class)->only(['index', 'store', 'destroy']);
        Route::post('events/{event}/requirements', [EventController::class, 'addRequirement']);
        Route::post('bookings', [BookingController::class, 'store']);
        Route::get('bookings',  [BookingController::class, 'index']);
        Route::get('bookings/{booking}', [BookingController::class, 'show']);
        Route::post('bookings/{booking}/cancel', [BookingController::class, 'cancel']);
        Route::get('bookings/{booking}/payment-methods', [PaymentController::class, 'methods']);
        Route::post('bookings/{booking}/payments', [PaymentController::class, 'submit']);
        Route::get('me/payments', [PaymentController::class, 'myPayments']);
        Route::post('quote-requests', [QuoteController::class, 'store']);
        Route::get('quote-requests',  [QuoteController::class, 'index']);
        Route::post('quotations/{quotation}/accept', [QuoteController::class, 'accept']);
        Route::post('quotations/{quotation}/reject', [QuoteController::class, 'reject']);
        Route::get('favorites', [FavoriteController::class, 'index']);
        Route::post('favorites/providers/{provider}', [FavoriteController::class, 'toggleProvider']);
        Route::post('favorites/services/{service}',   [FavoriteController::class, 'toggleService']);
        Route::post('favorites/packages/{package}',   [FavoriteController::class, 'togglePackage']);
        Route::post('reviews', [\App\Http\Controllers\Api\V1\ReviewController::class, 'store']);

        // ---------- الوسائط والإشعارات ----------
        Route::post('media', [MediaController::class, 'store']);
        Route::get('media/{asset}/url', [MediaController::class, 'url']);
        Route::delete('media/{asset}', [MediaController::class, 'destroy']);
        Route::get('notifications', [NotificationController::class, 'index']);
        Route::get('notifications/unread-count', [NotificationController::class, 'unreadCount']);
        Route::post('notifications/{id}/read', [NotificationController::class, 'markRead']);
        Route::post('notifications/read-all', [NotificationController::class, 'markAllRead']);

        // ---------- المزود ----------
        Route::post('provider/register', [OnboardingController::class, 'register']);
        Route::prefix('provider')->middleware(['provider.member'])->group(function () {
            Route::get('onboarding', [OnboardingController::class, 'status']);
            Route::put('profile', [OnboardingController::class, 'updateProfile'])->middleware('provider.can:content.manage');
            Route::post('documents', [OnboardingController::class, 'uploadDocument'])->middleware('provider.can:content.manage');
            Route::delete('documents/{document}', [OnboardingController::class, 'deleteDocument'])->middleware('provider.can:content.manage');
            Route::post('submit-for-verification', [OnboardingController::class, 'submitForVerification']);

            Route::get('dashboard', [DashboardController::class, 'index']);
            Route::get('analytics', [AnalyticsController::class, 'summary'])->middleware('provider.can:analytics.view');

            // [تصحيح] كان في النص الأصلي: [ProviderPayments::class, 'bookingIndex'] ?? null  — خطأ
            Route::get('bookings', [ProviderBookings::class, 'index']);
            Route::get('bookings/{booking}', [ProviderBookings::class, 'show']);
            Route::post('bookings/{booking}/accept', [ProviderBookings::class, 'accept']);
            Route::post('bookings/{booking}/reject', [ProviderBookings::class, 'reject']);
            Route::post('bookings/{booking}/cash-received', [ProviderPayments::class, 'cashReceived'])->middleware('provider.can:payments.verify');

            Route::get('payments', [ProviderPayments::class, 'index'])->middleware('provider.can:payments.view');
            Route::post('payments/{payment}/verify', [ProviderPayments::class, 'verify'])->middleware('provider.can:payments.verify');
            Route::post('payments/{payment}/reject', [ProviderPayments::class, 'reject'])->middleware('provider.can:payments.verify');

            Route::get('calendar', [CalendarController::class, 'index'])->middleware('provider.can:bookings.manage_calendar');
            Route::post('calendar/blocks', [CalendarController::class, 'block'])->middleware('provider.can:bookings.manage_calendar');
            Route::delete('calendar/blocks/{block}', [CalendarController::class, 'unblock'])->middleware('provider.can:bookings.manage_calendar');
            Route::post('external-bookings', [CalendarController::class, 'externalBooking'])->middleware('provider.can:bookings.manage_calendar');

            Route::apiResource('resources', ResourceController::class)->only(['index', 'store', 'update', 'destroy']);
            Route::apiResource('services', ServiceController::class)->only(['index', 'store', 'update', 'destroy']);
            Route::match(['put', 'post'], 'payment-accounts/{method}', [PaymentAccountController::class, 'upsert']);
            Route::get('payment-accounts', [PaymentAccountController::class, 'index']);
            Route::post('quotations', [ProviderQuotes::class, 'store'])->middleware('provider.can:quotes.manage');
            Route::get('quotations', [ProviderQuotes::class, 'index']);
            Route::post('quotations/{quotation}/withdraw', [ProviderQuotes::class, 'withdraw']);
        });

        // ---------- الأدمن ----------
        Route::prefix('admin')->middleware(['role:admin'])->group(function () {
            Route::get('providers', [ProviderVerificationController::class, 'index']);
            Route::get('providers/{provider}', [ProviderVerificationController::class, 'show']);
            Route::post('providers/{provider}/review',   [ProviderVerificationController::class, 'review']);
            Route::post('providers/{provider}/verify',   [ProviderVerificationController::class, 'verify']);
            Route::post('providers/{provider}/reject',   [ProviderVerificationController::class, 'reject']);
            Route::post('providers/{provider}/suspend',  [ProviderVerificationController::class, 'suspend']);
            Route::post('providers/{provider}/activate', [ProviderVerificationController::class, 'activate']);
        });
        Route::prefix('admin')->middleware(['role:admin,finance_admin'])->group(function () {
            Route::get('stats', [StatsController::class, 'index']);
            Route::get('payments', [PaymentAdminController::class, 'index']);
            Route::post('payments/{payment}/verify', [PaymentAdminController::class, 'verify']);
            Route::post('payments/{payment}/reject', [PaymentAdminController::class, 'reject']);
        });
    });
});
