<?php
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ConsultationController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
 
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// ── Halaman Utama ─────────────────────────────
Route::get('/', [HomeController::class, 'index'])->name('home');
 
// ── Skin Guide / Artikel ──────────────────────
Route::get('/skin-guide',          [ArticleController::class, 'index'])->name('skin-guide.index');
Route::get('/skin-guide/{slug}',   [ArticleController::class, 'show'])->name('skin-guide.show');
 
// ── Catalog / Produk ──────────────────────────
Route::get('/catalog',             [ProductController::class, 'index'])->name('catalog.index');
Route::get('/catalog/{slug}',      [ProductController::class, 'show'])->name('catalog.show');
 
// ── Konsultasi ────────────────────────────────
Route::get('/consultation',           [ConsultationController::class, 'index'])->name('consultation.index');
Route::post('/consultation/analyze',  [ConsultationController::class, 'analyze']); // AJAX endpoint
Route::post('/consultation',          [ConsultationController::class, 'store'])->name('consultation.store');
Route::get('/consultation/{id}',      [ConsultationController::class, 'result'])->name('consultation.result');
 
// ── Profile (perlu login) ─────────────────────
Route::middleware('auth')->group(function () {
    Route::get('/profile',         [ProfileController::class, 'show'])->name('profile.show');
    Route::put('/profile',         [ProfileController::class, 'update'])->name('profile.update');
});
