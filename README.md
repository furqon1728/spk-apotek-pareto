# 📘 SPK Apotek – Sistem Manajemen Pareto Obat

SPK Apotek adalah aplikasi web berbasis PHP yang dirancang untuk membantu pengelolaan data obat dan menganalisis penjualan menggunakan prinsip **Pareto (80/20 rule)**. Sistem ini berfokus pada efisiensi stok dengan mengidentifikasi produk yang memberikan kontribusi penjualan terbesar.

---

## 🚀 Fitur Utama

- **Manajemen Obat**
  - Tambah, ubah, dan hapus data obat
  - Dukungan berbagai jenis sediaan (Tablet, Kapsul, Salep, Sirup, Salep, dll)
  - Fitur pencarian dan filter berdasarkan kategori
  - Pagination dengan pilihan jumlah item per halaman

- **Perhitungan Pareto Dinamis**
  - Input penjualan obat secara manual
  - Persentase kontribusi dan akumulasi otomatis
  - Pengelompokan otomatis: A (kontribusi tinggi), B (sedang), C (rendah)

- **Laporan & Arsip**
  - Laporan Pareto dengan detail produk
  - Ringkasan kategori A/B/C
  - Simpan laporan ke arsip
  - Ekspor laporan ke Excel `.xls`
  - Hapus arsip (single & bulk delete)

- **Autentikasi**
  - Login dengan akun admin
  - Logout untuk mengakhiri sesi

---

## 📂 Struktur File

| File                | Deskripsi                                                                 |
|---------------------|---------------------------------------------------------------------------|
| `index.php`         | Halaman utama laporan Pareto dan ekspor Excel                             |
| `hitung-pareto.php` | Form input Qty penjualan untuk analisis Pareto                            |
| `proses-pareto.php` | Script logika penghitungan dan pengelompokan Pareto                       |
| `export-excel.php`  | Script ekspor laporan Pareto ke file `.xls` dan simpan arsip              |
| `arsip-laporan.php` | Halaman arsip laporan dengan filter, pagination, download, dan hapus      |
| `hapus-arsip.php`   | Script hapus arsip laporan (single delete)                                |
| `hapus-bulk.php`    | Script hapus banyak arsip laporan sekaligus                               |
| `tabel-obat.php`    | Manajemen master data obat dengan pencarian, filter, pagination, tambah   |
| `kelola-obat.php`   | Form tambah/edit data obat                                                |
| `proses-obat.php`   | Script backend untuk tambah, edit, dan hapus data obat                    |
| `login.php`         | Halaman login sistem SPK Apotek                                           |
| `logout.php`        | Script logout, menghapus session                                          |
| `koneksi.php`       | Koneksi ke database MySQL                                                 |
| `spk_apotek.sql`    | Script SQL untuk membuat database, tabel, dan data awal                   |

---