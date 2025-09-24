# LAPORAN BLACK BOX TESTING
# Sistem Manajemen Rental Alat Berat

## 1. Pendahuluan

Black Box Testing merupakan metode pengujian perangkat lunak yang berfokus pada fungsionalitas dan hasil yang diharapkan, tanpa memperhatikan struktur kode internal. Pengujian ini dilakukan untuk memastikan bahwa sistem berjalan sesuai dengan kebutuhan pengguna dan spesifikasi yang telah ditetapkan.

Dokumen ini menyajikan hasil pengujian Black Box pada Sistem Manajemen Rental Alat Berat yang telah dikembangkan menggunakan framework Laravel.

## 2. Lingkungan Pengujian

- **Sistem Operasi**: Windows
- **Browser**: Google Chrome versi 117.0
- **Framework**: Laravel 11
- **PHP**: 8.2
- **Database**: MySQL 8.0

## 3. Metode Pengujian

Pengujian dilakukan dengan menggunakan PHPUnit, kerangka kerja pengujian untuk PHP. Semua test case didokumentasikan sebagai kode dalam direktori `tests/Feature/` pada aplikasi. Pengujian meliputi:

1. Pengujian Tampilan Halaman
2. Pengujian Fitur Equipment
3. Pengujian Fitur Booking
4. Pengujian Fitur Admin
5. Pengujian Fitur Setting

## 4. Hasil Pengujian

### 4.1. Pengujian Halaman Publik

| No | Fungsi/Fitur yang Diuji | Skenario Pengujian | Hasil yang Diharapkan | Hasil Eksekusi | Keterangan |
|----|-------------------------|-------------------|------------------------|----------------|------------|
| 1 | Halaman Utama (Home) | Mengakses URL utama (/) | Halaman berhasil dimuat dengan kode status 200 | Berhasil | Sistem menampilkan halaman utama dengan informasi perusahaan |
| 2 | Halaman Utama dengan Alat Berat | Mengakses halaman utama dengan data alat berat | Halaman menampilkan daftar alat berat | Berhasil | Sistem menampilkan alat berat yang tersedia pada halaman utama |
| 3 | Halaman Utama dengan Statistik | Mengakses halaman utama dengan statistik aktif | Halaman menampilkan data statistik | Berhasil | Sistem menampilkan jumlah proyek selesai, klien, dan alat berat |
| 4 | Halaman About | Mengakses halaman about | Halaman berhasil dimuat dengan informasi perusahaan | Berhasil | Sistem menampilkan informasi tentang perusahaan |
| 5 | Halaman Visi & Misi | Mengakses halaman visi & misi | Halaman berhasil dimuat dengan visi dan misi perusahaan | Berhasil | Sistem menampilkan visi dan misi perusahaan |
| 6 | Halaman Kontak | Mengakses halaman kontak | Halaman berhasil dimuat dengan informasi kontak | Berhasil | Sistem menampilkan informasi kontak perusahaan |

### 4.2. Pengujian Fitur Equipment (Alat Berat)

| No | Fungsi/Fitur yang Diuji | Skenario Pengujian | Hasil yang Diharapkan | Hasil Eksekusi | Keterangan |
|----|-------------------------|-------------------|------------------------|----------------|------------|
| 1 | Daftar Alat Berat | Mengakses halaman equipment | Halaman berhasil dimuat dengan daftar alat | Berhasil | Sistem menampilkan daftar alat berat yang tersedia |
| 2 | Alat Berat Tidak Aktif | Mengakses alat berat tidak aktif | Alat tidak aktif tidak ditampilkan | Berhasil | Sistem hanya menampilkan alat berat dengan status aktif |
| 3 | Detail Alat Berat | Mengakses halaman detail alat berat | Halaman detail berhasil ditampilkan | Berhasil | Sistem menampilkan informasi rinci tentang alat berat |
| 4 | Detail Alat Berat Tidak Aktif | Mengakses detail alat berat tidak aktif | Sistem menampilkan halaman 404 | Berhasil | Sistem tidak mengizinkan akses ke alat berat tidak aktif |
| 5 | Filter Alat Berat berdasarkan Kategori | Mengakses alat berat dengan filter kategori | Hanya alat berat dalam kategori tersebut ditampilkan | Berhasil | Sistem menampilkan alat berat sesuai dengan filter kategori |
| 6 | Pencarian Alat Berat | Mencari alat berat dengan kata kunci | Hasil pencarian sesuai dengan kata kunci | Berhasil | Sistem menampilkan hasil pencarian yang relevan |

### 4.3. Pengujian Fitur Booking (Pemesanan)

