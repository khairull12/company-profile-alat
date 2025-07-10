# 🔌 API Documentation - Sistem Rental Alat Berat

## 📋 Overview

Dokumentasi API untuk sistem rental alat berat yang dapat digunakan untuk pengembangan aplikasi mobile atau integrasi dengan sistem lain.

## 🚀 Base URL

```
Production: https://your-domain.com/api/v1
Development: http://127.0.0.1:8000/api/v1
```

## 🔐 Authentication

API menggunakan Laravel Sanctum untuk autentikasi. Semua endpoint yang memerlukan autentikasi harus menyertakan token Bearer.

### Login
```http
POST /api/v1/auth/login
Content-Type: application/json

{
    "email": "user@example.com",
    "password": "password"
}
```

**Response:**
```json
{
    "success": true,
    "data": {
        "user": {
            "id": 1,
            "name": "John Doe",
            "email": "user@example.com",
            "role": "user"
        },
        "token": "1|abcdef123456..."
    }
}
```

### Register
```http
POST /api/v1/auth/register
Content-Type: application/json

{
    "name": "John Doe",
    "email": "user@example.com",
    "password": "password",
    "password_confirmation": "password"
}
```

### Logout
```http
POST /api/v1/auth/logout
Authorization: Bearer {token}
```

## 📊 Equipment Endpoints

### Get All Equipment
```http
GET /api/v1/equipment
```

**Query Parameters:**
- `page` (int): Halaman (default: 1)
- `per_page` (int): Item per halaman (default: 12, max: 100)
- `category` (int): Filter berdasarkan kategori ID
- `search` (string): Pencarian berdasarkan nama/deskripsi
- `price_min` (int): Harga minimum per hari
- `price_max` (int): Harga maksimum per hari
- `available_only` (bool): Hanya tampilkan yang tersedia (default: false)

**Response:**
```json
{
    "success": true,
    "data": {
        "equipment": [
            {
                "id": 1,
                "name": "Excavator Komatsu PC200",
                "slug": "excavator-komatsu-pc200",
                "description": "Excavator dengan performa tinggi...",
                "price_per_day": 1500000,
                "stock": 3,
                "image": "equipment/excavator-1.jpg",
                "category": {
                    "id": 1,
                    "name": "Excavator",
                    "slug": "excavator"
                },
                "specifications": {
                    "engine": "Komatsu SAA6D107E-1",
                    "power": "148 HP",
                    "weight": "20.5 ton"
                },
                "is_available": true,
                "created_at": "2024-01-01T00:00:00.000000Z"
            }
        ],
        "pagination": {
            "current_page": 1,
            "last_page": 5,
            "per_page": 12,
            "total": 56
        }
    }
}
```

### Get Single Equipment
```http
GET /api/v1/equipment/{id}
```

**Response:**
```json
{
    "success": true,
    "data": {
        "equipment": {
            "id": 1,
            "name": "Excavator Komatsu PC200",
            "slug": "excavator-komatsu-pc200",
            "description": "Excavator dengan performa tinggi untuk berbagai kebutuhan konstruksi.",
            "price_per_day": 1500000,
            "stock": 3,
            "image": "equipment/excavator-1.jpg",
            "category": {
                "id": 1,
                "name": "Excavator",
                "slug": "excavator"
            },
            "specifications": {
                "engine": "Komatsu SAA6D107E-1",
                "power": "148 HP",
                "weight": "20.5 ton",
                "bucket_capacity": "0.93 m³"
            },
            "is_available": true,
            "created_at": "2024-01-01T00:00:00.000000Z"
        },
        "related_equipment": [
            {
                "id": 2,
                "name": "Excavator Caterpillar 320D",
                "slug": "excavator-caterpillar-320d",
                "price_per_day": 1600000,
                "image": "equipment/excavator-2.jpg",
                "is_available": true
            }
        ]
    }
}
```

## 📁 Categories Endpoints

### Get All Categories
```http
GET /api/v1/categories
```

