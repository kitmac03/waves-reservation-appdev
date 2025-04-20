<?php

use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\ManagerProfileController;
use App\Http\Controllers\Admin\AmenitiesController;
use App\Http\Controllers\vendor\ReservationRecordController;
use App\Http\Controllers\Vendor\PaymentController;
use App\Http\Controllers\Customer\ProfileController;
use App\Http\Controllers\Customer\ReservationController;
use App\Http\Controllers\Customer\DownpaymentController;
use App\Http\Controllers\UserAuthController;
use App\Http\Controllers\EmptyyController;
use App\Http\Controllers\Customer\RegisteredUserController;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\ManagerMiddleware;
use App\Http\Middleware\VendorMiddleware;
use App\Models\Reservation;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;

//  Home & Authentication Routes
Route::get('/', [UserAuthController::class, 'home'])->name('home');
Route::get('/login', [UserAuthController::class, 'create'])->name('login');
Route::post('/login', [UserAuthController::class, 'store']);
Route::get('/register', [RegisteredUserController::class, 'create'])->name('register');
Route::post('/register', [RegisteredUserController::class, 'store'])->name('cust.register');
Route::post('/logout', [UserAuthController::class, 'logout'])->name('logout');
//Route::get('/empty', [EmptyyController::class, 'emptyTables'])->name('login'); 
// Customer Routes
Route::middleware('auth')->group(function () {
    Route::get('customer/profile', [ProfileController::class, 'view_profile'])
    ->name('customer.profile');
    Route::get('customer/dashboard', [ReservationController::class, 'create'])
    ->name('customer.dashboard');
    Route::get('customer/reservation', [ReservationController::class, 'create'])
    ->name('customer.reservation');
    Route::post('customer/reservation/store', [ReservationController::class, 'store'])
    ->middleware('auth')
    ->name('reservation.store');
    Route::post('customer/dashboard/reserve', [ReservationController::class, 'store'])
    ->name('customer.reserve');
    Route::get('customer/profile', [ProfileController::class, 'view_profile'])
    ->name('customer.profile');
    Route::get('customer/profile/{id}/edit', [ProfileController::class, 'edit_profile'])
    ->name('profile.edit');
    Route::patch('customer/profile/{id}/update', [ProfileController::class, 'update_profile'])
    ->name('profile.update');
    Route::get('customer/reservation-records', [ReservationController::class, 'view_reservations'])
    ->name('customer.reservation.records');
    Route::get('customer/balance', [ReservationController::class, 'view_balance'])
    ->name('customer.reservation.balance');
    Route::get('customer/check-availability', [ReservationController::class, 'checkAvailability']);
    Route::post('customer/reservation-records/{reservation}/cancel', [ReservationController::class, 'cancel_reservation'])
    ->name('cancel.reservation');

});

// Downpayment routes
Route::middleware(['auth'])->prefix('customer')->name('customer.')->group(function () {
    Route::get('/downpayment/{reservation}', [DownpaymentController::class, 'show'])
    ->name('downpayment.show');
    Route::post('/downpayment/{reservation}', [DownpaymentController::class, 'store'])
    ->name('downpayment.store');
});

//  Admin Routes
Route::middleware(AdminMiddleware::class)->group(function () {
    Route::get('admin/dashboard', [AdminDashboardController::class, 'create'])
    ->name('admin.dashboard');
    Route::get('admin/create-account', [AdminDashboardController::class, 'create_admin'])
    ->middleware(ManagerMiddleware::class)->name('admin.create.account');
    Route::post('admin/create-account', [AdminDashboardController::class, 'store']);
    Route::get('admin/reservation-list', [ManagerProfileController::class, 'view_reservation_list'])
    ->middleware(ManagerMiddleware::class)->name('admin.reservation.list');
    Route::get('admin/all-reservations', [ManagerProfileController::class, 'view_all_reservations'])
    ->middleware(ManagerMiddleware::class)->name('admin.all.reservations');
    Route::get('admin/manager-profile', [ManagerProfileController::class, 'view_profile'])
    ->middleware(ManagerMiddleware::class)->name('admin.manager.profile');
    Route::get('admin/vendors-list', [ManagerProfileController::class, 'view_vendors_list'])
    ->middleware(ManagerMiddleware::class)->name('admin.vendors.list');
    Route::get('admin/delete-requests', [ManagerProfileController::class, 'view_del_req'])
    ->middleware(ManagerMiddleware::class)->name('admin.delete.requests');
});

