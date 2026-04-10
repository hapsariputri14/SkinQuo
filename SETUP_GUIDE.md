# SkinQuo Project - Setup & Installation Guide

## 📋 Overview

Dokumentasi lengkap perbaikan dan setup untuk project SkinQuo - aplikasi e-commerce skincare dengan authentication dan management content.

---

## ✅ Perbaikan yang Telah Dilakukan

### 1. **Authentication System (AuthController)**
✅ **File**: `app/Http/Controllers/AuthController.php`

**Methods:**
- `showLogin()` - Tampilkan form login
- `login()` - Proses login dengan email atau mobile number
- `showRegister()` - Tampilkan form register
- `register()` - Proses register user baru
- `logout()` - Logout user

**Features:**
- Support login dengan email atau nomor telepon
- Password validation & hashing
- Session management
- Input validation & error handling

---

### 2. **User Profile Management (ProfileController)**
✅ **File**: `app/Http/Controllers/ProfileController.php`

**Methods:**
- `show()` - Tampilkan profil user
- `update()` - Update data profil user

**Features:**
- Edit first name, last name, email, mobile
- Manage birth date, gender
- Avatar upload dengan image validation

---

### 3. **Content Management Controllers**
✅ **Files Created:**
- `app/Http/Controllers/ArticleController.php` - Manage artikel/skin guide
- `app/Http/Controllers/ProductController.php` - Manage produk/catalog
- `app/Http/Controllers/ConsultationController.php` - Handle konsultasi

---

### 4. **Database Models**
✅ **Files Created:**
- `app/Models/Article.php` - Model artikel
- `app/Models/Product.php` - Model produk
- `app/Models/User.php` - Updated dengan fields baru

**User Model Fields:**
```php
- name (existing)
- email (existing)
- password (existing)
- first_name (NEW)
- last_name (NEW)
- mobile_number (NEW)
- birth_date (NEW)
- gender (NEW)
- avatar (NEW)
```

---

### 5. **Database Migrations**
✅ **Files Created:**
```
database/migrations/2025_04_10_000003_add_profile_fields_to_users_table.php
database/migrations/2025_04_10_000004_create_articles_table.php
database/migrations/2025_04_10_000005_create_products_table.php
```

**To run migrations:**
```bash
php artisan migrate
```

---

### 6. **View Templates**
✅ **Files Created:**
- `resources/views/pages/profile.blade.php` - Halaman profil user
- `resources/views/pages/skin-guide.blade.php` - Daftar artikel
- `resources/views/pages/catalog.blade.php` - Daftar produk
- `resources/views/pages/consultation.blade.php` - Halaman konsultasi
- `resources/views/pages/article-detail.blade.php` - Detail artikel
- `resources/views/pages/product-detail.blade.php` - Detail produk

---

### 7. **Routes Update**
✅ **Updated**: `routes/web.php`

**New Routes:**
```php
// Auth Routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Profile Routes (auth required)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
});

// Public Routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/skin-guide', [ArticleController::class, 'index'])->name('skin-guide.index');
Route::get('/skin-guide/{slug}', [ArticleController::class, 'show'])->name('skin-guide.show');
Route::get('/catalog', [ProductController::class, 'index'])->name('catalog.index');
Route::get('/catalog/{slug}', [ProductController::class, 'show'])->name('catalog.show');
Route::get('/consultation', [ConsultationController::class, 'index'])->name('consultation.index');
Route::post('/consultation', [ConsultationController::class, 'store'])->name('consultation.store');
```

---

### 8. **Image Assets Directory**
✅ **Created**: `public/images/` dengan README

**Required Images:**
1. **hero-model.png** (600×750px) - Model untuk hero section
2. **auth-model.png** (600×800px) - Model untuk login/register

---

## 🚀 Installation Steps

### Prerequisites
- PHP 8.1+
- Laravel 11+
- MySQL/SQLite
- Composer

### Step 1: Setup Database
```bash
# Edit .env file dengan database credentials
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=skinquo
DB_USERNAME=root
DB_PASSWORD=
```

### Step 2: Run Migrations
```bash
php artisan migrate
```

### Step 3: (Optional) Seed Sample Data
```bash
php artisan db:seed
```

### Step 4: Add Images
1. Tempatkan `hero-model.png` di `public/images/`
2. Tempatkan `auth-model.png` di `public/images/`

### Step 5: Run Development Server
```bash
php artisan serve
```

Access at: `http://localhost:8000`

---

## 📱 Form Fields & Validation

### Login Form
```
- Email / Mobile Number (required)
- Password (required)
```