**Response:**
```json
{
    "success": true,
    "data": {
        "categories": [
            {
                "id": 1,
                "name": "Excavator",
                "slug": "excavator",
                "description": "Alat berat untuk penggalian",
                "equipment_count": 12
            },
            {
                "id": 2,
                "name": "Tronton",
                "slug": "tronton",
                "description": "Truk besar untuk angkutan",
                "equipment_count": 8
            }
        ]
    }
}
```

## 📅 Bookings Endpoints

### Get User Bookings
```http
GET /api/v1/bookings
Authorization: Bearer {token}
```

**Query Parameters:**
- `status` (string): Filter berdasarkan status (pending, confirmed, rejected, completed)
- `page` (int): Halaman

**Response:**
```json
{
    "success": true,
    "data": {
        "bookings": [
            {
                "id": 1,
                "equipment": {
                    "id": 1,
                    "name": "Excavator Komatsu PC200",
                    "image": "equipment/excavator-1.jpg"
                },
                "start_date": "2024-02-01",
                "end_date": "2024-02-05",
                "total_days": 5,
                "total_price": 7500000,
                "status": "confirmed",
                "notes": "Untuk proyek pembangunan jalan",
                "created_at": "2024-01-15T10:00:00.000000Z"
            }
        ]
    }
}
```

### Create Booking
```http
POST /api/v1/bookings
Authorization: Bearer {token}
Content-Type: application/json

{
    "equipment_id": 1,
    "start_date": "2024-02-01",
    "end_date": "2024-02-05",
    "notes": "Untuk proyek pembangunan jalan"
}
```

**Response:**
```json
{
    "success": true,
    "message": "Booking berhasil dibuat",
    "data": {
        "booking": {
            "id": 1,
            "equipment_id": 1,
            "start_date": "2024-02-01",
            "end_date": "2024-02-05",
            "total_days": 5,
            "total_price": 7500000,
            "status": "pending",
            "notes": "Untuk proyek pembangunan jalan",
            "created_at": "2024-01-15T10:00:00.000000Z"
        }
    }
}
```

### Get Single Booking
```http
GET /api/v1/bookings/{id}
Authorization: Bearer {token}
```

### Cancel Booking
```http
DELETE /api/v1/bookings/{id}
Authorization: Bearer {token}
```

## 👤 User Profile Endpoints

### Get Profile
```http
GET /api/v1/profile
Authorization: Bearer {token}
```

**Response:**
```json
{
    "success": true,
    "data": {
        "user": {
            "id": 1,
            "name": "John Doe",
            "email": "user@example.com",
            "role": "user",
            "created_at": "2024-01-01T00:00:00.000000Z"
        }
    }
}
```

### Update Profile
```http
PUT /api/v1/profile
Authorization: Bearer {token}
Content-Type: application/json

{
    "name": "John Smith",
    "email": "john.smith@example.com",
    "current_password": "oldpassword",
    "password": "newpassword",
    "password_confirmation": "newpassword"
}
```

## 🏢 Company Info Endpoints

### Get Company Settings
```http
GET /api/v1/company
```

**Response:**
```json
{
    "success": true,
    "data": {
        "company": {
            "name": "Rental Alat Berat",
            "address": "Jl. Industri No. 123, Jakarta",
            "phone": "+62 21 123 4567",
            "email": "info@rental-alat.com",
            "about": "Perusahaan penyewaan alat berat terpercaya...",
            "vision": "Menjadi perusahaan rental alat berat terdepan...",
            "mission": "Menyediakan layanan rental alat berat berkualitas..."
        }
    }
}
```

## 📊 Statistics Endpoints

### Get Public Statistics
```http
GET /api/v1/stats
```

**Response:**
```json
{
    "success": true,
    "data": {
        "stats": {
            "total_equipment": 45,
            "total_bookings": 234,
            "total_users": 156,
            "categories_count": 8
        }
    }
}
```

## 📱 Mobile App Specific Endpoints