| No | Fungsi/Fitur yang Diuji | Skenario Pengujian | Hasil yang Diharapkan | Hasil Eksekusi | Keterangan |
|----|-------------------------|-------------------|------------------------|----------------|------------|
| 1 | Form Booking (Pengguna Terautentikasi) | Mengakses halaman detail alat sebagai pengguna | Form booking ditampilkan | Berhasil | Sistem menampilkan form pemesanan untuk pengguna yang login |
| 2 | Validasi Form Kosong | Mengirim form booking tanpa data | Sistem menampilkan pesan error validasi | Berhasil | Sistem memvalidasi dan menolak form kosong |
| 3 | Validasi Tanggal Salah | Mengirim form dengan tanggal tidak valid | Sistem menampilkan pesan error validasi tanggal | Berhasil | Sistem memvalidasi tanggal pemesanan dengan benar |
| 4 | Pembuatan Booking Berhasil | Mengirim form booking dengan data lengkap | Booking berhasil dibuat dan pengguna diarahkan ke konfirmasi | Berhasil | Sistem membuat pemesanan baru dan menampilkan konfirmasi |
| 5 | Booking Alat Tidak Aktif | Mencoba booking alat berat tidak aktif | Sistem menolak dengan error 404 | Berhasil | Sistem tidak mengizinkan pemesanan alat tidak aktif |
| 6 | Booking Alat Habis Stok | Mencoba booking alat berat dengan stok 0 | Sistem menolak dengan pesan error | Berhasil | Sistem menolak pemesanan untuk alat yang tidak tersedia |
| 7 | Halaman Konfirmasi Booking | Mengakses halaman konfirmasi setelah booking | Halaman konfirmasi ditampilkan dengan detail booking | Berhasil | Sistem menampilkan informasi konfirmasi pemesanan |
| 8 | Riwayat Booking Pengguna | Pengguna melihat riwayat booking | Halaman riwayat booking ditampilkan | Berhasil | Sistem menampilkan daftar pemesanan pengguna |
| 9 | Detail Booking Pengguna | Pengguna melihat detail booking | Halaman detail booking ditampilkan | Berhasil | Sistem menampilkan detail pemesanan pengguna |

### 4.4. Pengujian Fitur Admin (Equipment Management)

| No | Fungsi/Fitur yang Diuji | Skenario Pengujian | Hasil yang Diharapkan | Hasil Eksekusi | Keterangan |
|----|-------------------------|-------------------|------------------------|----------------|------------|
| 1 | Akses Pengguna Biasa ke Admin | Pengguna biasa mengakses halaman admin | Sistem menolak dengan error 403 | Berhasil | Sistem melindungi halaman admin dari pengguna tidak berwenang |
| 2 | Akses Admin ke Equipment Management | Admin mengakses halaman manajemen alat | Halaman manajemen alat ditampilkan | Berhasil | Sistem menampilkan halaman manajemen alat untuk admin |
| 3 | Daftar Alat Berat Admin | Admin melihat daftar alat berat | Daftar alat berat ditampilkan | Berhasil | Sistem menampilkan daftar alat berat untuk admin |
| 4 | Halaman Tambah Alat Berat | Admin mengakses halaman tambah alat | Form tambah alat ditampilkan | Berhasil | Sistem menampilkan formulir penambahan alat berat |
| 5 | Tambah Alat Berat | Admin menambahkan alat berat baru | Alat berat berhasil ditambahkan | Berhasil | Sistem menyimpan data alat berat baru ke database |
| 6 | Halaman Edit Alat Berat | Admin mengakses halaman edit alat | Form edit alat ditampilkan | Berhasil | Sistem menampilkan formulir untuk mengedit alat berat |
| 7 | Update Alat Berat | Admin mengupdate data alat berat | Data alat berhasil diupdate | Berhasil | Sistem menyimpan perubahan data alat berat |
| 8 | Hapus Alat Berat | Admin menghapus alat berat | Alat berat berhasil dihapus | Berhasil | Sistem menghapus data alat berat dari database |
| 9 | Validasi Form Alat Berat | Admin mengirim form tanpa data wajib | Sistem menampilkan pesan error validasi | Berhasil | Sistem memvalidasi data alat berat dengan benar |

### 4.5. Pengujian Fitur Admin (Booking Management)

