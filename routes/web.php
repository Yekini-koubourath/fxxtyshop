<?php

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ShopController;
use Illuminate\Support\Facades\Route;

// ---------- BOUTIQUE ----------
Route::get('/', [ShopController::class, 'home'])->name('home');
Route::get('/produits', [ShopController::class, 'index'])->name('shop.index');
Route::get('/produits/{product}', [ShopController::class, 'show'])->name('shop.show');

// ---------- PANIER ----------
Route::get('/panier', [CartController::class, 'index'])->name('cart.index');
Route::post('/panier/ajouter/{product}', [CartController::class, 'add'])->name('cart.add');
Route::patch('/panier/{product}', [CartController::class, 'update'])->name('cart.update');
Route::delete('/panier/{product}', [CartController::class, 'remove'])->name('cart.remove');

// ---------- COMMANDE ----------
Route::get('/commande', [CheckoutController::class, 'create'])->name('checkout.create');
Route::post('/commande', [CheckoutController::class, 'store'])->name('checkout.store');
Route::get('/commande/merci/{order}', [CheckoutController::class, 'success'])->name('checkout.success');

// ---------- REDIRECTION APRES CONNEXION ----------
Route::get('/dashboard', function () {
    return auth()->user()->is_admin
        ? redirect()->route('admin.dashboard')
        : redirect()->route('home');
})->middleware('auth')->name('dashboard');

// ---------- PROFIL (Breeze) ----------
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// ---------- ADMIN ----------
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('categories', CategoryController::class)->except(['show']);
    Route::resource('products', ProductController::class)->except(['show']);
    Route::get('orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('orders/{order}', [OrderController::class, 'show'])->name('orders.show');
    Route::patch('orders/{order}', [OrderController::class, 'update'])->name('orders.update');
    Route::delete('orders/{order}', [OrderController::class, 'destroy'])->name('orders.destroy');
});
Route::get('/test-upload', fn () => 'upload_max_filesize='.ini_get('upload_max_filesize').' | post_max_size='.ini_get('post_max_size').' | php.ini='.php_ini_loaded_file().' | tmp='.sys_get_temp_dir());
Route::get('/test-upload', fn () => 'php.ini='.php_ini_loaded_file().' | upload_tmp_dir='.ini_get('upload_tmp_dir').' | sys_temp='.sys_get_temp_dir().' | max='.ini_get('upload_max_filesize'));
require __DIR__.'/auth.php';