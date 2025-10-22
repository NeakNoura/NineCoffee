<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Products\ProductsController;
use App\Http\Controllers\Admins\AdminsController;
use App\Http\Controllers\Users\UsersController;
use App\Http\Controllers\HomeController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// 🟢 Default Laravel auth
Auth::routes();

// 🟢 Public user pages
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('products/contact', [ProductsController::class, 'contact'])->name('product.contact');
Route::get('products/service', [ProductsController::class, 'service'])->name('product.service');
Route::get('products/menu', [ProductsController::class, 'menu'])->name('product.menu');
Route::get('products/about', [ProductsController::class, 'about'])->name('product.about');
Route::get('products/product-single/{id}', [ProductsController::class, 'singleProduct'])->name('product.single');

// 🛒 Cart & checkout
Route::post('products/product-single/{id}', [ProductsController::class, 'addCart'])->name('add.cart');
Route::get('products/cart', [ProductsController::class, 'cart'])->name('cart')->middleware('auth:web');
Route::get('products/cart-delete/{id}', [ProductsController::class, 'deleteProductCart'])->name('cart.product.delete');
Route::post('products/prepare-checkout', [ProductsController::class, 'prepareCheckout'])->name('prepare.checkout');
Route::get('products/checkout', [ProductsController::class, 'checkout'])->name('checkout')->middleware('check.for.price');
Route::post('products/checkout', [ProductsController::class, 'storeCheckout'])->name('proccess.checkout')->middleware('check.for.price');

// 💳 Payment routes
Route::get('products/paypal', [ProductsController::class, 'paywithpaypal'])
    ->name('products.paypal')
    ->middleware('check.for.price');
  Route::middleware(['auth:admin'])->group(function () {
    Route::get('/admin/paypal', [AdminsController::class, 'paywithPaypal'])->name('admin.paypal');
    Route::get('/admin/paypal-success', [AdminsController::class, 'paypalSuccess'])->name('admin.paypal.success');
});


Route::get('products/success', [ProductsController::class, 'success'])
    ->name('products.success')
    ->withoutMiddleware([\App\Http\Middleware\VerifyCsrfToken::class]);
        Route::get('/admin/qr-payment', [AdminsController::class, 'showQrPayment'])->name('admin.qr.payment');

// Receipt view
Route::get('receipt/{id}', [ProductsController::class, 'showReceipt'])
    ->name('receipt.show');

// 📅 Booking
Route::post('products/booking', [ProductsController::class, 'BookingTables'])->name('booking.tables');

// 👤 User actions
Route::get('users/menu', [UsersController::class, 'displayOrders'])->name('users.orders')->middleware('auth:web');
Route::get('users/bookings', [UsersController::class, 'displayBookings'])->name('users.bookings')->middleware('auth:web');
Route::get('users/write-reviews', [UsersController::class, 'writeReviews'])->name('write.reviews')->middleware('auth:web');
Route::post('users/write-reviews', [UsersController::class, 'proccesswriteReviews'])->name('proccess.write.reviews')->middleware('auth:web');

// 🧩 Admin login (public)
Route::get('admin/login', [AdminsController::class, 'viewLogin'])->name('view.login')->middleware('check.for.auth');
Route::post('admin/login', [AdminsController::class, 'checkLogin'])->name('check.login');

// 🔒 Protected Admin routes (only after login)
Route::middleware(['auth:admin'])->group(function () {
    // Dashboard + logout
    Route::get('/admin/dashboard', [AdminsController::class, 'index'])->name('admins.dashboard');
    Route::post('/admin/logout', [AdminsController::class, 'logout'])->name('admin.logout');

    // Admin management
    Route::get('admin/all-admins', [AdminsController::class, 'DisplayAllAdmins'])->name('all.admins');
    Route::get('/create-admins', [AdminsController::class, 'createAdmins'])->name('create.admins');
    Route::post('/create-admins', [AdminsController::class, 'storeAdmins'])->name('store.admins');
    Route::get('/edit-admin/{id}', [AdminsController::class, 'editAdmin'])->name('edit.admin');
    Route::delete('/delete-admin/{id}', [AdminsController::class, 'deleteAdmin'])->name('delete.admin');
    Route::post('/update-admin/{id}', [AdminsController::class, 'updateAdmin'])->name('update.admins');

    // Orders management
    Route::get('admin/all-orders', [AdminsController::class, 'DisplayAllOrders'])->name('all.orders');
    Route::get('admin/edit-orders/{id}', [AdminsController::class, 'EditOrders'])->name('edit.orders');
    Route::post('admin/edit-orders/{id}', [AdminsController::class, 'UpdateOrders'])->name('update.orders');
    Route::delete('admin/delete-orders/{id}', [AdminsController::class, 'DeleteOrders'])->name('delete.orders');

    // Products management
    Route::get('all/products', [AdminsController::class, 'DisplayProducts'])->name('all.products');
    Route::get('/create-products', [AdminsController::class, 'CreateProducts'])->name('create.products');
    Route::get('/edit-products/{id}', [AdminsController::class, 'EditProducts'])->name('edit.products');
    Route::post('/update-products/{id}', [AdminsController::class, 'UpdateProducts'])->name('update.products');
    Route::post('/store-products', [AdminsController::class, 'StoreProducts'])->name('store.products');
    Route::get('/delete-products/{id}', [AdminsController::class, 'DeleteProducts'])->name('delete.products');

    // Bookings management
    Route::get('/all-bookings', [AdminsController::class, 'DisplayBookings'])->name('all.bookings');
    Route::get('/edit-bookings/{id}', [AdminsController::class, 'EditBookings'])->name('edit.bookings');
    Route::post('/update-bookings/{id}', [AdminsController::class, 'UpdateBookings'])->name('update.bookings');
    Route::delete('/delete-bookings/{id}', [AdminsController::class, 'DeleteBookings'])->name('delete.bookings');
    Route::get('/create-bookings', [AdminsController::class, 'CreateBookings'])->name('create.bookings');

    // Other admin tools
    Route::get('/help', [AdminsController::class, 'Help'])->name('admins.help');
    Route::get('/staff-sell', [AdminsController::class, 'StaffSellForm'])->name('staff.sell.form');
    Route::post('/staff-sell', [AdminsController::class, 'StaffSellProduct'])->name('staff.sell');
    Route::post('admin/staff-checkout', [App\Http\Controllers\Admins\AdminsController::class, 'staffCheckout'])->name('staff.checkout')->middleware('auth:admin');
});
    Route::post('/store-bookings', [AdminsController::class, 'StoreBookings'])->name('store.bookings');
