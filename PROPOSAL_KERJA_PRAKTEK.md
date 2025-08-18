# 📋 PROPOSAL KERJA PRAKTEK
## Sistem Informasi Manajemen Penyewaan Alat Berat PT. Dhiva Sarana Transport Konstruksi

---

## 📖 **BAB I - PENDAHULUAN**

### 1.1 Latar Belakang
PT. Dhiva Sarana Transport Konstruksi adalah perusahaan yang bergerak di bidang penyewaan alat berat untuk mendukung proyek-proyek konstruksi di Indonesia. Didirikan pada tahun 2008, perusahaan ini telah melayani lebih dari 750 proyek dengan tingkat kepuasan klien mencapai 99%.

Dalam era digitalisasi, perusahaan membutuhkan sistem informasi yang dapat mengelola bisnis penyewaan alat berat secara efisien. Sistem konvensional yang masih menggunakan pencatatan manual sering menimbulkan masalah seperti:
- Kesulitan dalam tracking ketersediaan alat berat
- Pencatatan booking yang tidak terorganisir
- Laporan yang sulit dibuat dan dianalisis
- Informasi company profile yang tidak terintegrasi

### 1.2 Rumusan Masalah
1. Bagaimana merancang sistem informasi yang dapat mengelola data alat berat secara efisien?
2. Bagaimana mengimplementasikan sistem pencatatan booking yang terstruktur?
3. Bagaimana membuat dashboard analytics untuk mendukung pengambilan keputusan bisnis?
4. Bagaimana mengintegrasikan company profile dengan sistem manajemen internal?

### 1.3 Tujuan
**Tujuan Umum:**
Membangun Sistem Informasi Manajemen Penyewaan Alat Berat yang dapat meningkatkan efisiensi operasional PT. Dhiva Sarana Transport Konstruksi.

**Tujuan Khusus:**
1. Menganalisis kebutuhan sistem informasi untuk bisnis penyewaan alat berat
2. Merancang database yang optimal untuk mengelola data equipment dan booking
3. Mengimplementasikan sistem admin panel untuk manajemen internal
4. Mengembangkan company profile website yang profesional
5. Membuat sistem laporan dan analytics untuk business intelligence

### 1.4 Manfaat
**Bagi Perusahaan:**
- Meningkatkan efisiensi operasional
- Memperbaiki sistem pencatatan dan tracking
- Menyediakan data analytics untuk decision making
- Meningkatkan professional image melalui website

**Bagi Mahasiswa:**
- Menerapkan ilmu pemrograman web dengan Laravel
- Memahami proses bisnis industri rental equipment
- Belajar analisis sistem dan perancangan database
- Mengembangkan skill project management

---

## 📊 **BAB II - TINJAUAN PUSTAKA**

### 2.1 Sistem Informasi Manajemen
Sistem Informasi Manajemen (SIM) adalah sistem yang mengintegrasikan antara manusia dan mesin untuk menyediakan informasi guna mendukung operasi, manajemen, dan fungsi pengambilan keputusan dalam organisasi.

### 2.2 Laravel Framework
Laravel adalah framework PHP open-source yang menggunakan konsep Model-View-Controller (MVC). Laravel menyediakan fitur-fitur seperti:
- Eloquent ORM untuk database management
- Blade templating engine
- Authentication dan authorization
- Migration dan seeding
- Artisan command line interface

### 2.3 Industri Penyewaan Alat Berat
Industri penyewaan alat berat di Indonesia mengalami pertumbuhan yang signifikan seiring dengan perkembangan sektor konstruksi. Kebutuhan akan sistem informasi yang efisien menjadi crucial untuk mengelola aset yang bernilai tinggi.

---

## 🏢 **BAB III - GAMBARAN UMUM PERUSAHAAN**

### 3.1 Profil Perusahaan
- **Nama**: PT. Dhiva Sarana Transport Konstruksi
- **Tahun Berdiri**: 2008
- **Bidang Usaha**: Penyewaan Alat Berat
- **Pengalaman**: 15+ tahun melayani industri konstruksi
- **Jangkauan**: Seluruh Indonesia

### 3.2 Visi dan Misi
**Visi:**
Menjadi perusahaan penyewaan alat berat terdepan di Indonesia dengan teknologi modern dan pelayanan profesional.

**Misi:**
- Menyediakan alat berat berkualitas tinggi
- Memberikan pelayanan maintenance terbaik
- Membangun kemitraan jangka panjang dengan klien
- Menggunakan teknologi untuk efisiensi operasional

### 3.3 Prestasi Perusahaan
- **200+** Unit alat berat tersedia
- **750+** Proyek berhasil diselesaikan  
- **99%** Tingkat kepuasan klien
- **15+** Tahun pengalaman industri

---

## 💻 **BAB IV - ANALISIS DAN PERANCANGAN SISTEM**

