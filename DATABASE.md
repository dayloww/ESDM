# DATABASE DESIGN

## Users

- id

- name

- email

- password

- role_id

- status

---

## Roles

- id

- nama_role

---

## Kabupaten

- id

- nama

---

## Kecamatan

- id

- kabupaten_id

- nama

---

## Desa

- id

- kecamatan_id

- nama

---

## Data Wilayah

- id

- desa_id

- koordinat

- jumlah_penduduk

- kondisi_ketenagalistrikan

- status_berlistrik

- potensi_energi

- potensi_sumber_daya_mineral

---

## Usaha ESDM

- id

- nama_pelaku_usaha

- nomor_identitas

- nomor_perizinan

- jenis_usaha

- komoditas

- lokasi

- koordinat

- status

- produksi

- penjualan

- dokumen

- foto

---

## Mineral

- id

- lokasi

- jenis_komoditas

- pemegang_izin

- luas

- produksi

- dokumentasi

- hasil_pemantauan

- tindak_lanjut

---

## Energi

- id

- desa

- sumber_energi

- kapasitas

- jaringan

- potensi_ebt

- kondisi_infrastruktur

- permasalahan

- dokumentasi

---

## Pengawasan

- id

- tanggal

- petugas

- objek

- lokasi

- hasil

- temuan

- rekomendasi

- dokumentasi

- tindak_lanjut

- status

---

## Potensi PAD

- id

- jenis_kegiatan

- komoditas

- volume

- satuan

- periode

- nilai_produksi

- pelaku_usaha

- lokasi

- estimasi_penerimaan

---

## Pengaduan

- id

- nama_pelapor

- lokasi

- jenis_pengaduan

- uraian

- foto

- video

- koordinat

- status