# كابتن بارتي — Captain Party
منصة تخطيط وحجز المناسبات للسوق السوري — تطبيق عملاء (أندرويد) + لوحة مزودين (ويب) + خادم API.

## المكونات
| المجلد | التقنية | الوصف |
|---|---|---|
| `backend/` | Laravel 11 + PostgreSQL 16 + Redis | عقل النظام: حجوزات، دفعات، مصادقة، إشعارات |
| `mobile/` | Flutter 3.24 | تطبيق العملاء — عربي RTL كامل |
| `provider-dashboard/` | React + Vite + Tailwind | لوحة المزود — عربي RTL |
| `.github/workflows/` | GitHub Actions | يبني APK تلقائياً عند كل تحديث |

## أبرز الميزات المنفذة
- مصادقة OTP بالهاتف (سوري: 09XXXXXXXX → +963…)
- حجز بمحرك توفر حقيقي مع **منع الحجز المزدوج على مستوى قاعدة البيانات**
  (قيد GiST `no_double_booking`) + **Idempotency-Key** ضد تكرار الطلبات
- دورة حجز منفصلة عن دورة الدفع (8 حالات حجز / 8 حالات دفع)
- دفعات لكل مزود على حدة: MTN Cash · Sritel Cash · **Sham Cash** · بنك · نقدٍ عند الاستلام
- إثبات دفع بصورة خاصة (روابط موقعة مؤقتة) + تحقق يدوي من المزود أو الإدارة
- حجوزات خارجية + حظر تواريخ على نفس تقويم التوفر
- عروض أسعار (Quotation) تتحول لحجز بأسعار مجمّدة
- منظم مناسبة مع قائمة تحقق تلقائية حسب نوع المناسبة
- بحث عربي مع تطبيع (أ/إ/آ→ا، ة→ه، ى→ي) عبر FTS + trigram
- تدقيق كامل (audit log) + إشعارات داخلية + طابور outbox للإشعارات
- RBAC بـ7 أدوار + صلاحيات موظفي المزود (مالك/مدير/حجوزات/مالية/محتوى)

## تشغيل سريع (للمطور)
### الخادم
```bash
cd backend
cp .env.example .env            # عدّل بيانات الاتصال
composer install
php artisan key:generate
php artisan migrate --seed
php artisan serve               # http://localhost:8000
php artisan schedule:work       # في نافذة ثانية (تنظيف الحجوزات المنتهية)
```
### تطبيق العملاء
```bash
cd mobile
flutter pub get && flutter gen-l10n
flutter run --dart-define=API_BASE_URL=http://10.0.2.2:8000/api
```
### لوحة المزود
```bash
cd provider-dashboard
npm install && npm run dev      # http://localhost:5174 (proxy → :8000)
```

## بناء APK بدون أي أدوات على جهازك
1. ارفع المستودع إلى GitHub
2. Settings → Secrets and variables → Actions → أضف:
   - `API_BASE_URL` = `https://عنوان-خادمك.com/api`
3. تبويب **Actions** → انتظر البناء → نزّل **Artifacts → captain-party-apk**
4. ثبّت الملف على أي أندرويد ✅

## النشر الإنتاجي (VPS)
```bash
git clone <repo> && cd captain-party
echo "DB_PASSWORD=كلمة-سر-قوية" > .env
docker compose up -d
# خلف nginx + شهادة SSL (certbot)
```

## متغيرات البيئة الأساسية (backend/.env)
| المتغير | مثال |
|---|---|
| `DB_HOST` / `DB_DATABASE` / `DB_USERNAME` / `DB_PASSWORD` | postgres |
| `REDIS_HOST` | redis |
| `FILESYSTEM_DISK` | s3 |
| `TIGRIS_ACCESS_KEY_ID` / `TIGRIS_SECRET_ACCESS_KEY` / `TIGRIS_ENDPOINT_URL_S3` / `TIGRIS_BUCKET_NAME` | تخزين الصور |
| `FRONTEND_URL` | رابط لوحة المزود (CORS) |

## الاختبارات الحرجة
```bash
php artisan test --filter=DoubleBookingTest        # حجز مزدوج = مستحيل
php artisan test --filter=PaymentFlowTest          # لا تأكيد قبل تحقق الدفع
php artisan test --filter=AuthOtpFlowTest          # المصادقة
```

## حالة الإنجاز
✅ مكتمل: قاعدة البيانات الكاملة · مصادقة · حجز ومدفوعات · توفر وتقويم · توثيق مزودين ·
تطبيق العميل (دخول/رئيسية/بحث/حجز/دفع/مناسبات/مفضلة/إشعارات) · لوحة المزود (9 صفحات) · CI للـAPK
⏳ متبقٍ: لوحة الأدمن (التحقق موجود كـAPI، الواجهة غير منشأة) · تقييمات في واجهة العميل ·
FCM حقيقي · بوابة SMS فعلية · رفع الكود الجاهز إلى المتجر