//  Vendor Routes
Route::middleware(VendorMiddleware::class)->group(function () {
    Route::get('admin/vendor/cottages', [AmenitiesController::class, 'view_cottages'])
    ->name('admin.vendor.cottages');
    Route::get('admin/vendor/amenities', [AmenitiesController::class, 'view_tables'])
    ->name('admin.vendor.tables');
    Route::get('admin/vendor/calendar', [ReservationRecordController::class, 'view_reservation'])
    ->name('admin.vendor.reservation_calendar');
    Route::get('admin/vendor/reservation', [ReservationRecordController::class, 'view_history'])
    ->name('admin.vendor.reservation_records');
    Route::get('admin/vendor/balance', [ReservationRecordController::class, 'view_balance'])
    ->name('admin.vendor.remainingbal');
    Route::get('admin/vendor/calendar', [ReservationRecordController::class, 'view_reservation'])
    ->name('admin.vendor.reservation_calendar');
    Route::get('admin/vendor/reservation', [ReservationRecordController::class, 'view_history'])
    ->name('admin.vendor.reservation_records');
    Route::get('admin/vendor/balance', [ReservationRecordController::class, 'view_balance'])
    ->name('admin.vendor.remainingbal');
    Route::get('/api/events', [ReservationRecordController::class, 'getEvents']);
    Route::post('/admin/vendor/process-payment', [PaymentController::class, 'processPayment'])
    ->name('admin.vendor.process-payment');
    Route::post('/admin/vendor/invalid-payment', [PaymentController::class, 'invalidPayment'])
    ->name('admin.vendor.invalid-payment');
    Route::get('admin/vendor/edit-reservations', [ReservationRecordController::class, 'view_edit_reservations'])
    ->name('admin.vendor.edit-res-req');
    Route::get('/admin/vendor/walk-in', [ReservationRecordController::class, 'create_walkIn'])
    ->name('admin.vendor.walk_in');
    Route::post('/admin/vendor/walk-in', [ReservationRecordController::class, 'custom_walkIn'])
    ->name('admin.vendor.walk_in.store');
    Route::get('admin/vendor/payment/{reservation}', [ReservationRecordController::class, 'payment_show'])
    ->name('admin.vendor.reservations.payment.show');
});

//  Amenities Routes (Manager Only)
Route::middleware([ManagerMiddleware::class])->group(function () {
    // Cottages
    Route::get('admin/cottages', [AmenitiesController::class, 'view_cottages'])
    ->name('admin.cottages');
    Route::post('admin/cottages', [AmenitiesController::class, 'add_cottage'])
    ->name('cottages.store');
    Route::get('/cottages/{id}/edit', [AmenitiesController::class, 'edit_cottage'])
    ->name('cottages.edit');
    Route::patch('/cottages/{id}/update', [AmenitiesController::class, 'update_cottage'])
    ->name('cottages.update');
    Route::patch('admin/cottages/{id}/archive', [AmenitiesController::class, 'archive_cottage'])
    ->name('cottages.archive');
    Route::patch('admin/cottages/{id}/unarchive', [AmenitiesController::class, 'unarchive_cottage'])
    ->name('cottages.unarchive');

    // Tables
    Route::get('admin/tables', [AmenitiesController::class, 'view_tables'])
    ->name('admin.tables');
    Route::post('admin/tables', [AmenitiesController::class, 'add_table'])
    ->name('tables.store');
    Route::patch('admin/tables/{id}/update', [AmenitiesController::class, 'update_table'])
    ->name('tables.update');
    Route::get('admin/tables/{id}/edit', [AmenitiesController::class, 'edit_table'])
    ->name('tables.edit');
    Route::patch('admin/tables/{id}/archive', [AmenitiesController::class, 'archive_table'])
    ->name('tables.archive');
    Route::patch('admin/tables/{id}/unarchive', [AmenitiesController::class, 'unarchive_table'])
    ->name('tables.unarchive');
});