### App Configuration
```http
GET /api/v1/app/config
```

**Response:**
```json
{
    "success": true,
    "data": {
        "config": {
            "app_version": "1.0.0",
            "force_update": false,
            "maintenance_mode": false,
            "features": {
                "push_notifications": true,
                "offline_mode": false,
                "dark_mode": true
            }
        }
    }
}
```

### Check App Updates
```http
GET /api/v1/app/version
```

## 🔍 Search Endpoints

### Global Search
```http
GET /api/v1/search
```

**Query Parameters:**
- `q` (string): Query pencarian
- `type` (string): Tipe pencarian (equipment, categories, all)

**Response:**
```json
{
    "success": true,
    "data": {
        "results": {
            "equipment": [
                {
                    "id": 1,
                    "name": "Excavator Komatsu PC200",
                    "type": "equipment",
                    "image": "equipment/excavator-1.jpg",
                    "price_per_day": 1500000
                }
            ],
            "categories": [
                {
                    "id": 1,
                    "name": "Excavator",
                    "type": "category",
                    "equipment_count": 12
                }
            ]
        }
    }
}
```

## 🚨 Error Responses

### Standard Error Format
```json
{
    "success": false,
    "error": {
        "code": "VALIDATION_ERROR",
        "message": "The given data was invalid.",
        "details": {
            "email": ["The email field is required."],
            "password": ["The password field is required."]
        }
    }
}
```

### HTTP Status Codes
- `200` - Success
- `201` - Created
- `400` - Bad Request
- `401` - Unauthorized
- `403` - Forbidden
- `404` - Not Found
- `422` - Validation Error
- `500` - Internal Server Error

## 📝 Rate Limiting

API memiliki rate limiting:
- **Authenticated users**: 100 requests per minute
- **Guest users**: 60 requests per minute

## 🔧 Implementation Example

### JavaScript/Fetch
```javascript
// Login
const login = async (email, password) => {
    const response = await fetch('/api/v1/auth/login', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({ email, password })
    });
    
    const data = await response.json();
    
    if (data.success) {
        localStorage.setItem('token', data.data.token);
        return data.data.user;
    }
    
    throw new Error(data.error.message);
};

// Get Equipment
const getEquipment = async (page = 1) => {
    const token = localStorage.getItem('token');
    const response = await fetch(`/api/v1/equipment?page=${page}`, {
        headers: {
            'Authorization': `Bearer ${token}`
        }
    });
    
    return await response.json();
};
```

### cURL Examples
```bash
# Login
curl -X POST http://127.0.0.1:8000/api/v1/auth/login \
  -H "Content-Type: application/json" \
  -d '{"email":"user@example.com","password":"password"}'

# Get Equipment
curl -X GET http://127.0.0.1:8000/api/v1/equipment \
  -H "Authorization: Bearer YOUR_TOKEN"

# Create Booking
curl -X POST http://127.0.0.1:8000/api/v1/bookings \
  -H "Authorization: Bearer YOUR_TOKEN" \
  -H "Content-Type: application/json" \
  -d '{"equipment_id":1,"start_date":"2024-02-01","end_date":"2024-02-05"}'
```

## 📚 Additional Notes

1. **Timestamps**: Semua timestamp menggunakan format ISO 8601
2. **Pagination**: Menggunakan cursor-based pagination untuk performa optimal
3. **Caching**: Response di-cache untuk meningkatkan performa
4. **Validation**: Semua input divalidasi sebelum diproses
5. **Security**: Implementasi CORS, rate limiting, dan input sanitization

## 🎯 Next Steps

Untuk implementasi API ini:

1. Install Laravel Sanctum
2. Buat API Controllers
3. Setup API Routes
4. Implementasi Authentication
5. Testing dengan Postman/Insomnia
6. Dokumentasi dengan OpenAPI/Swagger

---

**Catatan**: Dokumentasi ini adalah draft untuk pengembangan API. Implementasi aktual mungkin berbeda tergantung kebutuhan spesifik.
