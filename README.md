# 📘 SPK Apotek – Sistem Manajemen Pareto Obat

SPK Apotek adalah aplikasi web berbasis PHP yang dirancang untuk membantu pengelolaan data obat dan menganalisis penjualan menggunakan prinsip Pareto. Sistem ini berfokus pada efisiensi stok dengan mengidentifikasi produk yang memberikan kontribusi penjualan terbesar.

---

## 🚀 Fitur Utama

- **Manajemen Obat**
  - Tambah, ubah, dan hapus data obat
  - Dukungan berbagai jenis sediaan (Tablet, Kapsul, Salep, dll)
  - Fitur pencarian dan filter berdasarkan kategori

- **Perhitungan Pareto Dinamis**
  - Input penjualan obat secara manual
  - Persentase dan akumulasi otomatis
  - Pengelompokan otomatis: A (kontribusi tinggi), B (sedang), C (rendah)

- **Ekspor & Visualisasi**
  - Ekspor data ke Excel `.xls`
  - Visualisasi analisis Pareto di Excel menggunakan rumus dinamis
  - Dukungan PDF melalui `html2pdf.js` *(opsional)*

---

## 📂 Struktur File

| File                | Deskripsi                                              |
|---------------------|--------------------------------------------------------|
| `index.php`         | Halaman utama laporan Pareto dan ekspor Excel          |
| `tabel-obat.php`    | Manajemen master data obat dengan fitur lengkap        |
| `kelola-obat.php`   | Form tambah/edit data obat                             |
| `hitung-pareto.php` | Form input Qty penjualan untuk analisis Pareto         |
| `proses-pareto.php` | Script logika penghitungan dan pengelompokan Pareto    |
| `export-excel.php`  | Script ekspor HTML menjadi file `.xls`                 |
| `koneksi.php`       | Koneksi ke database MySQL                              |

---

## 📊 Simulasi Rumus Excel

- **Persentase Kontribusi:**
  ```excel
  =Total Penjualan / SUM(Total Penjualan)