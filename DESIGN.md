# Design System

> DESIGN.md adalah acuan tunggal untuk tampilan dan interaksi aplikasi.
> Setiap keputusan desain harus mengacu pada implementasi aktual.

## Konsep Desain

Aplikasi memakai konsep **Modern Government Data Platform**: clean, profesional, data-focused, ringan, dan responsif.

Prinsip:

* Hierarchy yang jelas: satu aksi utama per halaman.
* Konsistensi token, radius, spacing, dan komponen di seluruh modul.
* Data ditampilkan apa adanya dari database; tidak ada data dummy atau angka buatan.
* Interaksi cepat dan dapat diprediksi.

Hindari:

* Gradient dekoratif, glow, glassmorphism, dan neon.
* Animasi entrance, reveal, dan counter angka.
* Hover lift pada kartu atau tombol.
* Shadow kuat, terlalu banyak warna, dan elemen dekoratif tanpa fungsi.

---

# Design Tokens

Token global didefinisikan di `:root` pada `resources/views/layouts/app.blade.php`. Token khusus dashboard didefinisikan di `resources/css/dashboard.css` dan mengikuti nilai yang sama.

| Token | Nilai | Penggunaan |
|---|---|---|
| `--primary` | `#2563EB` | Sidebar aktif, tombol utama, link, aksen chart, dataset Usaha |
| `--primary-strong` | `#1E40AF` | Hover primary, dataset Mineral |
| `--primary-soft` | `#EFF6FF` | Latar tipis primary, hover menu |
| `--canvas` | `#F5F7FB` | Latar halaman |
| `--surface` | `#FFFFFF` | Card, topbar, footer |
| `--surface-subtle` | `#F8FAFC` | Header tabel, latar netral |
| `--border` | `#E2E8F0` | Border card, divider, input |
| `--border-strong` | `#CBD5E1` | Border hover/aktif |
| `--text` | `#0F172A` | Judul, angka statistik, teks utama |
| `--text-secondary` | `#475569` | Label, subtitle, meta, dataset Pengawasan |
| `--text-muted` | `#64748B` | Teks pendukung non-esensial |
| `--success` | `#16A34A` | Status positif, dataset Energi |
| `--warning` | `#F59E0B` | Status peringatan |
| `--danger` | `#DC2626` | Error dan hapus |
| `--info` | `#0891B2` | Informasi, dataset Energi lama, marker usaha |
| `--radius-control` | `10px` | Input, tombol, badge small |
| `--radius-panel` | `14px` | Card dan panel |
| `--shadow` | `0 1px 3px rgba(15,23,42,0.06)` | Shadow default |
| `--focus-ring` | `rgba(37,99,235,0.28)` | Focus ring |
| `--transition` | `150ms ease` | Transisi interaksi |

Warna status dipakai sebagai soft badge, bukan dekorasi. Teks pada badge harus memenuhi kontras WCAG AA.

---

# Typography

Font utama: **Poppins** via Google Fonts, fallback `sans-serif`.

| Elemen | Ukuran | Weight |
|---|---|---|
| H1 | 32–36px | 700 |
| H2 | 24–28px | 700 |
| H3 | 18–20px | 600 |
| Body | 14–15px | 400 |
| Small | 12–13px | 400 |
| Angka statistik | 28–36px | 600–700 |

Heading besar memakai `letter-spacing: -0.02em`. Angka statistik memakai `font-variant-numeric: tabular-nums`.

---

# Spacing, Radius, Shadow

* Padding halaman: 24–28px desktop, 16px mobile.
* Gap antar card: 12px (`g-3`).
* Padding card body: `1.15–1.35rem`.
* Radius control: `10px`; panel: `14px`; badge/pill: `999px`.
* Shadow hanya `var(--shadow)`. Tidak ada shadow elevated dan hover elevation.

---

# Layout

* Sidebar: fixed, lebar **240px**, background `#0F172A`.
* Topbar: sticky, tinggi **56px**, putih, border bawah `--border`.
* Konten: area utama memakai `#page-content` sebagai skip-link target.
* Breakpoint:
  * `<992px`: sidebar off-canvas + overlay.
  * `<768px`: grid menjadi satu kolom, padding 16px.
  * `<576px`: aksi form full width dan tombol tabel tetap dapat dijangkau.
