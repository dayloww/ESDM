# Design System

## Konsep Desain

Aplikasi menggunakan konsep **Modern Government Dashboard** dengan tampilan bersih, profesional, minimalis, dan mudah digunakan.

Desain harus mengutamakan:

* Modern
* Clean
* Professional
* Responsive
* Fast
* User Friendly

Gunakan whitespace yang cukup dan hindari tampilan yang terlalu ramai.

---

# Warna Utama

## Primary

```
#2563EB
```

Digunakan untuk:

* Sidebar aktif
* Tombol utama
* Link
* Header

---

## Secondary

```
#1E40AF
```

Digunakan untuk:

* Hover
* Badge
* Aksen

---

## Success

```
#16A34A
```

---

## Warning

```
#F59E0B
```

---

## Danger

```
#DC2626
```

---

## Info

```
#0EA5E9
```

---

## Background

```
#F8FAFC
```

---

## Card

```
#FFFFFF
```

---

## Border

```
#E5E7EB
```

---

## Text Primary

```
#111827
```

---

## Text Secondary

```
#6B7280
```

---

# Font

Gunakan Google Font:

## Poppins

Font utama aplikasi.

Fallback:

```
sans-serif
```

Hierarchy:

Heading

```
700
```

Sub Heading

```
600
```

Body

```
400
```

Small Text

```
300
```

---

# Border Radius

Gunakan radius modern.

Card

```
16px
```

Button

```
10px
```

Input

```
10px
```

Modal

```
18px
```

---

# Shadow

Gunakan shadow ringan.

```
0 8px 24px rgba(0,0,0,.08)
```

Hover

```
0 12px 32px rgba(0,0,0,.12)
```

---

# Layout

Sidebar

```
280px
```

Navbar

```
72px
```

Content

```
Fluid Container
```

Padding halaman

```
24px
```

Gap antar card

```
20px
```

---

# Sidebar

Background

```
#FFFFFF
```

Menu aktif

```
#2563EB
```

Menu hover

```
#EFF6FF
```

Icon

Bootstrap Icons

Sidebar menggunakan icon di setiap menu.

Sidebar dapat di-collapse.

---

# Navbar

Background putih.

Shadow tipis.

Menampilkan:

* Logo
* Nama aplikasi
* Search
* Notification
* Profile User

Navbar selalu sticky.

---

# Card

Semua statistik menggunakan Card Bootstrap.

Isi card:

* Icon besar
* Nama statistik
* Jumlah data
* Keterangan kecil

Card memiliki animasi hover ringan.

---

# Button

Gunakan Bootstrap Button.

Primary

Rounded

Hover lebih gelap.

Gunakan icon bila diperlukan.

---

# Form

Gunakan Bootstrap Form.

Semua input:

* Rounded
* Label di atas input
* Validasi Bootstrap
* Placeholder jelas

---

# Tabel

Gunakan DataTables.

Fitur:

* Search
* Pagination
* Responsive
* Sorting
* Export (nantinya)

Hover row aktif.

---

# Icon

Gunakan hanya:

Bootstrap Icons

Jangan mencampur library icon lain.

---

# Grafik

Gunakan:

Chart.js

Jenis grafik:

* Bar
* Line
* Doughnut

Gunakan warna yang konsisten dengan tema aplikasi.

---

# Peta

Gunakan:

Leaflet.js

Provider:

OpenStreetMap

Jangan menggunakan Google Maps API.

---

# Animasi

Gunakan animasi ringan.

Contoh:

* Fade In
* Slide Up
* Card Hover

Hindari animasi berlebihan.

---

# Responsive

Desktop

≥1200px

Laptop

≥992px

Tablet

≥768px

Mobile

≥576px

Semua halaman wajib responsive.

---

# Dark Mode

Belum diimplementasikan.

Struktur CSS harus memungkinkan penambahan Dark Mode pada versi berikutnya.

---

# Gaya Visual

Inspirasi tampilan:

* AdminLTE 4 (struktur dashboard)
* Tabler Admin (clean UI)
* CoreUI (komponen modern)
* Flowbite Dashboard (minimalis)
* Dashboard modern bergaya pemerintahan digital

Hindari tampilan yang terlalu ramai, terlalu banyak warna, atau penggunaan efek glassmorphism yang berlebihan. Fokus pada kesan profesional, mudah dibaca, dan nyaman digunakan dalam jangka panjang.
