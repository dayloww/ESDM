# Development Roadmap

## Status Implementasi Terkini

| Phase | Fokus | Status | Bukti |
|---|---|---|---|
| Phase 1 | Autentikasi, peran, dan kontrol akses | Selesai | `UserRoleTest`, `AccessControlTest` |
| Phase 2 | Design token, layout, dan aksesibilitas global | Selesai | `LayoutTest` |
| Phase 3 | Dashboard ringkas 6 KPI tanpa animasi berlebih | Selesai | `DashboardTest` |
| Phase 4 | Shared components dan CRUD UX untuk 10 modul data | Selesai | `CrudUiTest` |

Phase 1–4 dipertahankan bersamaan. Perubahan lanjutan tidak boleh menghapus atau menimpa hasil phase sebelumnya.

---

## Phase 1 — Autentikasi, Peran, dan Akses

Selesai.

* Role helper di `app/Models/User.php`: `isOperator()`, `canManageData()`, `canDeleteData()`, `canManageUsers()`.
* Middleware `DataAccess` dan alias `data.access` untuk seluruh rute modul data.
* Middleware `AdminOnly` dan alias `admin` untuk manajemen pengguna.
* Admin: penuh. Operator: lihat, tambah, edit; tanpa hapus dan tanpa manajemen pengguna. Role lain ditolak.
* Tombol Hapus dan aksi pengguna mengikuti helper role, bukan sembunyi CSS saja.

---

## Phase 2 — Design Token, Layout, dan Aksesibilitas

Selesai.

* Token warna, radius, shadow, focus ring, dan transisi `150ms ease` di layout global.
* Sidebar `240px`, navbar `56px`, Poppins, stroke tipis, tanpa efek dekoratif berat.
* Hover lift, glow, dan gradient dekoratif dihapus.
* Skip link `#page-content`, focus yang terlihat, penutupan sidebar dengan `Escape`, dan `prefers-reduced-motion`.
* Responsif untuk desktop, tablet, dan mobile tanpa horizontal overflow pada level halaman.

---

## Phase 3 — Dashboard

Selesai.

* Enam KPI: Wilayah, Usaha, Mineral, Energi, Pengawasan, Potensi PAD.
* Statistik, pertumbuhan bulanan, dan komposisi memakai data database nyata.
* `Potensi PAD` dihitung dari `PotensiPad::query()->count()` dengan soft delete diabaikan.
* Chart regional tetap empat dataset; donut komposisi memakai enam entri termasuk PAD.
* Header dashboard sederhana: sapaan, judul, tanggal, satu tombol `Lihat Analisis`, pill total netral.
* Tanpa `data-reveal`, `data-count-to`, page fade-in, chart entrance animation, atau gradient header.
* Atribut `data-reveal` sisa pada halaman analisis dihapus karena tidak lagi memiliki handler JS/CSS.

---

## Phase 4 — Shared Components dan CRUD UX

Selesai.

### Komponen bersama

* `resources/views/partials/filter-bar.blade.php` — satu form GET, satu tombol Terapkan, reset eksplisit, nilai filter bertahan.
* `resources/views/partials/create-button.blade.php` — tombol Tambah yang aman sesuai role.
* `resources/views/partials/table-actions.blade.php` — aksi tabel dengan target minimal `38px` dan aria-label.
* `resources/views/partials/status-badge.blade.php` — badge status soft dengan kontras memadai.
* `resources/views/partials/empty-state.blade.php` — membedakan data kosong dan hasil filter kosong; CTA hanya untuk role yang diizinkan.
* `resources/views/partials/form-errors.blade.php` — ringkasan error dengan `role="alert"` dan `aria-live`.
* `resources/views/partials/form-actions.blade.php` — footer Batal/Simpan atau Batal/Perbarui yang konsisten.
* `resources/views/layouts/app.blade.php` — CSS aksi tabel, badge, form actions, dan fokus ke input invalid pertama.

### Modul yang distandarisasi

Kabupaten, Kecamatan, Desa, Wilayah, Usaha ESDM, Mineral, Energi, Ketenagalistrikan, Pengawasan, Potensi PAD.

### Perubahan UX

* DataTables memakai `searching: false`; pencarian hanya lewat filter server-side.
* Filter tidak lagi auto-submit saat mengubah field.
* Kolom aksi `170px`, tombol aksi tidak saling menimpa.
* Label form sentence case; singkatan mapan dipertahankan.
* Placeholder edit disamakan dengan create pada field yang sama.
* Error validasi tetap memakai aturan Laravel, `old()`, dan pesan dekat input.

### Dokumen

* `DESIGN.md` disinkronkan dengan Poppins, token Phase 2, 6 KPI Dashboard, dan status Phase 1–4.
* Spesifikasi lama tentang 5 KPI, gradient, reveal, counter, dan hover elevation dihapus.

---

## Verifikasi

Perintah yang dijalankan pada Phase 4:

* `php artisan view:clear`
* `php artisan test --filter=CrudUiTest` — 6 tests, 494 assertions, passed.
* `php artisan test` — 26 tests, 25 passed, 772 assertions; satu failure baseline `ExampleTest`.
* `npm run build` — success dengan Vite `8.1.5`; warning opsional `fontaine` saja.
* `php artisan view:cache` — success.
* `vendor/bin/pint --test` pada file Phase 4 — passed.
* `vendor/bin/pint --test` penuh — 13 file baseline tetap gagal; tidak diubah.
* `git diff --check` — clean.

---

## Masalah Tersisa

* `tests/Feature/ExampleTest.php:13` gagal baseline: ekspektasi status `200`, aktual `302`. Ini bukan regresi Phase 4.
* `vendor/bin/pint --test` penuh memiliki 13 file baseline yang belum diformat; tidak diubah agar tidak menimpa pekerjaan existing.
* Rute `ketenagalistrikan.{show,edit,update,destroy}` memakai parameter `{ketenagalistrikan}`, tetapi controller menerima `Energi $energi`. Akibatnya update/delete ketenagalistrikan tidak mengubah record yang dimaksud. Perbaikan memerlukan perubahan route/model binding dan belum dilakukan karena batasan Phase 4.
* Pemeriksaan visual browser pada `1440px`, `992px`, `768px`, dan `390px` belum tersedia di lingkungan ini.

---

## Backlog

* Perbaiki parameter binding ketenagalistrikan setelah mendapat persetujuan perubahan route/controller.
* Tambah pemeriksaan browser/visual regression bila tooling tersedia.
* Lanjutkan Phase 5 hanya setelah Phase 4 disetujui.