* `Escape` menutup drawer sidebar tanpa memuat ulang halaman.
* Toggle desktop menyembunyikan sidebar sepenuhnya dan membuat `#main-wrapper` melebar tanpa sisa margin; status dipertahankan lewat `localStorage` `esdm-sidebar-collapsed` dan diterapkan sebelum CSS agar tidak flicker.
* Transisi sidebar/main-wrapper memakai 200ms ease-out; `prefers-reduced-motion` menonaktifkan transisi.

---

# Button Styles

* Bootstrap 5 button dengan radius `--radius-control`.
* Primary: background `--primary`, hover `--primary-strong`.
* Secondary/outline: border `--border-strong`, teks `--text-secondary`.
* Tombol tabel: minimal `38px` tinggi dan lebar, `btn-sm`, tanpa shadow.
* Tombol aksi utama halaman: `btn-primary`; tidak lebih dari satu per halaman.
* Transisi hanya `background`, `border-color`, dan `color` selama `--transition`.
* Tidak ada `translateY`, glow, atau efek angkat saat hover.

---

# Card Styles

* Surface `--surface`, border `1px solid var(--border)`, radius `--radius-panel`, shadow `var(--shadow)`.
* Struktur standar: `.card-header` berisi judul + aksi utama; `.card-body` berisi konten.
* Stat card: label besar, angka dari database, deskripsi kecil, icon tile netral/soft.
* Tidak ada hover lift, accent bar animasi, atau gradient pada card.

---

# Table Styles

* DataTables dipakai untuk sorting, pagination, dan info tabel.
* Pencarian teks memakai **satu mekanisme saja**: filter server-side di `filter-bar`; `searching: false` wajib pada konfigurasi DataTables modul data.
* Header tabel: latar datar `--surface-subtle`, teks `--text-secondary`, uppercase 12px, weight 700.
* Tinggi baris target `44–48px`; sel padding `0.8rem 0.95rem`.
* Kolom aksi: lebar `170px`, partial `table-actions`, tombol `btn-sm` dengan target minimal `38px`.
* Teks panjang dipotong dengan `.text-truncate` dan atribut `title`.
* Tabel dibungkus `.table-responsive`; overflow hanya pada area tabel, bukan seluruh halaman.
* Pagination memakai gaya Bootstrap yang sudah ada; tombol harus mudah dibedakan dan dapat difokus.

---

# Badge / Status Styles

* Partial: `resources/views/partials/status-badge.blade.php`.
* Bentuk pill, radius `999px`, padding `.38rem .62rem`, font-weight 600, font-size `.75rem`.
* Mapping:
  * success: `aktif`, `berlistrik`, `selesai`, `disetujui`
  * warning: `sebagian`, `dalam_proses`, `menunggu`
  * danger: `nonaktif`, `izin_habis`, `belum_berlistrik`, `tertunda`, `ditolak`
  * info: `diproses`, tipe dokumen IUPTLS/UPTL
  * secondary: nilai tidak dikenal atau tidak ada status
* Teks badge dapat berasal dari label eksplisit modul; jangan menampilkan `null` sebagai status.

---

# Filter, Empty State, Form

## Filter Bar

* Partial: `resources/views/partials/filter-bar.blade.php`.
* Satu form `GET` dengan satu tombol `Terapkan`.
* `select` dan `input` tidak boleh memiliki `onchange="this.form.submit()"`.
* Nilai filter harus tersimpan di query string setelah submit/reload.
* Tombol `Reset` mengarah ke route index tanpa query.
* Layout filter: `row g-2 align-items-end`, aksi `d-flex flex-wrap gap-2`, responsif di layar kecil.

## Empty State

* Partial: `resources/views/partials/empty-state.blade.php`.
* Bedakan dua kondisi:
  * Belum ada data: `Belum ada {label} yang tersimpan.`
  * Ada filter aktif: `Tidak ada {label} yang cocok dengan filter saat ini.` + tautan `Hapus filter`.
* Tombol Tambah hanya muncul untuk role yang diizinkan melalui `canManageData()`.

## Form

* Partial ringkasan error: `resources/views/partials/form-errors.blade.php`.
* Partial aksi: `resources/views/partials/form-actions.blade.php`.
* Label memakai sentence case; singkatan yang mapan dipertahankan (`NIB`, `IUPTLS`, `UPTL`, `PAD`, `GPS`, `ESDM`).
* Error ditampilkan di dekat input dan dalam ringkasan; pesan memakai kalimat dari Laravel.
* Saat validasi gagal, fokus diarahkan ke input `.is-invalid` pertama, fallback ke `#form-error-summary`.
* `old()` harus dipertahankan pada semua input.
* Aturan validasi, route, dan logika bisnis tidak diubah demi tampilan.

