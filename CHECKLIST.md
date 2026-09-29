# قائمة تدقيق الملفات
الرقم = الدفعة التي فيها الكود. علّم [x] بعد اللصق.
راجع MISSING_AR.md لمعرفة ما هو موجود فعلياً في هذا المستودع وما هو ناقص.

## الخادم — backend/
### قاعدة البيانات (الدفعة 1)
[ ] database/migrations/2025_01_01_000001_create_auth.php
[ ] database/migrations/2025_01_01_000002_create_rbac.php
[ ] database/migrations/2025_01_01_000003_create_catalog.php
[ ] database/migrations/2025_01_01_000004_create_providers.php
[ ] database/migrations/2025_01_01_000005_create_services.php
[ ] database/migrations/2025_01_01_000006_create_availability.php
[ ] database/migrations/2025_01_01_000007_create_events.php
[ ] database/migrations/2025_01_01_000008_create_quotations.php
[ ] database/migrations/2025_01_01_000009_create_bookings.php
[ ] database/migrations/2025_01_01_000010_create_calendar_entries.php   ← GiST
[ ] database/migrations/2025_01_01_000011_create_payments.php
[ ] database/migrations/2025_01_01_000012_create_cancellation_refunds_commission.php
[ ] database/migrations/2025_01_01_000013_create_reviews_favorites_offers.php
[ ] database/migrations/2025_01_01_000014_create_search_analytics_audit.php
[ ] database/migrations/2025_01_01_000015_create_analytics_daily_aggregates.php (الدفعة 4)
### Seeders (الدفعة 1)
[ ] CatalogSeeder.php   [ ] RolesSeeder.php   [x] DatabaseSeeder.php
### Enums وSupport
[ ] app/Enums/BookingStatus.php  [ ] PaymentStatus.php
[ ] app/Support/Money.php  [ ] ArabicNormalizer.php  [ ] AuditLogger.php  [ ] AppNotifier.php
### Domain
[ ] Booking: SlotUnavailableException · OccupancyService · BookingService · CalendarQueryService · AvailabilityQueryService
[ ] Payment/PaymentService · Quotation/QuotationService
[ ] Provider: StaffPermissions · MembershipContext · OnboardingService · ProviderVerificationService
[ ] Media/MediaService · Notification: PushDispatcher · NullPushDispatcher · Analytics/AnalyticsService
[ ] Auth: SmsChannel · LogSmsChannel · OtpService · TokenService
### Controllers
[x] QuoteController  [x] ReviewController  [x] Provider/QuotationController  [x] Provider/BookingController  [x] Provider/DashboardController
[ ] AuthController · CatalogController · SearchController · BookingController · PaymentController · MediaController
[ ] NotificationController · FavoriteController · EventController (+ ترقيع addRequirement في docs/)
[ ] Provider: OnboardingController · ServiceController · ResourceController · PaymentAccountController · CalendarController · PaymentController · AnalyticsController
[ ] Admin: ProviderVerificationController · PaymentAdminController · StatsController
### Middleware / Requests / Routes
[ ] EnsureProviderMember · EnsureStaffCan · EnsureRole
[ ] Requests: StoreProviderApplication · UpdateProviderProfile · UploadProviderDocument · AdminRejectProvider · PaymentAction
[x] routes/api.php   [ ] routes/console.php   [x] bootstrap/app.php   [x] AppServiceProvider
[ ] config/filesystems.php (disk s3)   [~] config/database.php (المقتطف في docs/)
### Console
[ ] ReleaseExpiredHolds · DispatchOutbox · RollupAnalytics
### Models
[x] كل الموديلات ما عدا Booking.php (الدفعة 1)
### الاختبارات
[ ] كلها (الدفعات 1،2،3،4،6)   [x] UserFactory · phpunit.xml
### النشر
[ ] backend/Dockerfile  [ ] docker-compose.yml  [ ] .github/workflows/android-build.yml

## تطبيق العملاء — mobile/
[x] lib/core/widgets/empty_state.dart · assets (الأيقونة واللوغو)
[ ] كل الباقي (الدفعات 5 و7 و8)

## لوحة المزود — provider-dashboard/
[x] package.json · postcss.config.js · tsconfig.json
[ ] كل الباقي (الدفعة 9)
