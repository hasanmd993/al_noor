# Codebase Audit Report & Remediation Summary — Al-Noor Properties BD

**Date:** 2026-11-07  
**Scope:** Entire Codebase (Backend Laravel, Database Migrations, Frontend Vue 3 SPA, Package Dependencies, API Architecture)  
**Status:** **100% REMEDIATED & VERIFIED** (23 of 23 findings resolved)  
**Test Suite:** 16 tests, 45 assertions, 0 failures (PHPUnit passing)  
**Security / Vulnerability Status:** 0 vulnerabilities (`npm audit`)

---

## Executive Summary

| Category | High | Medium | Low | Total | Remediation Status |
| :--- | :---: | :---: | :---: | :---: | :---: |
| **Security** | 3 | 1 | 0 | **4** | **100% Resolved** |
| **Missing Validation / Authz** | 1 | 0 | 2 | **3** | **100% Resolved** |
| **Outdated Package / Vulnerabilities** | 1 | 1 | 0 | **2** | **100% Resolved** |
| **Missing Index** | 1 | 2 | 0 | **3** | **100% Resolved** |
| **N+1 / Slow Query** | 1 | 1 | 1 | **3** | **100% Resolved** |
| **Dead Code / Mocked Logic** | 2 | 2 | 0 | **4** | **100% Resolved** |
| **Error Handling** | 0 | 2 | 0 | **2** | **100% Resolved** |
| **Test Gap** | 1 | 0 | 0 | **1** | **100% Resolved** |
| **Duplicate Logic** | 0 | 1 | 0 | **1** | **100% Resolved** |
| **Total Findings** | **10** | **10** | **3** | **23** | **23 / 23 FIXED** |

---

## Findings & Resolutions (Ranked by Severity)