### Register Form
```
- First Name (required, max 255)
- Last Name (required, max 255)
- Birth Date (required - day/month/year)
- Gender (required - female/male/non_binary/prefer_not)
- Email / Mobile (required, unique, email)
- Password (required, confirmed, min 8 chars with uppercase, number, special char)
```

### Profile Edit Form
```
- First Name (required)
- Last Name (required)
- Email (required, unique except own)
- Mobile Number (optional, unique except own)
- Birth Date (optional, date format)
- Gender (required)
- Avatar (optional, image, max 2MB)
```

---

## 🔐 Authentication & Authorization

### Protected Routes
- `/profile` - Show profile (auth required)
- `/profile` - Update profile (auth required, PUT method)

### Public Routes
- `/` - Home page
- `/login` - Login page
- `/register` - Register page
- `/skin-guide` - Articles listing
- `/catalog` - Products listing
- `/consultation` - Consultation form

---

## 📚 Model Relationships (Future Enhancement)

### Suggested:
```php
// User -> Articles (Admin can write)
User::articles()

// User -> Consultations (User has many)
User::consultations()

// Article -> Comments (Future)
Article::comments()

// Product -> Reviews (Future)
Product::reviews()
```

---

## 🎨 Styling & Theme

**Color Scheme:**
```
--cream: #FFEAC5
--peach: #FFDBB5
--brown: #6C4E31
--dark-brown: #603F26
```

**Fonts:**
- Serif: Playfair Display (headings)
- Sans: Poppins (body text)

---

## 🔄 API Response Examples

### Login Success
```json
{
  "status": "Login berhasil!",
  "redirect": "/home"
}
```

### Register Success
```json
{
  "status": "Pendaftaran berhasil! Selamat datang di SkinQuo.",
  "redirect": "/home"
}
```

### Validation Error
```json
{
  "errors": {
    "email": ["Email atau nomor telepon sudah terdaftar."],
    "password": ["Password tidak cocok."]
  }
}
```

---

## 📁 Project Structure

```
skinquo/
├── app/
│   ├── Http/Controllers/
│   │   ├── AuthController.php ✅
│   │   ├── ProfileController.php ✅
│   │   ├── HomeController.php ✅
│   │   ├── ArticleController.php ✅
│   │   ├── ProductController.php ✅
│   │   └── ConsultationController.php ✅
│   └── Models/
│       ├── User.php (updated) ✅
│       ├── Article.php ✅
│       └── Product.php ✅
├── resources/views/
│   ├── layouts/
│   │   └── app.blade.php ✅
│   └── pages/
│       ├── home.blade.php ✅
│       ├── profile.blade.php ✅
│       ├── login.blade.php ✅
│       ├── register.blade.php ✅
│       ├── skin-guide.blade.php ✅
│       ├── catalog.blade.php ✅
│       ├── consultation.blade.php ✅
│       ├── article-detail.blade.php ✅
│       └── product-detail.blade.php ✅
├── database/
│   └── migrations/
│       ├── 2025_04_10_000003_add_profile_fields_to_users_table.php ✅
│       ├── 2025_04_10_000004_create_articles_table.php ✅
│       └── 2025_04_10_000005_create_products_table.php ✅
├── public/
│   └── images/ ✅
│       ├── hero-model.png (needed)
│       ├── auth-model.png (needed)
│       └── README.md ✅
└── routes/
    └── web.php (updated) ✅
```

---

## 🐛 Troubleshooting

### Issue: SQLSTATE error saat migrate
**Solution:**
```bash
php artisan migrate:reset
php artisan migrate
```

### Issue: File not found (images)
**Solution:**
1. Pastikan folder `public/images/` ada
2. Letakkan image files di folder tersebut
3. Clear browser cache

### Issue: Validation errors pada form
**Solution:**
1. Check `.env` file configuration
2. Ensure database running
3. Verify input format sesuai dengan validation rules

---

## ✨ Fitur Tambahan yang Bisa Dikembangkan

- [ ] Email verification
- [ ] Password reset via email
- [ ] Two-factor authentication
- [ ] Article comments
- [ ] Product reviews & ratings
- [ ] Shopping cart
- [ ] Order management
- [ ] Admin dashboard
- [ ] Image cropping untuk avatar
- [ ] Consultation appointment booking
- [ ] Newsletter subscription
- [ ] Social media login (OAuth)

---

## 📝 Notes

- Semua form sudah memiliki client-side styling yang menarik
- Responsive design untuk mobile & desktop
- Input validation comprehensive
- Error handling yang user-friendly
- Session security dengan CSRF tokens

---

**Last Updated:** April 10, 2026
**Version:** 1.0
**Status:** ✅ Production Ready for Testing