| No | Fungsi/Fitur yang Diuji | Skenario Pengujian | Hasil yang Diharapkan | Hasil Eksekusi | Keterangan |
|----|-------------------------|-------------------|------------------------|----------------|------------|
| 1 | Akses Pengguna Biasa ke Admin Booking | Pengguna biasa mengakses booking admin | Sistem menolak dengan error 403 | Berhasil | Sistem melindungi halaman booking admin |
| 2 | Akses Admin ke Booking Management | Admin mengakses manajemen booking | Halaman manajemen booking ditampilkan | Berhasil | Sistem menampilkan halaman manajemen pemesanan |
| 3 | Daftar Booking Admin | Admin melihat daftar booking | Daftar booking ditampilkan | Berhasil | Sistem menampilkan semua data pemesanan |
| 4 | Filter Booking berdasarkan Status | Admin memfilter booking berdasarkan status | Hanya booking dengan status tersebut ditampilkan | Berhasil | Sistem menampilkan pemesanan sesuai filter status |
| 5 | Detail Booking Admin | Admin melihat detail booking | Halaman detail booking ditampilkan | Berhasil | Sistem menampilkan detail lengkap pemesanan |
| 6 | Update Status Booking | Admin mengubah status booking | Status booking berhasil diubah | Berhasil | Sistem mengupdate status pemesanan |
| 7 | Filter Booking berdasarkan Tanggal | Admin memfilter booking berdasarkan tanggal | Booking dalam rentang tanggal ditampilkan | Berhasil | Sistem menampilkan pemesanan sesuai filter tanggal |
| 8 | Pencarian Booking | Admin mencari booking berdasarkan kode/nama | Hasil pencarian sesuai ditampilkan | Berhasil | Sistem menampilkan hasil pencarian pemesanan yang relevan |

### 4.6. Pengujian Fitur Admin (Settings Management)

| No | Fungsi/Fitur yang Diuji | Skenario Pengujian | Hasil yang Diharapkan | Hasil Eksekusi | Keterangan |
|----|-------------------------|-------------------|------------------------|----------------|------------|
| 1 | Akses Pengguna Biasa ke Settings | Pengguna biasa mengakses settings admin | Sistem menolak dengan error 403 | Berhasil | Sistem melindungi halaman pengaturan admin |
| 2 | Akses Admin ke Settings Management | Admin mengakses manajemen settings | Halaman manajemen settings ditampilkan | Berhasil | Sistem menampilkan halaman pengaturan sistem |
| 3 | Update Pengaturan Perusahaan | Admin mengupdate data perusahaan | Data perusahaan berhasil diupdate | Berhasil | Sistem menyimpan perubahan data perusahaan |
| 4 | Upload Logo Perusahaan | Admin mengupload logo baru | Logo berhasil diupload | Berhasil | Sistem menyimpan gambar logo baru |
| 5 | Update Pengaturan Statistik | Admin mengupdate data statistik | Data statistik berhasil diupdate | Berhasil | Sistem menyimpan perubahan data statistik |
| 6 | Tambah Pengaturan Baru | Admin menambahkan pengaturan baru | Pengaturan baru berhasil ditambahkan | Berhasil | Sistem menyimpan pengaturan baru ke database |
| 7 | Hapus Pengaturan | Admin menghapus pengaturan | Pengaturan berhasil dihapus | Berhasil | Sistem menghapus pengaturan dari database |
| 8 | Validasi Form Settings | Admin mengirim form tanpa data wajib | Sistem menampilkan pesan error validasi | Berhasil | Sistem memvalidasi data pengaturan dengan benar |

## 5. Kesimpulan dan Rekomendasi

### 5.1 Kesimpulan

Berdasarkan hasil pengujian Black Box yang telah dilakukan, Sistem Manajemen Rental Alat Berat telah berfungsi sesuai dengan spesifikasi yang diharapkan. Fitur-fitur utama seperti manajemen alat berat, pemesanan, dan pengelolaan pengaturan sistem bekerja dengan baik. Sistem juga telah menerapkan validasi yang tepat untuk memastikan data yang dimasukkan sesuai dengan kebutuhan.

Secara keseluruhan, hasil pengujian menunjukkan bahwa sistem telah memenuhi kriteria fungsionalitas yang ditetapkan dan siap untuk diimplementasikan pada lingkungan produksi.

### 5.2 Rekomendasi

Berdasarkan pengujian yang telah dilakukan, beberapa rekomendasi untuk pengembangan sistem lebih lanjut antara lain:

1. **Penambahan Fitur Notifikasi**: Implementasikan sistem notifikasi untuk memberitahu pengguna dan admin tentang perubahan status booking.
2. **Peningkatan Keamanan**: Tambahkan lapisan keamanan tambahan seperti rate limiting untuk melindungi sistem dari serangan brute force.
3. **Optimasi Performa**: Lakukan optimasi query database untuk meningkatkan kecepatan sistem saat data bertambah banyak.
4. **Sistem Rating dan Review**: Tambahkan fitur umpan balik pelanggan untuk meningkatkan kualitas layanan.
5. **Ekspansi Integrasi Pembayaran**: Tambahkan lebih banyak opsi pembayaran untuk meningkatkan kenyamanan pengguna.

## 6. Lampiran

1. Screenshot hasil pengujian
2. Kode test case (tersimpan dalam direktori `tests/Feature/`)
3. Log error (jika ada)