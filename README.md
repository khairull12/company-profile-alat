# 🚚 Sistem Manajemen Penyewaan Alat Berat - PT. Dhiva Sarana Transport Konstruksi

<p align="center">
    <img src="https://img.shields.io/badge/Laravel-11-red.svg" alt="Laravel 11">
    <img src="https://img.shields.io/badge/PHP-8.1+-blue.svg" alt="PHP 8.1+">
    <img src="https://img.shields.io/badge/MySQL-5.7+-orange.svg" alt="MySQL 5.7+">
    <img src="https://img.shields.io/badge/Bootstrap-5-purple.svg" alt="Bootstrap 5">
    <img src="https://img.shields.io/badge/License-MIT-green.svg" alt="License MIT">
</p>

## 📋 Deskripsi Proyek

**Sistem Informasi Manajemen Penyewaan Alat Berat** yang dirancang khusus untuk PT. Dhiva Sarana Transport Konstruksi. Sistem ini menggunakan konsep **Admin-Only Booking** dimana customer tidak dapat melakukan booking online secara langsung, melainkan menghubungi admin terlebih dahulu melalui telepon atau email.

### 🎯 **Konsep Admin-Only System**
- ❌ **TIDAK ADA** proses booking online dari customer
- ✅ **HANYA ADMIN** yang dapat melakukan pencatatan booking  
- 📞 **Customer menghubungi** admin via phone/email untuk booking
- 🏢 **Personal service** sesuai dengan karakter bisnis perusahaan

### 🎯 Fitur Utama

#### 👨‍💼 Admin Dashboard
- **Dashboard Analitik**: Real-time analytics dengan chart dan KPI perusahaan
- **Management Alat Berat**: CRUD lengkap dengan upload gambar dan spesifikasi detail
- **Management Booking Admin-Only**: Input booking customer via admin panel
- **Management Pengaturan**: Konfigurasi company profile dan statistik website  
- **Laporan & Analitik**: Export booking reports dengan filter dan visualisasi chart
- **Authentication**: Secure admin login system

#### 👤 Customer Interface (Browse-Only)
- **Homepage**: Company profile PT. Dhiva Sarana dengan prestasi dan statistik
- **Katalog Alat**: Browse dan search katalog alat berat tersedia
- **Detail Equipment**: Spesifikasi lengkap, harga, dan informasi kontak
- **About Company**: Sejarah, visi misi, dan values perusahaan
- **Contact Actions**: Tombol untuk menghubungi admin via phone/email
- **Responsive Design**: Optimized untuk desktop dan mobile

#### 🔒 Admin-Only Booking Flow
```
Customer Browse → Contact Admin → Admin Input Booking → Manage Status → Reports
```

### 🚀 Demo Akun & Quick Access

| Role | Email | Password | URL |
|------|-------|----------|-----|
| Admin | admin@admin.com | password | `/admin/dashboard` |
| Auto Login | - | - | `/auto-login-admin` |