---

# Sidebar dan Topbar

* Sidebar menu Data Wilayah memakai satu grup collapsible yang berisi Kabupaten, Kecamatan, Desa, dan Data Wilayah.
* Menu yang tidak tersedia untuk role tertentu disembunyikan oleh helper role, bukan oleh CSS.
* Topbar tidak memuat global search.
* Avatar user memakai latar primary solid, bukan gradient.
* Toggle sidebar memakai tombol asli dengan `aria-controls="sidebar"`, `aria-expanded`, dan `aria-label` yang mengikuti aksi berikutnya: `chevron-left` saat terbuka, `chevron-right` saat tertutup.
* Drawer mobile menaruh topbar di atas sidebar agar tombol kontrol tetap dapat diklik; backdrop dan `Escape` menutup drawer.
* Fokus keyboard terlihat pada toggle sidebar, menu, dan dropdown.

---

# Dashboard

File: `resources/views/dashboard/index.blade.php`, `resources/css/dashboard.css`, `resources/js/dashboard.js`.

Struktur:

1. Header: sapaan sesuai jam, judul `Ringkasan Data Wilayah IV`, subtitle, tanggal hari ini, satu tombol `Lihat Analisis`, dan pill total data netral.
2. Enam KPI Metric Cards — tanpa heading tambahan karena judul halaman sudah menjelaskannya:
   * Data Wilayah — ikon `bi-map`, biru `#2563EB` dengan tint `#EFF6FF`.
   * Usaha ESDM — ikon `bi-briefcase`, cyan `#0891B2` dengan tint `#ECFEFF`.
   * Mineral & Pertambangan — ikon `bi-gem`, ungu `#7C3AED` dengan tint `#F5F3FF`.
   * Energi & Ketenagalistrikan — ikon `bi-lightning`, hijau `#16A34A` dengan tint `#F0FDF4`.
   * Pengawasan — ikon `bi-shield-check`, slate `#475569` dengan tint `#F1F5F9`.
   * Potensi PAD — ikon `bi-wallet2`, amber `#D97706` dengan tint `#FFFBEB`.
   * Urutan tiap card: ikon outline 17px di area pastel 36px, angka 32px semibold dengan `tabular-nums`, lalu label 13px medium.
   * Card seragam: background putih, border 1px `#E2E8F0`, radius 14px, tanpa shadow.
   * Hover pada pointer presisi: card naik 2px, border `#BFDBFE`, background `#F8FAFF`, ikon `scale(1.05)`, transisi 200ms ease-out; `focus-visible` memakai warna hover yang sama plus ring fokus tanpa pergerakan.
   * Hover hanya aktif pada `(hover: hover) and (pointer: fine)`; `prefers-reduced-motion` menghapus transform lift dan scale.
   * Grid: 6 kolom desktop, 3 kolom tablet, 2 kolom mobile; tinggi card konsisten dan label panjang dibungkus rapi tanpa elipsis.
   * Tanpa gradient, glow, garis aksen tebal, badge pertumbuhan, deskripsi berulang, bounce, animasi berulang, atau shadow berlebih.
3. Grafik Data per Kabupaten dan Sebaran Data Wilayah.
4. Aktivitas Terbaru dan Komposisi & Informasi Wilayah.

Aturan data:

* Semua angka berasal dari database.
* `Potensi PAD` memakai `PotensiPad::query()->count()` dan mengabaikan record yang di-soft-delete.
* `monthlyGrowth` tetap dihitung controller untuk enam modul, termasuk PAD, tetapi tidak ditampilkan pada KPI.
* `compositionData` memakai enam label dan enam warna; PAD memakai `#475569`.
* Grafik regional tetap memakai empat dataset wilayah; PAD tidak ditambahkan ke grafik regional.
* Donut hanya dirender bila total data > 0; selain itu memakai `.dashboard-empty`.
* Aktivitas maksimal lima item dengan timestamp semantic `<time>` dari `created_at`.
* Tidak ada `data-reveal`, `data-count-to`, gradient header, radial glow, atau counter animation.

---

# Chart dan Peta

