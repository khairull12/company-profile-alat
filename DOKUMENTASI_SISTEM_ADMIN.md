# 📋 DOKUMENTASI SISTEM ADMIN - Website Alat Berat

## 🎯 Overview Sistem

Website ini adalah sistem manajemen penyewaan alat berat (Tronton, Excavator, dll) yang dibangun dengan **Laravel 11** dan **MySQL**. Sistem ini memiliki dua level akses:

- **Admin**: Mengelola seluruh sistem
- **User**: Melihat katalog dan melakukan booking

---

## 🔧 Teknologi yang Digunakan

- **Framework**: Laravel 11
- **Database**: MySQL
- **Frontend**: Bootstrap 5, Blade Template
- **Authentication**: Laravel Breeze
- **Export**: Laravel Excel (maatwebsite/excel)
- **CSS Framework**: Tailwind CSS
- **JavaScript**: Chart.js (untuk statistik)

---

## 🚀 Instalasi & Setup

### 1. Clone Repository
```bash
git clone [repository-url]
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

### 4. Setup Database
```bash
php artisan migrate
php artisan db:seed
```

### 5. Build Assets
```bash
npm run build
```

### 6. Jalankan Server
```bash
php artisan serve
```

---

## 👤 Akun Default

### Admin
- **Email**: admin@admin.com
- **Password**: password
- **Role**: admin

### User Testing
- **Email**: user@test.com
- **Password**: password
- **Role**: user

---

## 🏗️ Struktur Database

### Tabel Utama

#### 1. users
```sql
- id (PK)
- name
- email
- password
- role (enum: admin, user)
- created_at, updated_at
```

#### 2. categories
```sql
- id (PK)
- name
- slug
- description
- created_at, updated_at
```

#### 3. equipment
```sql
- id (PK)
- name
- slug
- category_id (FK)
- description
- specifications (JSON)
- price_per_day
- stock
- image
- is_active
- created_at, updated_at
```

#### 4. bookings
```sql
- id (PK)
- user_id (FK)
- equipment_id (FK)
- start_date
- end_date
- total_days
- total_price
- status (enum: pending, confirmed, rejected, completed)
- notes
- created_at, updated_at
```

#### 5. settings
```sql
- id (PK)
- key
- value
- type
- description
- created_at, updated_at
```

---

## 🔐 Sistem Autentikasi

### Middleware
- **auth**: Mengecek apakah user sudah login
- **is_admin**: Mengecek apakah user memiliki role admin

### Route Protection
```php
Route::middleware(['auth', 'is_admin'])->prefix('admin')->group(function () {
    // Admin routes
});
```

---

## 📊 Fitur Admin

### 1. Dashboard
- **URL**: `/admin/dashboard`
- **Fitur**:
  - Total alat berat
  - Total booking hari ini/bulan ini
  - Total pendapatan
  - Statistik booking per bulan
  - Alat paling populer
  - Shortcut menu

### 2. Manajemen Alat Berat
- **URL**: `/admin/equipment`
- **Fitur**:
  - CRUD alat berat
  - Upload gambar
  - Manajemen stok
  - Filter berdasarkan kategori
  - Search berdasarkan nama

### 3. Manajemen Booking
- **URL**: `/admin/bookings`
- **Fitur**:
  - Lihat semua booking
  - Filter berdasarkan status/tanggal
  - Konfirmasi/tolak booking
  - Update status booking
  - Lihat detail booking

### 4. Laporan & Rekapitulasi
- **URL**: `/admin/reports`
- **Fitur**:
  - Laporan penyewaan
  - Filter per periode
  - Export ke Excel
  - Statistik pendapatan
  - Laporan per alat

### 5. Pengaturan
- **URL**: `/admin/settings`
- **Fitur**:
  - Profil perusahaan
  - Tentang kami
  - Visi & misi
  - Kontak perusahaan
  - Banner website

---

## 🎨 Struktur View

### Admin Layout
```
resources/views/admin/
├── layouts/
│   └── app.blade.php
├── dashboard.blade.php
├── equipment/
│   ├── index.blade.php
│   ├── create.blade.php
│   └── edit.blade.php
├── bookings/
│   ├── index.blade.php
│   └── show.blade.php
├── settings/
│   ├── index.blade.php
│   └── edit.blade.php
└── reports/
    └── index.blade.php