### 4.1 Analisis Kebutuhan Sistem

#### 4.1.1 Kebutuhan Fungsional
1. **Manajemen Equipment**
   - CRUD data alat berat
   - Upload multiple images
   - Management kategori
   - Tracking status ketersediaan

2. **Manajemen Booking**
   - Pencatatan booking oleh admin
   - Update status booking
   - Kalkulasi harga otomatis
   - Generate booking code unik

3. **Dashboard & Analytics**
   - Statistik real-time
   - Chart performa bulanan
   - Key Performance Indicators
   - Export laporan

4. **Company Profile**
   - Homepage profesional
   - Katalog equipment publik
   - Contact information
   - About us & company history

#### 4.1.2 Kebutuhan Non-Fungsional
- **Performance**: Response time < 3 detik
- **Security**: Authentication, authorization, CSRF protection
- **Usability**: User-friendly interface dengan Bootstrap
- **Scalability**: Arsitektur yang dapat berkembang
- **Reliability**: System uptime > 99%

### 4.2 Perancangan Database

#### 4.2.1 Entity Relationship Diagram (ERD)
```
[users] ──────┐
              │ 1:N
              ▼
[categories] ──────┐ 1:N
                   ▼
[equipment] ────────┐ 1:N
                    ▼
[bookings]

[settings] (standalone)
```

#### 4.2.2 Struktur Tabel Utama

**Tabel `equipment`**
- id (Primary Key)
- category_id (Foreign Key)
- name, brand, model
- description, specifications (JSON)
- price_per_day, stock
- images (JSON array)
- status (active/inactive)
- timestamps

**Tabel `bookings`**
- id (Primary Key)
- booking_code (Unique)
- equipment_id (Foreign Key)
- customer_name, email, phone
- company_name, project_location
- start_date, end_date, duration_days
- rental_price, total_price
- status (pending/confirmed/ongoing/completed/cancelled)
- timestamps

**Tabel `categories`**
- id (Primary Key)
- name, slug, description
- image, is_active
- timestamps

### 4.3 Perancangan Arsitektur Sistem

#### 4.3.1 Arsitektur MVC
```
┌─────────────────┐    ┌─────────────────┐    ┌─────────────────┐
│     VIEW        │    │   CONTROLLER    │    │     MODEL       │
│                 │    │                 │    │                 │
│ ► Blade Templates│◄──►│ ► Admin Ctrl    │◄──►│ ► Equipment     │
│ ► Bootstrap UI  │    │ ► Home Ctrl     │    │ ► Booking       │
│ ► Responsive    │    │ ► Equipment Ctrl│    │ ► Category      │
└─────────────────┘    └─────────────────┘    └─────────────────┘
```

#### 4.3.2 Flow Sistem
```
┌─────────────┐    ┌─────────────┐    ┌─────────────┐
│  CUSTOMER   │    │    ADMIN    │    │  DATABASE   │
│             │    │             │    │             │
│Browse Catalog│    │Admin Panel  │    │Store Data   │
│View Details │────│Create Booking│────│Generate     │
│Contact Admin│    │Manage Status│    │Reports      │
└─────────────┘    └─────────────┘    └─────────────┘
```

---

## 🛠️ **BAB V - IMPLEMENTASI SISTEM**

### 5.1 Teknologi yang Digunakan

#### 5.1.1 Backend Technology Stack
- **Framework**: Laravel 11
- **Language**: PHP 8.1+
- **Database**: MySQL 5.7+
- **Authentication**: Laravel Breeze
- **ORM**: Eloquent

#### 5.1.2 Frontend Technology Stack
- **CSS Framework**: Bootstrap 5
- **Additional**: Tailwind CSS (partial)
- **JavaScript**: Vanilla JS, Chart.js
- **Icons**: Font Awesome 6
- **Template Engine**: Blade

#### 5.1.3 Development Tools
- **Environment**: Laragon (Windows)
- **Code Editor**: VS Code
- **Version Control**: Git
- **Package Manager**: Composer, NPM

### 5.2 Struktur Project
```
company-profile-alat/
├── app/
│   ├── Http/Controllers/
│   │   ├── AdminBookingController.php
│   │   ├── HomeController.php
│   │   ├── EquipmentController.php
│   │   └── Admin/
│   ├── Models/
│   │   ├── Equipment.php
│   │   ├── Booking.php
│   │   ├── Category.php
│   │   └── Setting.php
│   └── ...
├── database/
│   ├── migrations/
│   └── seeders/
├── resources/
│   ├── views/
│   │   ├── admin/
│   │   ├── equipment/
│   │   ├── layouts/
│   │   └── ...
│   └── ...
├── routes/
│   └── web.php
└── ...
```

### 5.3 Fitur yang Diimplementasikan

