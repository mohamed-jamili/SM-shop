<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BuyerDashboardController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SellerDashboardController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// --- PUBLIC ROUTES ---

// Homepage (Marketing Page)
Route::get('/', function () {
    if (Illuminate\Support\Facades\Auth::check()) {
        return redirect()->route('dashboard');
    }
    return view('home');
})->name('home');

// Buyer Home Dashboard (For products)
Route::get('/buyer/home', function (Request $request) {
    if (Auth::check() && $request->user()?->isBuyer()) {
        return redirect()->route('buyer.home', $request->query());
    }

    return app(BuyerDashboardController::class)->index($request);
})->name('buyer.marketplace');

// --- GUEST ROUTES (Only for users NOT logged in) ---
Route::middleware('guest')->group(function () {

    // Login Routes
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.store');

    // Registration Routes
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.store');

    // Redirect /signup to /register for convenience
    Route::redirect('/signup', '/register');
});

// --- PROTECTED ROUTES (Only for logged in users) ---
Route::middleware('auth')->group(function () {

    // Logout
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Main Dashboard Redirector (Checks role and sends user to correct dashboard)
    Route::get('/dashboard', function (Request $request) {
        return $request->user()->isSeller()
            ? redirect()->route('seller.home')
            : redirect()->route('buyer.home');
    })->name('dashboard');

    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::get('/notifications/summary', [NotificationController::class, 'summary'])->name('notifications.summary');
    Route::post('/notifications/{notification}/read', [NotificationController::class, 'markAsRead'])->name('notifications.read');

    // --- SELLER ONLY ROUTES ---
    Route::middleware('seller')->prefix('seller')->name('seller.')->group(function () {

        // Seller Home (Boutique / List)
        Route::get('/home', [SellerDashboardController::class, 'index'])->name('home');

        // Add Product Page
        Route::get('/addproduct', [SellerDashboardController::class, 'index'])->name('addproduct');

        // Product Management (CRUD)
        Route::get('/sales', [SellerDashboardController::class, 'sales'])->name('sales');
        Route::post('/products', [ProductController::class, 'store'])->name('products.store');
        Route::post('/products/import', [ProductController::class, 'import'])->name('products.import');
        Route::put('/products/{product}', [ProductController::class, 'update'])->name('products.update');
        Route::delete('/products/{product}', [ProductController::class, 'destroy'])->name('products.destroy');
        // Order Management
        Route::patch('/orders/{order}/status', [OrderController::class, 'updateOrderStatus'])->name('orders.status');
        Route::patch('/order-items/{item}/status', [OrderController::class, 'updateItemStatus'])->name('orders.items.status');

        // Profile & Settings Page
        Route::get('/profile', [SellerDashboardController::class, 'profile'])->name('profile');
        Route::post('/profile', [SellerDashboardController::class, 'profileUpdate'])->name('profile.update');
        Route::get('/setting', [SellerDashboardController::class, 'setting'])->name('setting');
        Route::get('/help', [SellerDashboardController::class, 'help'])->name('help');
        Route::delete('/account', [SellerDashboardController::class, 'destroyAccount'])->name('account.destroy');
    });

    // --- BUYER ONLY ROUTES ---
    Route::middleware('buyer')->prefix('buyer')->name('buyer.')->group(function () {

        // Marketplace / Dashboard Home
        Route::get('/dashboard', [BuyerDashboardController::class, 'index'])->name('home');
        Route::post('/profile', [BuyerDashboardController::class, 'profileUpdate'])->name('profile.update');
        Route::delete('/account', [BuyerDashboardController::class, 'destroyAccount'])->name('account.destroy');

        // Checkout Page (Cart)
        Route::get('/checkout', [CartController::class, 'index'])->name('checkout');

        // Shipping Page (Step 1 of checkout flow)
        Route::get('/checkout/shipping', [CartController::class, 'shipping'])->name('checkout.shipping');

        // Store shipping data in session and go to payment
        Route::post('/checkout/shipping', [CartController::class, 'storeShipping'])->name('checkout.shipping.store');

        // Payment Page (Step 2 of checkout flow)
        Route::get('/checkout/payment', [CartController::class, 'payment'])->name('checkout.payment');

        // Cart Management
        Route::post('/cart/{product}', [CartController::class, 'store'])->name('cart.store');
        Route::patch('/cart/{product}', [CartController::class, 'update'])->name('cart.update');
        Route::delete('/cart/{product}', [CartController::class, 'destroy'])->name('cart.destroy');
        Route::delete('/cart', [CartController::class, 'clear'])->name('cart.clear');

        // Order Placement
        Route::post('/orders', [OrderController::class, 'store'])->name('orders.store');

        // Order Confirmation Page
        Route::get('/orders/{order}/confirmation', [OrderController::class, 'confirmation'])->name('order.confirmation');
    });
});