```

### Public Views
```
resources/views/
├── layouts/
│   └── app.blade.php
├── welcome.blade.php
├── home.blade.php
├── dashboard.blade.php
├── equipment/
│   ├── index.blade.php
│   └── show.blade.php
└── bookings/
    ├── index.blade.php
    └── create.blade.php
```

---

## 🔧 Controller Structure

### Admin Controllers
```
app/Http/Controllers/Admin/
├── AdminController.php (Dashboard)
├── AdminEquipmentController.php
├── AdminBookingController.php
├── AdminSettingController.php
└── AdminReportController.php
```

### Public Controllers
```
app/Http/Controllers/
├── HomeController.php
├── EquipmentController.php
└── BookingController.php
```

---

## 📈 Fitur Export

### Excel Export
- **Package**: maatwebsite/excel
- **Class**: `App\Exports\BookingsExport`
- **Fitur**: Export laporan booking ke Excel dengan filter

### PDF Export (Opsional)
- **Package**: barryvdh/laravel-dompdf
- **Fitur**: Export laporan ke PDF

---

## 🛠️ Seeder Data

### AdminUserSeeder
- Membuat akun admin default

### CategorySeeder
- Kategori: Tronton, Excavator, Bulldozer, Crane, dll

### EquipmentSeeder
- Data alat berat sample dengan gambar

### SettingSeeder
- Pengaturan dasar website

---

## 📱 Responsive Design

- **Mobile First**: Tampilan responsif di semua device
- **Bootstrap 5**: Grid system dan components
- **Tailwind CSS**: Utility-first CSS framework

---

## 🔍 Testing & Debug

### Test Routes
```php
Route::get('/test/admin-login', function () {
    Auth::loginUsingId(1);
    return redirect('/admin/dashboard');
});

Route::get('/test/data', function () {
    return [
        'users' => User::count(),
        'equipment' => Equipment::count(),
        'bookings' => Booking::count(),
    ];
});
```

### Debugging
- Log file: `storage/logs/laravel.log`
- Debug mode: Set `APP_DEBUG=true` di `.env`

---

## 📝 Dokumentasi Kerja Praktek

Sistem ini cocok untuk dokumentasi KP dengan aspek:

1. **Analisis Sistem**: Identifikasi kebutuhan penyewaan alat berat
2. **Perancangan Database**: ERD dan normalisasi database
3. **Implementasi**: Coding dengan Laravel framework
4. **Testing**: Unit test dan integration test
5. **Deployment**: Setup production server

---

## 🚧 Pengembangan Selanjutnya

### Fitur Tambahan
- [ ] Notifikasi email untuk booking
- [ ] Payment gateway integration
- [ ] Chat system antara admin dan user
- [ ] Mobile app dengan API
- [ ] Advanced reporting dengan grafik

### Optimasi
- [ ] Caching untuk performa
- [ ] Image optimization
- [ ] Database indexing
- [ ] Load balancing

---

## 📞 Support & Maintenance

### Regular Tasks
- Backup database harian
- Monitor log errors
- Update dependencies
- Security patches

### Monitoring
- Server resource usage
- Database performance
- User activity logs
- Error tracking

---

## 📚 Referensi

- [Laravel Documentation](https://laravel.com/docs)
- [Bootstrap Documentation](https://getbootstrap.com/docs)
- [MySQL Documentation](https://dev.mysql.com/doc)
- [Laravel Excel](https://docs.laravel-excel.com)

---

**Dibuat untuk tugas Kerja Praktek (KP)**  
**Sistem Manajemen Penyewaan Alat Berat**  
**Tahun: 2025**