#### 5.3.1 Admin Panel Features
1. **Dashboard Analytics**
   - Real-time statistics (total equipment, bookings, revenue)
   - Monthly performance charts
   - Quick action buttons
   - Recent bookings overview

2. **Equipment Management**
   - CRUD operations untuk alat berat
   - Multiple image upload dengan preview
   - Category management
   - Stock tracking dan status

3. **Booking Management**
   - Form input booking baru
   - List all bookings dengan pagination
   - Update status booking
   - Delete booking functionality
   - Monthly dan custom date reports

4. **Settings Management**
   - Company profile configuration
   - Website statistics settings
   - Contact information management

#### 5.3.2 Public Website Features
1. **Homepage**
   - Hero section dengan company branding
   - Statistics showcase
   - Equipment search form
   - About company preview

2. **Equipment Catalog**
   - Grid view dengan filter capabilities
   - Search by name, category
   - Pagination untuk performance
   - Equipment cards dengan key information

3. **Equipment Detail**
   - Image gallery dengan carousel
   - Detailed specifications
   - Pricing information
   - Contact actions (phone, email)
   - Related equipment suggestions

4. **Company Pages**
   - About us dengan company history
   - Vision & mission
   - Contact information dengan maps
   - Services overview

---

## 📈 **BAB VI - TESTING DAN EVALUASI**

### 6.1 Testing Strategy

#### 6.1.1 Unit Testing
- Model validation testing
- Controller logic testing
- Database relationship testing

#### 6.1.2 Integration Testing
- Admin panel functionality
- Public website features
- Database operations
- File upload mechanisms

#### 6.1.3 User Acceptance Testing
- Admin workflow testing
- Public user experience
- Cross-browser compatibility
- Mobile responsiveness

### 6.2 Performance Evaluation

#### 6.2.1 Metrics
- **Page Load Speed**: < 3 seconds
- **Database Queries**: Optimized dengan eager loading
- **Image Loading**: Lazy loading implementation
- **Memory Usage**: Efficient resource management

#### 6.2.2 Security Assessment
- CSRF token validation
- Input sanitization
- File upload security
- Authentication protection
- SQL injection prevention

---

## 🎯 **BAB VII - KESIMPULAN DAN SARAN**

### 7.1 Kesimpulan
1. Sistem Informasi Manajemen Penyewaan Alat Berat telah berhasil dibangun menggunakan Laravel framework
2. Sistem dapat mengelola data equipment, booking, dan menghasilkan reports secara efisien
3. Admin panel menyediakan dashboard analytics untuk mendukung decision making
4. Company profile website meningkatkan professional image perusahaan
5. Sistem keamanan dan performance telah dioptimalkan sesuai standar

### 7.2 Saran Pengembangan

#### 7.2.1 Short Term
- Implementasi WhatsApp API untuk komunikasi customer
- Email notification untuk status booking
- Mobile app untuk admin
- Advanced reporting dengan export Excel/PDF

#### 7.2.2 Long Term
- Equipment tracking dengan IoT integration
- Online payment gateway integration
- Customer portal untuk self-service
- Maintenance scheduling system
- GPS tracking untuk equipment location

---

## 📋 **LAMPIRAN**

### A. Screenshots Sistem
- Dashboard admin
- Equipment management
- Booking management
- Public website pages

### B. Source Code Structure
- Controller implementations
- Model relationships
- Migration files
- Blade templates

### C. Database Schema
- ERD diagram
- Table structures
- Relationship definitions

### D. User Manual
- Admin panel guide
- Public website navigation
- Troubleshooting guide

---

## 👥 **TIM PENGEMBANG**

**Mahasiswa Kerja Praktek:**
- Nama: [Nama Anda]
- NIM: [NIM Anda]
- Program Studi: [Program Studi]
- Universitas: [Nama Universitas]

**Pembimbing Perusahaan:**
- PT. Dhiva Sarana Transport Konstruksi

**Pembimbing Akademik:**
- [Nama Dosen Pembimbing]

---

## 📅 **JADWAL PELAKSANAAN**

| Minggu | Kegiatan | Output |
|--------|----------|--------|
| 1-2 | Analisis kebutuhan & studi literatur | Dokumen analisis |
| 3-4 | Perancangan database & UI/UX | ERD & mockup |
| 5-6 | Implementasi backend (Models, Controllers) | Core functionality |
| 7-8 | Implementasi frontend (Views, Layouts) | User interface |
| 9-10 | Testing, debugging, dan deployment | Working system |
| 11-12 | Dokumentasi dan presentasi | Final report |

---

**Proposal ini memberikan gambaran lengkap tentang project Sistem Informasi Manajemen Penyewaan Alat Berat yang cocok untuk Kerja Praktek dengan tingkat kompleksitas yang sesuai untuk mahasiswa tingkat akhir.**
