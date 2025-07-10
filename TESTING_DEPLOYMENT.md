# 🧪 Testing & Deployment Guide

## 📋 Testing Strategy

### 1. Unit Testing

#### Setup Testing Environment
```bash
# Copy environment untuk testing
cp .env.testing.example .env.testing

# Generate key untuk testing
php artisan key:generate --env=testing

# Setup database testing
php artisan migrate --env=testing
php artisan db:seed --env=testing
```

#### Run Tests
```bash
# Jalankan semua test
php artisan test

# Test dengan coverage
php artisan test --coverage

# Test spesifik
php artisan test --filter=UserTest
php artisan test tests/Feature/AdminTest.php
```

#### Test Cases yang Harus Dibuat

**Auth Tests:**
```php
// tests/Feature/AuthTest.php
- testUserCanLogin()
- testUserCanLogout()
- testUserCanRegister()
- testAdminCanAccessDashboard()
- testUserCannotAccessAdminArea()
```

**Equipment Tests:**
```php
// tests/Feature/EquipmentTest.php
- testCanViewEquipmentList()
- testCanViewEquipmentDetail()
- testCanFilterEquipmentByCategory()
- testCanSearchEquipment()
- testAdminCanCreateEquipment()
- testAdminCanUpdateEquipment()
- testAdminCanDeleteEquipment()
```

**Booking Tests:**
```php
// tests/Feature/BookingTest.php
- testUserCanCreateBooking()
- testUserCanViewOwnBookings()
- testUserCannotCreateBookingForUnavailableEquipment()
- testAdminCanViewAllBookings()
- testAdminCanUpdateBookingStatus()
```

### 2. Browser Testing (Laravel Dusk)

#### Install Laravel Dusk
```bash
composer require --dev laravel/dusk
php artisan dusk:install
```

#### Browser Test Examples
```php
// tests/Browser/AdminDashboardTest.php
- testAdminCanAccessDashboard()
- testAdminCanViewStatistics()
- testAdminCanNavigateToEquipmentManagement()

// tests/Browser/BookingFlowTest.php
- testUserCanCompleteBookingProcess()
- testUserCanViewBookingHistory()
```

### 3. API Testing

#### Setup API Tests
```bash
# Install untuk API testing
composer require --dev pestphp/pest
composer require --dev pestphp/pest-plugin-laravel
```

#### API Test Examples
```php
// tests/Feature/Api/EquipmentApiTest.php
- testCanGetEquipmentList()
- testCanGetEquipmentDetail()
- testCanFilterEquipmentApi()
- testRequiresAuthenticationForBooking()
```

---

## 🚀 Deployment Guide

### 1. Shared Hosting Deployment

#### Persiapan Files
```bash
# Build production assets
npm run build

# Optimize Laravel
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Generate autoload
composer dump-autoload --optimize
```

#### Upload Structure
```
public_html/
├── index.php (dari public/index.php)
├── .htaccess (dari public/.htaccess)
├── build/ (dari public/build/)
├── storage -> ../storage/app/public/
└── laravel-app/
    ├── app/
    ├── bootstrap/
    ├── config/
    ├── database/
    ├── resources/
    ├── routes/
    ├── storage/
    ├── vendor/
    ├── .env
    └── artisan
```

#### Update index.php
```php
// public_html/index.php
require __DIR__.'/laravel-app/bootstrap/app.php';
```

### 2. VPS/Dedicated Server Deployment

#### Server Requirements
```bash
# Install required software
sudo apt update
sudo apt install nginx mysql-server php8.1-fpm php8.1-mysql php8.1-xml php8.1-mbstring php8.1-zip php8.1-curl php8.1-gd
```

#### Nginx Configuration
```nginx
# /etc/nginx/sites-available/rental-alat
server {
    listen 80;
    server_name yourdomain.com;
    root /var/www/rental-alat/public;
    index index.php;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.1-fpm.sock;
        fastcgi_index index.php;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }

    location ~ /\.ht {
        deny all;
    }

    location ~* \.(jpg|jpeg|png|gif|ico|css|js)$ {
        expires 1y;
        add_header Cache-Control "public, immutable";
    }
}
```

#### Deployment Script
```bash
#!/bin/bash
# deploy.sh

# Update kode
git pull origin main

# Install dependencies
composer install --no-dev --optimize-autoloader

# Update environment
cp .env.example .env
php artisan key:generate

# Database
php artisan migrate --force

# Cache
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Assets
npm install
npm run build

# Permissions
chown -R www-data:www-data storage bootstrap/cache
chmod -R 775 storage bootstrap/cache

# Restart services
sudo systemctl restart nginx
sudo systemctl restart php8.1-fpm
```

### 3. Docker Deployment

#### Dockerfile
```dockerfile
FROM php:8.1-fpm

# Install dependencies
RUN apt-get update && apt-get install -y \
    nginx \
    mysql-client \
    zip \
    unzip \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev

# Install PHP extensions
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www

# Copy application
COPY . .

# Install dependencies
RUN composer install --optimize-autoloader --no-dev

# Build assets
RUN npm install && npm run build

# Set permissions
RUN chown -R www-data:www-data storage bootstrap/cache
RUN chmod -R 775 storage bootstrap/cache

EXPOSE 80

CMD ["php-fpm"]
```

