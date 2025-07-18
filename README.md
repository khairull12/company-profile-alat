# 🚚 Sistem Rental Alat Berat

<p align="center">
    <img src="https://img.shields.io/badge/Laravel-11-red.svg" alt="Laravel 11">
    <img src="https://img.shields.io/badge/PHP-8.1+-blue.svg" alt="PHP 8.1+">
    <img src="https://img.shields.io/badge/MySQL-5.7+-orange.svg" alt="MySQL 5.7+">
    <img src="https://img.shields.io/badge/License-MIT-green.svg" alt="License MIT">
</p>

## 📋 Deskripsi Proyek

Sistem katalog alat berat (Tronton, Excavator, Bulldozer, dll) yang dibangun dengan Laravel 11. Sistem ini memiliki fitur lengkap untuk admin dan user dengan interface yang modern dan responsive.

### 🎯 Fitur Utama

#### 👨‍💼 Admin Dashboard
- **Dashboard Statistik**: Real-time analytics dengan chart dan KPI
- **Management Alat Berat**: CRUD lengkap dengan upload gambar
- **Management Pengaturan**: Konfigurasi perusahaan dan website
- **Laporan & Export**: Filter data dan export ke Excel
- **Role Management**: Sistem role admin dan user

#### 👤 User Features
- **Katalog Alat**: Browse dan search alat berat
- **Detail Alat**: Spesifikasi lengkap dan gambar
- **Sistem Booking**: Kalender booking dengan validasi
- **Riwayat Booking**: Track status pemesanan
- **Profile Management**: Update data pribadi

### 🚀 Demo Akun

| Role | Email | Password |
|------|-------|----------|
| Admin | admin@admin.com | password |
| User | user@test.com | password |

## 🛠️ Teknologi yang Digunakan

- **Backend**: Laravel 11, PHP 8.1+
- **Database**: MySQL 5.7+
- **Frontend**: Bootstrap 5, Tailwind CSS
- **Icons**: Font Awesome 6
- **Export**: Laravel Excel (maatwebsite/excel)
- **Authentication**: Laravel Breeze
- **Image Processing**: Intervention Image

## 📦 Instalasi

### 1. Clone Repository
```bash
git clone https://github.com/username/company-profile-alat.git
cd company-profile-alat
```

### 2. Install Dependencies
```bash
composer install
npm install
```

### 3. Setup Environment
```bash
cp .env.example .env
php artisan key:generate
```

### 4. Konfigurasi Database
Edit file `.env` dan sesuaikan konfigurasi database:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=company_profile_alat
DB_USERNAME=root
DB_PASSWORD=your_password
```

### 5. Migrasi Database
```bash
php artisan migrate --seed
```

### 6. Build Assets
```bash
npm run build
```

### 7. Storage Link
```bash
php artisan storage:link
```

### 8. Jalankan Server
```bash
php artisan serve
```

Website akan tersedia di `http://127.0.0.1:8000`

## 🗂️ Struktur Database

### Tabel Utama
- **users**: Data pengguna dengan role system
- **categories**: Kategori alat berat
- **equipment**: Data alat berat dengan spesifikasi
- **bookings**: Data pemesanan dengan status tracking
- **settings**: Pengaturan website dan perusahaan

### Relasi Database
```
users (1) -> (n) bookings
categories (1) -> (n) equipment
equipment (1) -> (n) bookings
```

## 🎨 Screenshots

### Admin Dashboard
![Admin Dashboard](docs/screenshots/admin-dashboard.png)

### Equipment Management
![Equipment Management](docs/screenshots/equipment-management.png)

### Booking System
![Booking System](docs/screenshots/booking-system.png)

### User Catalog
![User Catalog](docs/screenshots/user-catalog.png)

## 📊 Fitur Admin Detail

### 1. Dashboard
- Total alat berat, booking, dan revenue
- Statistik bulanan dan harian
- Chart performa booking
- Alat berat paling populer
- Quick access menu

### 2. Management Alat Berat
- CRUD operations lengkap
- Upload dan crop gambar
- Spesifikasi dalam format JSON
- Filter berdasarkan kategori
- Bulk actions (delete, status)

### 3. Management Booking
- View semua booking dengan pagination
- Filter berdasarkan status dan tanggal
- Approve/reject booking
- Update status booking
- Export laporan booking

### 4. Settings
- Profil perusahaan
- Informasi kontak
- Tentang kami & visi misi
- Banner dan logo website

### 5. Laporan
- Laporan penyewaan per periode
- Statistik pendapatan
- Export ke Excel dengan filter
- Grafik performa

## 🔧 Konfigurasi Lanjutan

### File Upload
```php
// config/filesystems.php
'public' => [
    'driver' => 'local',
    'root' => storage_path('app/public'),
    'url' => env('APP_URL').'/storage',
    'visibility' => 'public',
],
```

### Email Configuration
```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your_email@gmail.com
MAIL_PASSWORD=your_app_password
MAIL_ENCRYPTION=tls
```

### Cache Configuration
```bash
# Clear cache
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear

# Cache for production
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

## 🧪 Testing

### Unit Testing
```bash
php artisan test
```

### Feature Testing
```bash
php artisan test --filter=FeatureTest
```

### Browser Testing (Dusk)
```bash
composer require --dev laravel/dusk
php artisan dusk:install
php artisan dusk
```

## 🚀 Deployment

### Shared Hosting
1. Upload files ke `public_html/`
2. Update `index.php` path
3. Setup database dan import
4. Update `.env` configuration

### VPS/Dedicated Server
1. Setup web server (Nginx/Apache)
2. Configure PHP-FPM
3. Setup database
4. Configure SSL certificate
5. Setup cron jobs

Detail deployment guide tersedia di [TESTING_DEPLOYMENT.md](TESTING_DEPLOYMENT.md)

## 📚 Dokumentasi

- [Dokumentasi Sistem Admin](DOKUMENTASI_SISTEM_ADMIN.md)
- [Dokumentasi API](API_DOCUMENTATION.md)
- [Panduan Testing & Deployment](TESTING_DEPLOYMENT.md)
- [Changelog](CHANGELOG_PROJECT.md)

## 🔐 Security

- CSRF Protection
- Input Validation & Sanitization
- Role-based Authorization
- File Upload Security
- SQL Injection Prevention
- XSS Protection

## 🎓 Untuk Kerja Praktek (KP)

Proyek ini sangat cocok untuk dokumentasi Kerja Praktek dengan aspek:

1. **Analisis Sistem**: Identifikasi kebutuhan bisnis
2. **Perancangan Database**: ERD dan normalisasi
3. **Implementasi**: Coding dengan framework modern
4. **Testing**: Unit testing dan user acceptance testing
5. **Deployment**: Setup production environment

## 🤝 Contributing

1. Fork repository
2. Create feature branch (`git checkout -b feature/amazing-feature`)
3. Commit changes (`git commit -m 'Add amazing feature'`)
4. Push to branch (`git push origin feature/amazing-feature`)
5. Open Pull Request

## 📞 Support

- Email: support@rental-alat.com
- WhatsApp: +62 123 456 7890
- Website: https://rental-alat.com

## 📄 License

Proyek ini dilisensikan di bawah [MIT License](LICENSE).

## 🙏 Acknowledgments

- [Laravel Framework](https://laravel.com)
- [Bootstrap](https://getbootstrap.com)
- [Font Awesome](https://fontawesome.com)
- [Chart.js](https://www.chartjs.org)
- [Laravel Excel](https://laravel-excel.com)

---

**Dibuat dengan ❤️ menggunakan Laravel 11**

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
