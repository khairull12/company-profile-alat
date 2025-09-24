# TABEL PENGUJIAN BLACK BOX TESTING
# Sistem Manajemen Rental Alat Berat

## Pengujian Halaman Publik

| No | Fungsi/Fitur yang Diuji | Hasil Eksekusi | Keterangan |
|----|-------------------------|----------------|------------|
| 1 | Halaman Utama (Home) | Berhasil | Sistem menampilkan halaman utama dengan informasi perusahaan |
| 2 | Halaman Utama dengan Alat Berat | Berhasil | Sistem menampilkan alat berat yang tersedia pada halaman utama |
| 3 | Halaman Utama dengan Statistik | Berhasil | Sistem menampilkan jumlah proyek selesai, klien, dan alat berat |
| 4 | Halaman About | Berhasil | Sistem menampilkan informasi tentang perusahaan |
| 5 | Halaman Visi & Misi | Berhasil | Sistem menampilkan visi dan misi perusahaan |
| 6 | Halaman Kontak | Berhasil | Sistem menampilkan informasi kontak perusahaan |

## Pengujian Fitur Equipment (Alat Berat)

| No | Fungsi/Fitur yang Diuji | Hasil Eksekusi | Keterangan |
|----|-------------------------|----------------|------------|
| 1 | Daftar Alat Berat | Berhasil | Sistem menampilkan daftar alat berat yang tersedia |
| 2 | Alat Berat Tidak Aktif | Berhasil | Sistem hanya menampilkan alat berat dengan status aktif |
| 3 | Detail Alat Berat | Berhasil | Sistem menampilkan informasi rinci tentang alat berat |
| 4 | Detail Alat Berat Tidak Aktif | Berhasil | Sistem tidak mengizinkan akses ke alat berat tidak aktif |
| 5 | Filter Alat Berat berdasarkan Kategori | Berhasil | Sistem menampilkan alat berat sesuai dengan filter kategori |
| 6 | Pencarian Alat Berat | Berhasil | Sistem menampilkan hasil pencarian yang relevan |

## Pengujian Fitur Booking (Pemesanan)

| No | Fungsi/Fitur yang Diuji | Hasil Eksekusi | Keterangan |
|----|-------------------------|----------------|------------|
| 1 | Form Booking (Pengguna Terautentikasi) | Berhasil | Sistem menampilkan form pemesanan untuk pengguna yang login |
| 2 | Validasi Form Kosong | Berhasil | Sistem memvalidasi dan menolak form kosong |
| 3 | Validasi Tanggal Salah | Berhasil | Sistem memvalidasi tanggal pemesanan dengan benar |
| 4 | Pembuatan Booking Berhasil | Berhasil | Sistem membuat pemesanan baru dan menampilkan konfirmasi |
| 5 | Booking Alat Tidak Aktif | Berhasil | Sistem tidak mengizinkan pemesanan alat tidak aktif |
| 6 | Booking Alat Habis Stok | Berhasil | Sistem menolak pemesanan untuk alat yang tidak tersedia |
| 7 | Halaman Konfirmasi Booking | Berhasil | Sistem menampilkan informasi konfirmasi pemesanan |
| 8 | Riwayat Booking Pengguna | Berhasil | Sistem menampilkan daftar pemesanan pengguna |
| 9 | Detail Booking Pengguna | Berhasil | Sistem menampilkan detail pemesanan pengguna |

## Pengujian Fitur Admin (Equipment Management)

| No | Fungsi/Fitur yang Diuji | Hasil Eksekusi | Keterangan |
|----|-------------------------|----------------|------------|
| 1 | Akses Pengguna Biasa ke Admin | Berhasil | Sistem melindungi halaman admin dari pengguna tidak berwenang |
| 2 | Akses Admin ke Equipment Management | Berhasil | Sistem menampilkan halaman manajemen alat untuk admin |
| 3 | Daftar Alat Berat Admin | Berhasil | Sistem menampilkan daftar alat berat untuk admin |
| 4 | Halaman Tambah Alat Berat | Berhasil | Sistem menampilkan formulir penambahan alat berat |
| 5 | Tambah Alat Berat | Berhasil | Sistem menyimpan data alat berat baru ke database |
| 6 | Halaman Edit Alat Berat | Berhasil | Sistem menampilkan formulir untuk mengedit alat berat |
| 7 | Update Alat Berat | Berhasil | Sistem menyimpan perubahan data alat berat |
| 8 | Hapus Alat Berat | Berhasil | Sistem menghapus data alat berat dari database |
| 9 | Validasi Form Alat Berat | Berhasil | Sistem memvalidasi data alat berat dengan benar |

## Pengujian Fitur Admin (Booking Management)

| No | Fungsi/Fitur yang Diuji | Hasil Eksekusi | Keterangan |
|----|-------------------------|----------------|------------|
| 1 | Akses Pengguna Biasa ke Admin Booking | Berhasil | Sistem melindungi halaman booking admin |
| 2 | Akses Admin ke Booking Management | Berhasil | Sistem menampilkan halaman manajemen pemesanan |
| 3 | Daftar Booking Admin | Berhasil | Sistem menampilkan semua data pemesanan |
| 4 | Filter Booking berdasarkan Status | Berhasil | Sistem menampilkan pemesanan sesuai filter status |
| 5 | Detail Booking Admin | Berhasil | Sistem menampilkan detail lengkap pemesanan |
| 6 | Update Status Booking | Berhasil | Sistem mengupdate status pemesanan |
| 7 | Filter Booking berdasarkan Tanggal | Berhasil | Sistem menampilkan pemesanan sesuai filter tanggal |
| 8 | Pencarian Booking | Berhasil | Sistem menampilkan hasil pencarian pemesanan yang relevan |

## Pengujian Fitur Admin (Settings Management)

| No | Fungsi/Fitur yang Diuji | Hasil Eksekusi | Keterangan |
|----|-------------------------|----------------|------------|
| 1 | Akses Pengguna Biasa ke Settings | Berhasil | Sistem melindungi halaman pengaturan admin |
| 2 | Akses Admin ke Settings Management | Berhasil | Sistem menampilkan halaman pengaturan sistem |
| 3 | Update Pengaturan Perusahaan | Berhasil | Sistem menyimpan perubahan data perusahaan |
| 4 | Upload Logo Perusahaan | Berhasil | Sistem menyimpan gambar logo baru |
| 5 | Update Pengaturan Statistik | Berhasil | Sistem menyimpan perubahan data statistik |
| 6 | Tambah Pengaturan Baru | Berhasil | Sistem menyimpan pengaturan baru ke database |
| 7 | Hapus Pengaturan | Berhasil | Sistem menghapus pengaturan dari database |
| 8 | Validasi Form Settings | Berhasil | Sistem memvalidasi data pengaturan dengan benar |