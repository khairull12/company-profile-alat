# Black Box Testing Documentation

This document provides instructions for running the black box tests for the Company Profile and Equipment Rental System.

## Overview

Black box testing focuses on testing the application functionality without knowledge of the internal code structure. The tests created for this system cover:

1. Equipment browsing and details
2. Booking functionality
3. Admin equipment management
4. Admin booking management
5. Admin settings management
6. Home page and static pages

## Test Structure

The tests are organized as follows:

- `tests/Feature/EquipmentTest.php` - Tests for public equipment listings and details
- `tests/Feature/BookingTest.php` - Tests for booking functionality and validation
- `tests/Feature/Admin/AdminEquipmentTest.php` - Tests for admin equipment management
- `tests/Feature/Admin/AdminBookingTest.php` - Tests for admin booking management
- `tests/Feature/Admin/AdminSettingTest.php` - Tests for admin settings management
- `tests/Feature/HomePageTest.php` - Tests for home page and static pages

## Factory Classes

Factory classes were created for test data generation:

- `database/factories/CategoryFactory.php`
- `database/factories/EquipmentFactory.php`
- `database/factories/BookingFactory.php`
- `database/factories/UserFactory.php` (updated to include admin role)

## Running the Tests

### Prerequisites

- PHP 8.1 or higher
- Composer installed
- Laravel project set up
- Test database configured in `.env.testing` (recommended to use SQLite for testing)

### Setting up the Test Environment

1. Create `.env.testing` file in the root directory:

```
APP_ENV=testing
APP_DEBUG=true
DB_CONNECTION=sqlite
DB_DATABASE=:memory:
```

2. Make sure your PHPUnit configuration in `phpunit.xml` includes:

```xml
<php>
    <env name="APP_ENV" value="testing"/>
    <env name="BCRYPT_ROUNDS" value="4"/>
    <env name="CACHE_DRIVER" value="array"/>
    <env name="DB_CONNECTION" value="sqlite"/>
    <env name="DB_DATABASE" value=":memory:"/>
    <env name="MAIL_MAILER" value="array"/>
    <env name="QUEUE_CONNECTION" value="sync"/>
    <env name="SESSION_DRIVER" value="array"/>
    <env name="TELESCOPE_ENABLED" value="false"/>
</php>
```

### Running All Tests

```bash
php artisan test
```

### Running Specific Test Files

```bash
# Run Equipment Tests
php artisan test --filter=EquipmentTest

# Run Booking Tests
php artisan test --filter=BookingTest

# Run Admin Tests
php artisan test --filter=Admin

# Run Home Page Tests
php artisan test --filter=HomePageTest
```

### Running a Single Test Method

```bash
php artisan test --filter="EquipmentTest::test_equipment_index_page_loads_successfully"
```

## Test Results

The test results will display in the console, showing which tests passed and which failed.

## Troubleshooting Common Issues

1. **Database Issues**:
   - Make sure your testing database is properly configured
   - Use `RefreshDatabase` trait to ensure a clean database state for each test

2. **Authentication Issues**:
   - Ensure you're using `actingAs($user)` before accessing protected routes

3. **Route Not Found**:
   - Check that all routes tested actually exist in your application
   - Verify route names match between tests and application

4. **Asset Issues**:
   - When testing file uploads, use `Storage::fake('public')` to simulate storage
   - Check that necessary directories exist and are writable

## Extending the Tests

To add new tests:

1. Create a new test file in the appropriate directory
2. Ensure the test class extends `Tests\TestCase`
3. Use the `RefreshDatabase` trait if working with the database
4. Create test methods following the naming convention `test_*`

Example:

```php
<?php

namespace Tests\Feature;

use App\Models\YourModel;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class YourModelTest extends TestCase
{
    use RefreshDatabase;

    public function test_your_feature_works(): void
    {
        // Your test code here
        $this->assertTrue(true);
    }
}
```