**Homepage**: [http://127.0.0.1:8000](http://127.0.0.1:8000)  
**Admin Panel**: [http://127.0.0.1:8000/admin/dashboard](http://127.0.0.1:8000/admin/dashboard)

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

## 🗂️ Struktur Database (Admin-Only System)

### Tabel Utama
- **users**: Data admin dengan authentication system
- **categories**: Kategori alat berat (Excavator, Tronton, Bulldozer, dll)
- **equipment**: Data alat berat dengan spesifikasi lengkap
- **bookings**: Data booking customer (input oleh admin)
- **settings**: Pengaturan company profile dan statistik website

### Admin-Only Booking Table
```sql
bookings:
- booking_code (unique: BK-XXXXXXXX)
- equipment_id (foreign key to equipment)
- customer_name, customer_email, customer_phone
- company_name, project_location
- start_date, end_date, duration_days
- project_description, special_requirements
- rental_price, total_price
- status (pending|confirmed|ongoing|completed|cancelled)
- created_by (admin_id)
```

### Relasi Database
```
users (1) -> (n) equipment (created_by)
users (1) -> (n) bookings (created_by - admin)
categories (1) -> (n) equipment
equipment (1) -> (n) bookings
```

## 📊 Sistem Laporan & Analitik

### Dashboard Analytics
- **Company KPI**: Total alat, booking aktif, revenue, dan equipment availability
- **Monthly Trends**: Grafik booking dan revenue dalam 12 bulan terakhir  
- **Category Performance**: Chart distribusi booking per kategori alat
- **Booking Analytics**: Status booking, project locations, dan customer analytics

### Admin Booking Reports
- **Filter Berdasarkan**: Tanggal, equipment, customer, dan status
- **Export Data**: CSV/Excel format untuk analisis finansial
- **Booking Metrics**: Success rate, average rental duration, popular equipment
- **Revenue Analysis**: Monthly revenue, profit margins, dan growth trends

### Company Analytics  
- **Equipment Utilization**: Tracking penggunaan dan ROI per alat
- **Customer Analytics**: Customer retention, project types, location analysis
- **Performance Dashboard**: Real-time business metrics untuk management
- **Inventory Insights**: Equipment maintenance schedule dan availability forecast

## 🎨 Screenshots

### Admin Dashboard
![Admin Dashboard](docs/screenshots/admin-dashboard.png)

### Equipment Management
![Equipment Management](docs/screenshots/equipment-management.png)

### Booking System
![Booking System](docs/screenshots/booking-system.png)

### User Catalog
![User Catalog](docs/screenshots/user-catalog.png)

## 📊 Admin Panel Features Detail

### 1. Dashboard
- Total equipment, active bookings, dan monthly revenue
- Statistik booking per bulan dan category performance
- Chart revenue trends dan equipment utilization rate
- Recent bookings dan quick access untuk admin actions
- Company performance metrics real-time

### 2. Equipment Management
- CRUD operations lengkap untuk semua alat berat
- Upload dan crop gambar dengan multiple photos
- Spesifikasi detail dalam format JSON structure
- Filter berdasarkan kategori dan availability status
- Bulk actions (delete, update status, export data)

### 3. Admin-Only Booking Management
- Input booking baru dari customer contact
- View semua booking dengan advanced pagination
- Filter berdasarkan status, date range, dan equipment
- Update status booking (pending → confirmed → ongoing → completed)
- Generate booking reports dan export ke Excel

### 4. Company Settings
- Update profil PT. Dhiva Sarana Transport Konstruksi
- Manage company contact information dan location
- Edit about us, visi misi, dan company values
- Upload company logo dan hero banner images
- Configure website statistics dan achievements

### 5. Reports & Analytics
- Comprehensive booking reports per periode tertentu
- Revenue analytics dengan profit margin calculation
- Equipment performance dan utilization reports
- Customer analytics dan project location mapping
- Export semua data ke Excel dengan advanced filtering

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

## 📚 Dokumentasi Lengkap

- **[PROPOSAL_KERJA_PRAKTEK.md](PROPOSAL_KERJA_PRAKTEK.md)** - Proposal lengkap untuk kerja praktek
- **[ADMIN_ONLY_BOOKING_SYSTEM.md](ADMIN_ONLY_BOOKING_SYSTEM.md)** - Arsitektur sistem admin-only
- **[DOKUMENTASI_SISTEM_ADMIN.md](DOKUMENTASI_SISTEM_ADMIN.md)** - Panduan penggunaan admin panel
- **[BUG_FIX_REPORT.md](BUG_FIX_REPORT.md)** - Technical issues dan solusi yang diimplementasi
- **[BOOKING_SYSTEM_DOCUMENTATION.md](BOOKING_SYSTEM_DOCUMENTATION.md)** - User guide booking system

## 🔐 Security

- CSRF Protection
- Input Validation & Sanitization
- Role-based Authorization
- File Upload Security
- SQL Injection Prevention
- XSS Protection

## 🎓 Perfect for Internship & Final Project

Proyek ini sangat cocok untuk:

### **Kerja Praktek (KP) / Magang**
- **Business Process Analysis**: Analisis kebutuhan perusahaan rental equipment
- **Database Design**: ERD design dan normalisasi untuk admin-only system
- **Laravel Development**: Full-stack development dengan framework modern
- **Real Business Implementation**: Sistem yang applicable untuk perusahaan nyata

### **Final Project / Skripsi**
- **System Analysis & Design**: Complete SDLC documentation
- **Technology Implementation**: Laravel 11, PHP 8.1+, MySQL, Bootstrap 5
- **Admin-Only Architecture**: Unique business model implementation
- **Business Intelligence**: Dashboard analytics dan reporting system

### **Learning Outcomes**
1. **Laravel Framework**: MVC architecture, Eloquent ORM, Blade templating
2. **Database Management**: Migration, seeding, relationships, optimization
3. **Authentication**: Admin login system dan middleware authorization  
4. **File Management**: Image upload, storage linking, file processing
5. **Reporting System**: Export data, filtering, chart generation
6. **Business Logic**: Equipment rental business process automation
7. **UI/UX Design**: Responsive design dengan Bootstrap dan custom CSS
8. **API Development**: RESTful concepts dan data handling

### **Documentation for Academic Purpose**
- **[PROPOSAL_KERJA_PRAKTEK.md](PROPOSAL_KERJA_PRAKTEK.md)** - Complete academic proposal
- **[ADMIN_ONLY_BOOKING_SYSTEM.md](ADMIN_ONLY_BOOKING_SYSTEM.md)** - Technical architecture  
- **[DOKUMENTASI_SISTEM_ADMIN.md](DOKUMENTASI_SISTEM_ADMIN.md)** - User manual & system guide
- **[BUG_FIX_REPORT.md](BUG_FIX_REPORT.md)** - Technical challenges & solutions

## 🤝 Contributing

1. Fork repository
2. Create feature branch (`git checkout -b feature/amazing-feature`)
3. Commit changes (`git commit -m 'Add amazing feature'`)
4. Push to branch (`git push origin feature/amazing-feature`)
5. Open Pull Request

## 📞 Contact & Support

### **PT. Dhiva Sarana Transport Konstruksi**
- **📧 Email**: admin@dhivasarana.com
- **📱 WhatsApp**: +62 812 3456 7890  
- **🌐 Website**: https://dhivasarana.com
- **📍 Location**: Jakarta, Indonesia

### **Developer**
- **GitHub**: [@khairull12](https://github.com/khairull12)
- **Repository**: [company-profile-alat](https://github.com/khairull12/company-profile-alat)
- **Issues**: [GitHub Issues](https://github.com/khairull12/company-profile-alat/issues)

## 📄 License

Proyek ini dilisensikan di bawah [MIT License](LICENSE).

## 🙏 Acknowledgments

- [Laravel Framework](https://laravel.com)
- [Bootstrap](https://getbootstrap.com)
- [Font Awesome](https://fontawesome.com)
- [Chart.js](https://www.chartjs.org)
- [Laravel Excel](https://laravel-excel.com)

---

<div align="center">

**🚚 Built with ❤️ for PT. Dhiva Sarana Transport Konstruksi**

*Empowering Heavy Equipment Rental Business with Modern Technology*

**Admin-Only Booking System | Laravel 11 | Professional Grade**

[![GitHub stars](https://img.shields.io/github/stars/khairull12/company-profile-alat.svg?style=social&label=Star)](https://github.com/khairull12/company-profile-alat)
[![GitHub forks](https://img.shields.io/github/forks/khairull12/company-profile-alat.svg?style=social&label=Fork)](https://github.com/khairull12/company-profile-alat/fork)

</div>

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
