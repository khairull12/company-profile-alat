# 🚀 Quick Start Guide - Rental Alat Berat

## 📋 Prerequisites

Pastikan Anda telah menginstall:
- ✅ PHP 8.1 atau lebih baru
- ✅ Composer
- ✅ Node.js & NPM
- ✅ MySQL 5.7 atau lebih baru
- ✅ Git

## ⚡ Setup dalam 5 Menit

### 1. Clone & Install
```bash
git clone https://github.com/username/company-profile-alat.git
cd company-profile-alat
composer install
npm install
```

### 2. Environment Setup
```bash
cp .env.example .env
php artisan key:generate
```

### 3. Database Configuration
Edit `.env` file:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=company_profile_alat
DB_USERNAME=root
DB_PASSWORD=your_password
```

### 4. Database Setup
```bash
php artisan migrate --seed
php artisan storage:link
```

### 5. Build & Run
```bash
npm run build
php artisan serve
```

🎉 **Selesai!** Buka browser dan akses `http://127.0.0.1:8000`

---

## 🔐 Login Credentials

| Role | Email | Password |
|------|-------|----------|
| **Admin** | admin@admin.com | password |
| **User** | user@test.com | password |

---

## 📱 Fitur Cepat

### Admin Panel (`/admin/dashboard`)
- 📊 Dashboard dengan statistik
- 🚛 Management alat berat
- 📅 Management booking
- ⚙️ Pengaturan perusahaan
- 📈 Laporan & export

### User Interface (`/`)
- 🏠 Halaman beranda
- 🔍 Katalog alat berat
- 📝 Sistem booking
- 👤 Profile management

---

## 🛠️ Development Commands

```bash
# Fresh install dengan data baru
composer run fresh

# Setup lengkap project
composer run setup

# Clear semua cache
composer run clear-cache

# Optimize untuk production
composer run optimize

# Jalankan tests
composer run test

# Development server dengan hot reload
npm run dev
```

---

## 🐛 Troubleshooting

### Error: "Class not found"
```bash
composer dump-autoload
```

### Error: "Permission denied"
```bash
chmod -R 775 storage bootstrap/cache
```

### Error: "Connection refused"
```bash
# Pastikan MySQL running
# Cek konfigurasi .env
php artisan config:clear
```

### Error: "Route not found"
```bash
php artisan route:clear
php artisan route:cache
```

---

## 📚 Resources

- 📖 [Documentation](DOKUMENTASI_SISTEM_ADMIN.md)
- 🔧 [API Guide](API_DOCUMENTATION.md)
- 🧪 [Testing Guide](TESTING_DEPLOYMENT.md)
- 📝 [Changelog](CHANGELOG_PROJECT.md)

---

## 🎯 Quick Tasks

### Tambah Alat Berat Baru
1. Login sebagai admin
2. Ke `/admin/equipment`
3. Klik "Tambah Alat Berat"
4. Isi form dan upload gambar
5. Simpan

### Approve Booking
1. Login sebagai admin
2. Ke `/admin/bookings`
3. Lihat booking pending
4. Klik "Konfirmasi" atau "Tolak"

### Export Laporan
1. Login sebagai admin
2. Ke `/admin/reports`
3. Pilih filter tanggal
4. Klik "Export Excel"

---

## 🔄 Update Project

```bash
git pull origin main
composer install --no-dev
npm install
php artisan migrate
php artisan config:cache
npm run build
```

---

## 📞 Support

Jika ada masalah:
1. Cek log: `storage/logs/laravel.log`
2. Cek browser console untuk error JavaScript
3. Pastikan semua service running (MySQL, Apache/Nginx)

---

**Happy Coding! 🚀**