#### docker-compose.yml
```yaml
version: '3.8'

services:
  app:
    build: .
    ports:
      - "8000:80"
    depends_on:
      - mysql
    environment:
      - DB_HOST=mysql
      - DB_DATABASE=rental_alat
      - DB_USERNAME=root
      - DB_PASSWORD=password
    volumes:
      - ./storage:/var/www/storage

  mysql:
    image: mysql:8.0
    environment:
      - MYSQL_ROOT_PASSWORD=password
      - MYSQL_DATABASE=rental_alat
    volumes:
      - mysql_data:/var/lib/mysql
    ports:
      - "3306:3306"

volumes:
  mysql_data:
```

### 4. CI/CD dengan GitHub Actions

#### .github/workflows/deploy.yml
```yaml
name: Deploy to Production

on:
  push:
    branches: [main]

jobs:
  deploy:
    runs-on: ubuntu-latest

    steps:
    - uses: actions/checkout@v2

    - name: Setup PHP
      uses: shivammathur/setup-php@v2
      with:
        php-version: '8.1'
        extensions: mbstring, xml, ctype, iconv, intl, pdo_mysql

    - name: Install dependencies
      run: composer install --no-dev --optimize-autoloader

    - name: Setup Node.js
      uses: actions/setup-node@v2
      with:
        node-version: '18'

    - name: Install npm dependencies
      run: npm install

    - name: Build assets
      run: npm run build

    - name: Run tests
      run: php artisan test

    - name: Deploy to server
      uses: appleboy/ssh-action@v0.1.5
      with:
        host: ${{ secrets.HOST }}
        username: ${{ secrets.USERNAME }}
        key: ${{ secrets.SSH_KEY }}
        script: |
          cd /var/www/rental-alat
          git pull origin main
          composer install --no-dev --optimize-autoloader
          php artisan migrate --force
          php artisan config:cache
          php artisan route:cache
          php artisan view:cache
          npm run build
          sudo systemctl restart nginx
```

---

## 🔒 Security Checklist

### 1. Basic Security
- [ ] Update semua dependencies
- [ ] Set `APP_DEBUG=false` di production
- [ ] Gunakan HTTPS/SSL
- [ ] Setup firewall
- [ ] Disable directory listing
- [ ] Hide server information

### 2. Laravel Security
- [ ] Implement CSRF protection
- [ ] Validate semua input
- [ ] Use Laravel's built-in authentication
- [ ] Implement rate limiting
- [ ] Setup proper file permissions
- [ ] Use secure session configuration

### 3. Database Security
- [ ] Use strong database passwords
- [ ] Limit database access
- [ ] Regular database backups
- [ ] Encrypt sensitive data
- [ ] Use prepared statements

### 4. File Security
- [ ] Validate file uploads
- [ ] Restrict file types
- [ ] Store uploads outside web root
- [ ] Implement file size limits
- [ ] Scan uploaded files for malware

---

## 📊 Performance Optimization

### 1. Laravel Optimization
```bash
# Production optimizations
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan event:cache

# Database optimization
php artisan migrate --force
php artisan db:seed --force
```

### 2. Asset Optimization
```bash
# Minify assets
npm run build

# Optimize images
php artisan optimize:images
```

### 3. Server Optimization
```bash
# Enable OPcache
echo "opcache.enable=1" >> /etc/php/8.1/fpm/php.ini

# Configure Nginx caching
# Add gzip compression
# Setup CDN for static assets
```

### 4. Database Optimization
```sql
-- Add indexes
CREATE INDEX idx_equipment_category ON equipment(category_id);
CREATE INDEX idx_bookings_user ON bookings(user_id);
CREATE INDEX idx_bookings_status ON bookings(status);
CREATE INDEX idx_bookings_dates ON bookings(start_date, end_date);
```

---

## 🔧 Monitoring & Maintenance

### 1. Log Monitoring
```bash
# Monitor Laravel logs
tail -f storage/logs/laravel.log

# Monitor server logs
tail -f /var/log/nginx/error.log
tail -f /var/log/php8.1-fpm.log
```

### 2. Performance Monitoring
```bash
# Install monitoring tools
composer require spatie/laravel-backup
composer require spatie/laravel-health

# Setup monitoring
php artisan backup:run
php artisan health:check
```

### 3. Regular Maintenance
```bash
#!/bin/bash
# maintenance.sh

# Clear expired sessions
php artisan session:gc

# Clear old logs
find storage/logs -name "*.log" -mtime +30 -delete

# Update dependencies
composer update --no-dev

# Run health checks
php artisan health:check
```

---

## 🎯 Go-Live Checklist

### Pre-Launch
- [ ] Complete all testing
- [ ] Setup production environment
- [ ] Configure domain and SSL
- [ ] Setup database backups
- [ ] Configure monitoring
- [ ] Prepare rollback plan

### Launch Day
- [ ] Deploy application
- [ ] Run database migrations
- [ ] Clear all caches
- [ ] Test critical features
- [ ] Monitor error logs
- [ ] Verify SSL certificate

### Post-Launch
- [ ] Monitor performance
- [ ] Check error logs
- [ ] Test all features
- [ ] Backup database
- [ ] Update documentation
- [ ] Collect user feedback

---

**Catatan**: Dokumentasi ini memberikan panduan lengkap untuk testing dan deployment. Sesuaikan dengan kebutuhan spesifik proyek Anda.
