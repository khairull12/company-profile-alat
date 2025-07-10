# 🌐 PORT CONFIGURATION - Admin vs Web

## 📋 **CURRENT CONFIGURATION**

### **Server Configuration:**
- **Laravel Server**: `http://localhost:8000`
- **Single Port**: 8000 untuk semua routes
- **No Separate Admin Port**: Admin dan web menggunakan port yang sama

### **URL Structure:**
```
Web Routes:
├── http://localhost:8000/                 (Home)
├── http://localhost:8000/equipment        (Equipment List)
├── http://localhost:8000/bookings        (User Bookings)
└── http://localhost:8000/test-booking/1   (Test Booking)

Admin Routes:
├── http://localhost:8000/admin/dashboard  (Admin Dashboard)
├── http://localhost:8000/admin/settings   (Admin Settings)
├── http://localhost:8000/admin/equipment  (Admin Equipment)
└── http://localhost:8000/admin/bookings   (Admin Bookings)
```

## 🔧 **HOW IT WORKS**

### **1. Route Grouping:**
```php
// Web routes - no prefix
Route::get('/', [HomeController::class, 'index'])->name('home');

// Admin routes - with /admin prefix
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
});
```

### **2. Middleware Protection:**
- **Web Routes**: Mostly public, some require auth
- **Admin Routes**: All require authentication + admin role

### **3. Single Server Instance:**
- Laravel menggunakan 1 server process
- Route dispatcher menentukan controller berdasarkan URL
- Tidak ada multiple server atau port

## 🚀 **TESTING URLS**

### **Web Access:**
```bash
✅ http://localhost:8000/                 # Home page
✅ http://localhost:8000/test-booking/1   # Test booking form
✅ http://localhost:8000/equipment        # Equipment listing
```

### **Admin Access (requires authentication):**
```bash
🔐 http://localhost:8000/admin/dashboard  # Admin dashboard
🔐 http://localhost:8000/admin/settings   # Admin settings
🔐 http://localhost:8000/admin/equipment  # Admin equipment
```

### **Auto Login for Testing:**
```bash
🧪 http://localhost:8000/auto-login-admin  # Auto login as admin
```

## ⚙️ **CONFIGURATION OPTIONS**

### **Option 1: Keep Current Setup (Recommended)**
- **Pros**: Simple, standard Laravel practice
- **Cons**: None
- **Action**: No changes needed

### **Option 2: Separate Admin Subdomain**
```php
// Route in different file or condition
if (request()->getHost() === 'admin.localhost') {
    // Admin routes
} else {
    // Web routes
}
```

### **Option 3: Separate Admin Port (Not Recommended)**
```bash
# Start separate server for admin
php artisan serve --port=8001
```

## 🔍 **TROUBLESHOOTING**

### **If Admin Seems Different Port:**

1. **Check Browser URL:**
   ```
   ❌ Wrong: http://localhost:8001/admin/dashboard
   ✅ Correct: http://localhost:8000/admin/dashboard
   ```

2. **Clear Browser Cache:**
   - Ctrl+F5 to hard refresh
   - Clear cookies and cache
   - Try incognito mode

3. **Check Laravel Server:**
   ```bash
   php artisan serve --host=0.0.0.0 --port=8000
   ```

4. **Verify Routes:**
   ```bash
   php artisan route:list | grep admin
   ```

## 📊 **PERFORMANCE COMPARISON**

| Method | Pros | Cons | Recommended |
|--------|------|------|-------------|
| **Single Port + Prefix** | Simple, Standard, Fast | None | ✅ YES |
| **Separate Subdomain** | Clear separation | Complex setup | ❌ No |
| **Separate Port** | Complete isolation | Multiple servers | ❌ No |

## 🎯 **CONCLUSION**

**Admin dan Web menggunakan PORT YANG SAMA (8000)**

- **No different ports needed**
- **URL prefix `/admin/` membedakan admin routes**
- **Middleware handles authentication dan authorization**
- **Current setup is correct dan efficient**

### **URLs to Test:**
- **Web**: `http://localhost:8000/`
- **Admin**: `http://localhost:8000/admin/dashboard`
- **Test Booking**: `http://localhost:8000/test-booking/1`

**Status**: ✅ WORKING CORRECTLY - No port issues detected!

---

**Last Updated**: January 2024
**Server Port**: 8000
**Status**: All routes working on same port