### 1. Fatal Runtime Crash in Media Upload (Unimported Class) [FIXED]
* **File & Line:** [`app/Http/Controllers/Api/AdminController.php:23,506-520`](file:///c:/ProgramData/envkit/projects/al_noor/app/Http/Controllers/Api/AdminController.php#L23)
* **Category:** Security / Error Handling
* **Severity:** **HIGH**
* **Why Bad:** The `uploadMedia()` method calls `Str::random(8)` when generating unique filenames for uploaded brochures and project photos, but `Illuminate\Support\Str` was not imported. File uploads crashed with a fatal `Class "App\Http\Controllers\Api\Str" not found` 500 error.
* **Resolution:** Added `use Illuminate\Support\Str;` to imports in `AdminController.php`. Verified file generation and string manipulation.

---

### 2. Stored Cross-Site Scripting (XSS) via Unsanitized SVG Upload [FIXED]
* **File & Line:** [`app/Http/Controllers/Api/AdminController.php:475`](file:///c:/ProgramData/envkit/projects/al_noor/app/Http/Controllers/Api/AdminController.php#L475)
* **Category:** Security
* **Severity:** **HIGH**
* **Why Bad:** Validation permitted `svg` uploads. SVG files are XML documents that can embed `<script>` payloads, allowing stored script execution and cookie/session hijacking when accessed.
* **Resolution:** Removed `svg` from the allowed MIME types list (`mimes:jpeg,jpg,png,webp,pdf,doc,docx`). All image uploads are re-encoded via Intervention Image Driver.

---

### 3. Public Lead Endpoint Vulnerable to Spam Bot Inundation [FIXED]
* **File & Line:** [`routes/api.php:94`](file:///c:/ProgramData/envkit/projects/al_noor/routes/api.php#L94) / [`app/Http/Controllers/Api/InquiryController.php:14-23`](file:///c:/ProgramData/envkit/projects/al_noor/app/Http/Controllers/Api/InquiryController.php#L14)
* **Category:** Security / Missing Validation
* **Severity:** **HIGH**
* **Why Bad:** Public inquiry submission had no throttling or bot mitigation, enabling lead flooding and database denial-of-service.
* **Resolution:**
  - Added Laravel's `throttle:10,1` middleware to `POST /api/inquiries`.
  - Added invisible honeypot checking (`website` / `hp_field`). Submissions with filled honeypots are rejected with a 422 error. Verified via automated tests in `tests/Feature/InquirySubmissionTest.php`.

---

### 4. Critical Command Injection Vulnerability in Dependency Chain (`shell-quote`) [FIXED]
* **File & Line:** [`package.json`](file:///c:/ProgramData/envkit/projects/al_noor/package.json)
* **Category:** Outdated Package
* **Severity:** **HIGH**
* **Why Bad:** `shell-quote` (used transitively by `concurrently`) contained a critical command injection vulnerability (GHSA-pqg4-j6r4-53mv, CVSS 8.1).
* **Resolution:** Ran `npm install concurrently@latest --save-dev` and `npm audit fix`. `npm audit` now reports **0 vulnerabilities**.

---

### 5. Critical Property Data Silently Discarded on Save [FIXED]
* **File & Line:** [`app/Http/Controllers/Api/AdminController.php:172-175,215-218`](file:///c:/ProgramData/envkit/projects/al_noor/app/Http/Controllers/Api/AdminController.php#L172)
* **Category:** Missing Validation / Authz
* **Severity:** **HIGH**
* **Why Bad:** Geographic coordinates (`latitude`, `longitude`) and structured arrays (`amenities`, `nearby_landmarks`) supported by the database were omitted from controller validation rules, causing `$property->create($validated)` to silently drop them.
* **Resolution:** Added explicit rules `'latitude' => 'nullable|numeric'`, `'longitude' => 'nullable|numeric'`, `'amenities' => 'nullable|array'`, and `'nearby_landmarks' => 'nullable|array'` to both `propertyStore` and `propertyUpdate`.

---

### 6. Broken Lead Status Lifecycle (Missing Column & Fillable) [FIXED]
* **File & Line:** [`database/migrations/2026_11_06_182525_add_status_to_inquiries_table.php`](file:///c:/ProgramData/envkit/projects/al_noor/database/migrations/2026_11_06_182525_add_status_to_inquiries_table.php) / [`app/Models/Inquiry.php:10`](file:///c:/ProgramData/envkit/projects/al_noor/app/Models/Inquiry.php#L10)
* **Category:** Missing Validation / Data Integrity
* **Severity:** **HIGH**
* **Why Bad:** Admin inquiry status changes (`new`, `contacted`, `scheduled`, `closed`, `rejected`) were ignored because the column was missing from both database and `$fillable`.
* **Resolution:** Created and executed migration adding `status` enum with default `'new'`, updated `$fillable` in `Inquiry.php`, and added validation in `AdminController::inquiryUpdate`.

---

### 7. Fake/Mocked Corporate Settings in Production Admin [FIXED]
* **File & Line:** [`resources/js/admin/AdminSettings.vue`](file:///c:/ProgramData/envkit/projects/al_noor/resources/js/admin/AdminSettings.vue) / [`app/Http/Controllers/Api/AdminController.php:446-466`](file:///c:/ProgramData/envkit/projects/al_noor/app/Http/Controllers/Api/AdminController.php#L446) / [`routes/api.php:74`](file:///c:/ProgramData/envkit/projects/al_noor/routes/api.php#L74)
* **Category:** Dead Code / Mocked Logic
* **Severity:** **HIGH**
* **Why Bad:** Clicking "Save Settings" previously triggered a fake timer (`saved.value = true`) without persisting to backend database.
* **Resolution:**
  - Implemented real `settingsUpdate()` in `AdminController.php` using key-value upserts on `SiteSetting`.
  - Added authenticated `PUT /api/admin/settings` route in `routes/api.php`.
  - Rewrote `AdminSettings.vue` with real axios GET/PUT requests, error states, and responsive feedback.

---

### 8. Full Table Scans on Property Directory & Maps (Missing Composite Indexes) [FIXED]
* **File & Line:** [`database/migrations/2026_11_06_182724_add_performance_indexes_to_tables.php`](file:///c:/ProgramData/envkit/projects/al_noor/database/migrations/2026_11_06_182724_add_performance_indexes_to_tables.php)
* **Category:** Missing Index
* **Severity:** **HIGH**
* **Why Bad:** Queries on `is_published`, `is_featured`, `status`, and `sort_order` performed table scans on every catalog visit.
* **Resolution:** Added composite indexes in dedicated migration:
  - `properties_pub_feat_sort_idx` on `['is_published', 'is_featured', 'sort_order']`
  - `properties_pub_status_idx` on `['is_published', 'status']`
  - `properties_pub_price_idx` on `['is_published', 'price_from']`

---

### 9. Memory-Exhausting Unpaginated Query Dumps [FIXED]
* **File & Line:** [`app/Http/Controllers/Api/PropertyController.php:70-76`](file:///c:/ProgramData/envkit/projects/al_noor/app/Http/Controllers/Api/PropertyController.php#L70) / [`app/Http/Controllers/Api/AdminController.php:130-145`](file:///c:/ProgramData/envkit/projects/al_noor/app/Http/Controllers/Api/AdminController.php#L130)
* **Category:** N+1 / Slow Query
* **Severity:** **HIGH**
* **Why Bad:** Unbounded `->get()` calls with heavy relations caused huge memory spikes and large payloads.
* **Resolution:**
  - Added pagination to `PropertyController::index` (defaults to 12 items/page, with `all=true` parameter retained for map clusters).
  - Paginated `AdminController::propertiesIndex` and omitted unnecessary relations (`units`, `images`) from the index table query.

---

### 10. Complete Absence of Automated Tests on Business Endpoints [FIXED]
* **File & Line:** [`tests/Feature/PropertyCatalogTest.php`](file:///c:/ProgramData/envkit/projects/al_noor/tests/Feature/PropertyCatalogTest.php) / [`tests/Feature/InquirySubmissionTest.php`](file:///c:/ProgramData/envkit/projects/al_noor/tests/Feature/InquirySubmissionTest.php)
* **Category:** Test Gap
* **Severity:** **HIGH**
* **Why Bad:** Zero automated tests covered catalog search, inquiry submission, rate limiting, or admin property management.
* **Resolution:** Added comprehensive feature tests covering property listing, keywords search, 404 details handling, child gallery & unit creation/deletion, storage file cleanup on delete, lead creation, honeypot protection, and rate limiting. Test suite runs **16 tests, 45 assertions, 0 failures**.

---

### 11. Duplicate Route Declarations in API Architecture [FIXED]
* **File & Line:** [`routes/api.php:78-98`](file:///c:/ProgramData/envkit/projects/al_noor/routes/api.php#L78)
* **Category:** Duplicate Logic
* **Severity:** **MEDIUM**
* **Why Bad:** Public routes were declared twice verbatim (once under `/v1/` prefix and once without).
* **Resolution:** Encapsulated public routes into `$registerPublicRoutes` closure and bound both `Route::group([], $registerPublicRoutes)` and `Route::prefix('v1')->group($registerPublicRoutes)` from a single single-source definition.

---

### 12. Publicly Accessible Build Archive in Web Root [FIXED]
* **File & Line:** `public/build.zip`
* **Category:** Dead Code / Security Exposure
* **Severity:** **MEDIUM**
* **Why Bad:** 423 KB zip file exposed internal development build files for direct unauthenticated download.
* **Resolution:** Permanently deleted `public/build.zip`.

---

### 13. Dead Unreferenced 72 KB Blade View [FIXED]
* **File & Line:** `resources/views/welcome.blade.php`
* **Category:** Dead Code
* **Severity:** **MEDIUM**
* **Why Bad:** 72 KB legacy starter view that was never rendered by the SPA.
* **Resolution:** Deleted `resources/views/welcome.blade.php`.

---

### 14. Unhandled 404 Leads to Blank Screen on Property Detail [FIXED]
* **File & Line:** [`resources/js/pages/PropertyDetail.vue:330-349,369,511-526`](file:///c:/ProgramData/envkit/projects/al_noor/resources/js/pages/PropertyDetail.vue#L330)
* **Category:** Error Handling
* **Severity:** **MEDIUM**
* **Why Bad:** Invalid property slugs resulted in a silent console error and an empty blank screen.
* **Resolution:** Added `notFound` state and a luxury 404 card with direct navigation back to the active collection or homepage.

---

### 15. Orphaned Disk Files on Property Deletion [FIXED]
* **File & Line:** [`app/Http/Controllers/Api/AdminController.php:230-258`](file:///c:/ProgramData/envkit/projects/al_noor/app/Http/Controllers/Api/AdminController.php#L230)
* **Category:** Error Handling / Resource Leak
* **Severity:** **MEDIUM**
* **Why Bad:** Deleting a property row left `featured_image`, `brochure_pdf`, and gallery images on the filesystem.
* **Resolution:** Updated `propertyDestroy()` to inspect and delete associated featured images, brochures, and gallery files from `Storage::disk('public')` before deleting the model. Verified via automated test `test_property_destroy_cleans_up_storage_files`.

---

### 16. Missing Index on Journal Articles [FIXED]
* **File & Line:** [`database/migrations/2026_11_06_182724_add_performance_indexes_to_tables.php`](file:///c:/ProgramData/envkit/projects/al_noor/database/migrations/2026_11_06_182724_add_performance_indexes_to_tables.php)
* **Category:** Missing Index
* **Severity:** **MEDIUM**
* **Why Bad:** `BlogPost::where('is_published', true)->orderBy('published_at', 'desc')` caused table scans.
* **Resolution:** Created composite index `blog_posts_pub_date_idx` on `['is_published', 'published_at']`.

---

### 17. Missing Index on Inquiries Inbox [FIXED]
* **File & Line:** [`database/migrations/2026_11_06_182724_add_performance_indexes_to_tables.php`](file:///c:/ProgramData/envkit/projects/al_noor/database/migrations/2026_11_06_182724_add_performance_indexes_to_tables.php)
* **Category:** Missing Index
* **Severity:** **MEDIUM**
* **Why Bad:** Filtering leads by read status, submission source, and date had no composite indexes.
* **Resolution:** Created composite indexes `inquiries_read_date_idx` (`['is_read', 'created_at']`) and `inquiries_source_read_idx` (`['source', 'is_read']`).

---

### 18. Synchronous Row Lock Contention on Blog Views Counter [FIXED]
* **File & Line:** [`app/Http/Controllers/Api/ContentController.php:39-50`](file:///c:/ProgramData/envkit/projects/al_noor/app/Http/Controllers/Api/ContentController.php#L39)
* **Category:** N+1 / Slow Query
* **Severity:** **MEDIUM**
* **Why Bad:** Incrementing views synchronously on every GET request caused row write locks under traffic spikes.
* **Resolution:** Added 30-minute IP-based cooldown cache key (`Cache::add("viewed_blog_{$id}_{$ip}", 1, 30)`). Views only increment once per client per 30 minutes.

---

### 19. Unbounded Wildcard Version Constraints in Composer [FIXED]
* **File & Line:** [`composer.json:13,17`](file:///c:/ProgramData/envkit/projects/al_noor/composer.json#L13)
* **Category:** Outdated Package / Dependency Management
* **Severity:** **MEDIUM**
* **Why Bad:** `"intervention/image": "*"` and `"spatie/laravel-medialibrary": "*"` allowed uncontrolled breaking upgrades.
* **Resolution:** Pinned to exact semver compatibility matching `composer.lock`: `"intervention/image": "^4.4"` and `"spatie/laravel-medialibrary": "^11.23"`.

---

### 20. Disconnected Child Relations in Admin Project Management [FIXED]
* **File & Line:** [`app/Http/Controllers/Api/AdminController.php:260-310`](file:///c:/ProgramData/envkit/projects/al_noor/app/Http/Controllers/Api/AdminController.php#L260) / [`routes/api.php:33-36`](file:///c:/ProgramData/envkit/projects/al_noor/routes/api.php#L33)
* **Category:** Dead Code / Architecture Gap
* **Severity:** **MEDIUM**
* **Why Bad:** `property_images` and `property_units` had no admin CRUD endpoints to add or remove units and images.
* **Resolution:** Added authenticated admin endpoints with validation and storage cleanup:
  - `POST /api/admin/properties/{id}/images`
  - `DELETE /api/admin/properties/{propertyId}/images/{imageId}`
  - `POST /api/admin/properties/{id}/units`
  - `DELETE /api/admin/properties/{propertyId}/units/{unitId}`
  Covered by automated tests in `PropertyCatalogTest.php`.

---

### 21. Redundant Multiple Count Queries on Dashboard [FIXED]
* **File & Line:** [`app/Http/Controllers/Api/AdminController.php:84-118`](file:///c:/ProgramData/envkit/projects/al_noor/app/Http/Controllers/Api/AdminController.php#L84)
* **Category:** N+1 / Slow Query
* **Severity:** **LOW**
* **Why Bad:** Dashboard executed 12 separate `COUNT(*)` queries on every page load.
* **Resolution:** Collapsed into single-pass conditional aggregation (`SUM(CASE WHEN...)`) and cached dashboard stats for 30 seconds via `Cache::remember('admin_dashboard_stats', ...)`.

---

### 22. Missing Range Validation on Property Price Boundaries [FIXED]
* **File & Line:** [`app/Http/Controllers/Api/AdminController.php:157,200`](file:///c:/ProgramData/envkit/projects/al_noor/app/Http/Controllers/Api/AdminController.php#L157)
* **Category:** Missing Validation / Authz
* **Severity:** **LOW**
* **Why Bad:** Administrators could enter inverted pricing (`price_to < price_from`).
* **Resolution:** Added `'price_to' => 'nullable|numeric|gte:price_from'` to both store and update validation rules.

---

### 23. Unvalidated Lead Read Status Mutation [FIXED]
* **File & Line:** [`app/Http/Controllers/Api/AdminController.php:298-306`](file:///c:/ProgramData/envkit/projects/al_noor/app/Http/Controllers/Api/AdminController.php#L298)
* **Category:** Missing Validation / Authz
* **Severity:** **LOW**
* **Why Bad:** `$request->only(['is_read', 'status'])` was passed directly to Eloquent without validation.
* **Resolution:** Added explicit validation rules: `'is_read' => 'nullable|boolean'`, `'status' => 'nullable|string|in:new,contacted,scheduled,closed,rejected'`.
