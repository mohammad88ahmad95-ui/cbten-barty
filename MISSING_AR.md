# الوضع الفعلي لهذا المستودع

## موجود (مأخوذ حرفياً من المحادثة التي لصقتها)
- backend/routes/api.php  (مع إصلاح سطر خاطئ — انظر أدناه)
- backend/bootstrap/app.php · AppServiceProvider · DatabaseSeeder · UserFactory · phpunit.xml · composer.json
- Controllers: QuoteController · ReviewController · Provider/{Dashboard,Quotation,Booking}Controller
- 63 موديل في backend/app/Models (كلها ما عدا Booking)
- README.md · CHECKLIST.md · .gitignore
- provider-dashboard: package.json · postcss.config.js · tsconfig.json
- mobile: empty_state.dart + الأيقونة واللوغو في assets/images
- docs/: مقتطفان (database.php و EventController) يُدمجان يدوياً

## ناقص — كودها كان في رسائل لم تُلصق لي
| الدفعة | المحتوى |
|---|---|
| 1 | الـ14 migration · Enums · Money · OccupancyService · BookingService · PaymentService · QuotationService · Booking model · BookingController · Seeders (Catalog/Roles) · الاختبارات |
| 2 | ArabicNormalizer · AuditLogger · AppNotifier · StaffPermissions · MembershipContext · الـ3 middleware · Onboarding/Verification (services+controllers) · الـ4 Requests |
| 3 | MediaService/Controller · Provider Service/Resource/PaymentAccount/Calendar controllers · CalendarQueryService · NotificationController · PushDispatcher · أوامر الـConsole · routes/console.php |
| 4 | Payment controllers · Stats · Analytics · migration 15 |
| 5+7+8 | كل تطبيق Flutter (pubspec، الثيم، الشاشات…) + FavoriteController + EventController |
| 6 | AuthController · OtpService · TokenService · SmsChannel · CatalogController · SearchController · AvailabilityQueryService |
| 9 | لوحة المزود React (index.html، vite/tailwind config، src/…) |
| 11 | Dockerfile · docker-compose.yml · android-build.yml |

بدون هذه لن يعمل الخادم (الـroutes تشير لـcontrollers غير موجودة بعد) ولن يُبنى APK.

## تصحيح أجريته على النص الأصلي
في routes/api.php كان السطر:
    Route::get('bookings', [ProviderPayments::class, 'bookingIndex'] ?? null);
وهذا خطأ (دالة غير موجودة و `?? null` لا معنى لها). استبدلته بـ Provider\BookingController@index وأضفت مسار show.

## ملاحظات
- Codespaces: بعد `composer create-project` واستبدال composer.json نفّذ `composer update` لأن ملف القفل سيختلف.
- `.env.captain-party.example` يُدمج مع `.env.example` الذي يولّده Laravel.
- لم أتمكن من تشغيل PHP هنا، فلم أختبر الكود؛ فحصت فقط توازن الأقواس في الموديلات.