* Chart.js 4.x via CDN; inisialisasi di `dashboard.js`.
* `animation: false` pada seluruh chart dan donut.
* Chart batang: warna Usaha `#2563EB`, Mineral `#1E40AF`, Energi `#0891B2`, Pengawasan `#64748B`.
* Donut komposisi memakai payload JSON `dashboard-composition-data` dengan enam entri.
* Leaflet 1.9.x via CDN dengan tiles OpenStreetMap.
* Marker hanya dari koordinat valid yang diparse aman di controller.
* Tanpa marker: peta menampilkan pusat wilayah tanpa titik dummy.
* Popup peta wajib di-escape.

---

# Animation / Micro Interaction

* Tanpa library animasi tambahan.
* Satu-satunya motion yang dibolehkan: transisi warna/latar/border selama `150ms ease`.
* Dilarang: page fade-in, reveal saat scroll, counter angka, entrance chart, dan hover lift.
* `prefers-reduced-motion: reduce` tetap dihormati dengan menonaktifkan transisi.

---

# Responsive Behavior

| Breakpoint | Perilaku |
|---|---|
| ≥1200px | Enam stat card sejajar, panel dashboard 7/5 |
| 992–1199px | Stat card 3 per baris, panel dapat bertumpuk |
| 768–991px | Sidebar off-canvas, stat card 2 per baris |
| <768px | Satu kolom, padding 16px |
| <576px | Aksi form full width, tombol tabel tetap dapat diklik |

Tidak boleh ada horizontal overflow pada level halaman. Overflow diperbolehkan hanya di dalam `.table-responsive`.

---

# Accessibility

* Satu H1 per halaman dan hierarchy heading yang logis.
* Setiap kontrol interaktif dapat dicapai dengan keyboard dan memiliki focus state terlihat.
* Ikon fungsional memakai teks atau `aria-label`; ikon dekoratif memakai `aria-hidden="true"`.
* Kontras teks minimal WCAG AA.
* Konfirmasi hapus menyebut nama data dan hanya tersedia untuk role yang diizinkan.
* Skip link `#page-content` wajib tersedia.
* Error validasi memiliki `role="alert"`, `aria-live`, dan `aria-describedby` pada input terkait.

---

# Vite Asset Architecture

Pipeline aset resmi: Vite (`vite.config.js` + laravel-vite-plugin).

* Build: `npm run build`.
* Dev: `npm run dev`.
* Input:
  * `resources/css/dashboard.css` — styling khusus dashboard.
  * `resources/js/dashboard.js` — chart dan peta dashboard.
  * `resources/css/app.css` dan `resources/js/app.js` — bawaan Laravel, tidak dipakai UI admin.
* Styling global tetap berada di `<style>` pada `resources/views/layouts/app.blade.php`.
* Library eksternal (Bootstrap, Bootstrap Icons, Chart.js, Leaflet, SweetAlert2, DataTables, jQuery) tetap via CDN.
* Jangan menambah dependency npm baru tanpa kebutuhan nyata.
* Setelah perubahan aset, jalankan `npm run build` dan `php artisan view:cache`.

---

# JavaScript Interaction Guidelines

* Kode JS harus defensif: cek keberadaan elemen dan library global sebelum inisialisasi.
* Kegagalan satu fitur tidak boleh memblokir fitur lain.
* Payload data dari Blade dikirim sebagai JSON island aman, bukan PHP mentah di dalam JS.
* Tidak ada AJAX tambahan, polling, atau animasi otomatis.
* Fokus error validasi dan konfirmasi hapus ditangani di layout global agar perilakunya seragam.

---

# Icon

Gunakan hanya **Bootstrap Icons**. Jangan mencampur library ikon lain.

---

# Dark Mode

Belum diimplementasikan. Struktur token sudah memungkinkan penambahan dark mode di fase berikutnya.

---

# Gaya Visual

Inspirasi: Tabler Admin, CoreUI, dan Flowbite Dashboard. Fokus pada kesan profesional, mudah dibaca, dan nyaman dipakai dalam jangka panjang. Hindari tampilan ramai, banyak warna, dan efek glassmorphism berlebih.

---

# Status Dokumen

* Phase 1 — autentikasi, peran, dan akses: selesai.
* Phase 2 — design token, layout, dan accessibility pass: selesai.
* Phase 3 — dashboard 6 KPI tanpa animasi berlebih: selesai.
* Phase 4 — shared components dan CRUD UX untuk 10 modul data: selesai.
