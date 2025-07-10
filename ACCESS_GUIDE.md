# 🚀 CARA MENGAKSES WEB DAN ADMIN - PANDUAN LENGKAP

## 🌐 **AKSES WEB (Public)**

### **1. Halaman Utama Web**
```
🔗 URL: http://localhost:8000/
📋 Deskripsi: Halaman beranda website
🔓 Status: Public (tidak perlu login)
```

### **2. Test Booking Form**
```
🔗 URL: http://localhost:8000/test-booking/1
📋 Deskripsi: Form booking modern (equipment ID 1)
🔓 Status: Public test page
🎯 Fitur: Form booking dengan validasi, price calculator, dll
```

### **3. Test Booking Lainnya**
```
🔗 URL: http://localhost:8000/test-booking/2  (Equipment ID 2)
🔗 URL: http://localhost:8000/test-booking/3  (Equipment ID 3)
🔗 URL: http://localhost:8000/test-booking/4  (Equipment ID 4)
```

### **4. Debug Information**
```
🔗 URL: http://localhost:8000/debug-admin
📋 Deskripsi: Informasi database dan admin user
🔓 Status: Public (untuk development)
```

## 🔐 **AKSES ADMIN (Requires Authentication)**

### **METHOD 1: Auto Login Admin (Termudah)**
```
🔗 URL: http://localhost:8000/auto-login-admin
📋 Deskripsi: Otomatis login sebagai admin
✅ Langkah:
   1. Klik URL tersebut
   2. Otomatis login dan redirect ke admin dashboard
   3. Siap menggunakan fitur admin
```

### **METHOD 2: Manual Login**
```
🔗 URL: http://localhost:8000/login
📋 Deskripsi: Halaman login manual
🔑 Kredensial Admin:
   Email: admin@admin.com
   Password: password
   
✅ Langkah:
   1. Buka http://localhost:8000/login
   2. Masukkan email dan password admin
   3. Klik Login
   4. Akan redirect ke dashboard
```

### **METHOD 3: Register User Baru**
```
🔗 URL: http://localhost:8000/register
📋 Deskripsi: Daftar sebagai user baru
⚠️ Note: User baru default role 'user', bukan admin
```

## 🛡️ **ADMIN DASHBOARD & FITUR**

### **Setelah Login Admin, Akses:**

#### **1. Admin Dashboard**
```
🔗 URL: http://localhost:8000/admin/dashboard
📊 Fitur:
   ✅ Statistik total equipment
   ✅ Statistik total bookings
   ✅ Statistik total revenue
   ✅ Chart dan analytics
```

#### **2. Admin Settings**
```
🔗 URL: http://localhost:8000/admin/settings
⚙️ Fitur:
   ✅ Manage website settings
   ✅ Company information
   ✅ Contact details
   ✅ Upload images
```

#### **3. Equipment Management**
```
🔗 URL: http://localhost:8000/admin/equipment
🚧 Fitur:
   ✅ List all equipment
   ✅ Add new equipment
   ✅ Edit equipment
   ✅ Delete equipment
```

#### **4. Booking Management**
```
🔗 URL: http://localhost:8000/admin/bookings
📅 Fitur:
   ✅ List all bookings
   ✅ View booking details
   ✅ Confirm bookings
   ✅ Cancel bookings
```

#### **5. Reports**
```
🔗 URL: http://localhost:8000/admin/reports
📈 Fitur:
   ✅ Booking reports
   ✅ Revenue reports
   ✅ Export data
```

## 🧪 **TEST CREDENTIALS**

### **Admin User:**
```
Email: admin@admin.com
Password: password
Role: admin
Access: Full admin panel
```

### **Regular User (if needed):**
```
Buat melalui: http://localhost:8000/register
Role: user (default)
Access: User dashboard only
```

## 🚀 **QUICK START GUIDE**

### **Untuk Akses Admin (Tercepat):**
1. **Start Server**: `php artisan serve --host=0.0.0.0 --port=8000`
2. **Auto Login**: Buka `http://localhost:8000/auto-login-admin`
3. **Ready**: Langsung masuk admin dashboard!

### **Untuk Test Booking Form:**
1. **Start Server**: `php artisan serve --host=0.0.0.0 --port=8000`
2. **Open Test Form**: Buka `http://localhost:8000/test-booking/1`
3. **Test Features**: Coba semua fitur form booking

## 🔧 **TROUBLESHOOTING**

### **Jika Admin Login Gagal:**
```bash
# 1. Cek database users
cd c:\laragon\www\company-profile-alat
php artisan tinker --execute="echo App\Models\User::where('role', 'admin')->count();"

# 2. Reset admin password
php artisan tinker --execute="App\Models\User::where('email', 'admin@admin.com')->update(['password' => Hash::make('password')]);"

# 3. Seed admin user lagi
php artisan db:seed --class=AdminUserSeeder
```

### **Jika Route Tidak Ditemukan:**
```bash
# Clear cache
php artisan route:clear
php artisan config:clear
php artisan view:clear
```

### **Jika Database Error:**
```bash
# Migrate database
php artisan migrate

# Seed data
php artisan db:seed
```

## 📱 **NAVIGATION MENU**

### **Admin Navigation (Setelah Login):**
- 🏠 Dashboard
- ⚙️ Settings  
- 🚧 Equipment Management
- 📅 Booking Management
- 📊 Reports
- 👤 Profile
- 🚪 Logout

### **Web Navigation:**
- 🏠 Beranda
- 🔧 Katalog Alat
- 📅 Booking Saya (perlu login)
- 🔑 Login/Register

## 🎯 **RINGKASAN URL PENTING**

### **Web Access:**
- **Home**: `http://localhost:8000/`
- **Test Booking**: `http://localhost:8000/test-booking/1`

### **Admin Access:**
- **Auto Login**: `http://localhost:8000/auto-login-admin`
- **Manual Login**: `http://localhost:8000/login`
- **Dashboard**: `http://localhost:8000/admin/dashboard`
- **Settings**: `http://localhost:8000/admin/settings`

### **Development:**
- **Debug Info**: `http://localhost:8000/debug-admin`
- **Test Admin**: `http://localhost:8000/test-admin`

---

**Status**: ✅ READY TO USE
**Admin Email**: admin@admin.com
**Admin Password**: password
**Port**: 8000
