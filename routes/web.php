<?php

use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\ManagerProfileController;
use App\Http\Controllers\Customer\ProfileController;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\ManagerMiddleware;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserAuthController;
use App\Http\Controllers\Customer\RegisteredUserController;
use App\Http\Controllers\Customer\ReservationController;
use App\Http\Controllers\Admin\AmenitiesController;

Route::get('/', [UserAuthController::class, 'home'])
    ->name('home');

Route::get('/login', [UserAuthController::class, 'create'])
    ->name('login');

Route::post('/login', [UserAuthController::class, 'store']);

Route::get('/register', [RegisteredUserController::class, 'create'])
    ->name('register');

Route::post('/register', [RegisteredUserController::class, 'store']);

Route::get('customer/dashboard', [ReservationController::class, 'create'])
->middleware('auth')->name('customer/dashboard');

Route::post('customer/dashboard', [ReservationController::class, 'store'])
->middleware('auth')->name('reservation.store');;

Route::get('admin/dashboard', [AdminDashboardController::class, 'create'])
->middleware(AdminMiddleware::class)->name('admin/dashboard');

Route::middleware([ManagerMiddleware::class])->group(function () {
    Route::get('admin/cottages', [AmenitiesController::class, 'view_cottages'])->name('admin.cottages');
    Route::post('admin/cottages', [AmenitiesController::class, 'add_cottage'])->name('cottages.store');
    Route::get('admin/cottages/{id}/edit', [AmenitiesController::class, 'edit_cottage'])->name('cottages.edit');
    Route::patch('admin/cottages/{id}/archive', [AmenitiesController::class, 'archive_cottage'])->name('cottages.archive');
});

Route::get('admin/tables', [AmenitiesController::class, 'view_tables'])
->middleware(ManagerMiddleware::class)->name('admin/tables');
    
Route::post('admin/tables', [AmenitiesController::class, 'add_table'])
    ->name('admin/tables');

Route::get('admin/create-account', [AdminDashboardController::class, 'create_admin'])
->middleware(ManagerMiddleware::class)->name('admin/create-account');

Route::post('admin/create-account', [AdminDashboardController::class, 'store'])
->name('admin/create-account');

Route::get('admin/reservation-list', [ManagerProfileController::class, 'view_reservation_list'])
->middleware(ManagerMiddleware::class)->name('admin/reservation-list');

// Route::post('admin/reservation-list', [AdminDashboardController::class, 'store'])
// ->name('admin/create-account');

Route::get('admin/all-reservations', [ManagerProfileController::class, 'view_all_reservations'])
->middleware(ManagerMiddleware::class)->name('admin/all-reservations');

// Route::post('admin/reservation-list', [AdminDashboardController::class, 'store'])
// ->name('admin/create-account');

Route::get('admin/manager-profile', [ManagerProfileController::class, 'view_profile'])
->middleware(ManagerMiddleware::class)->name('admin/manager-profile');

// Route::post('admin/manager-profile', [ManagerProfileController::class, 'store'])
// ->name('admin/manager-profile');

Route::get('admin/vendors-list', [ManagerProfileController::class, 'view_vendors_list'])
->middleware(ManagerMiddleware::class)->name('admin/vendors-list');

// Route::post('admin/vendors-list', [ManagerProfileController::class, 'view_vendors_list'])
// ->middleware(ManagerMiddleware::class)->name('admin/vendors-list');

Route::get('admin/delete-requests', [ManagerProfileController::class, 'view_del_req'])
->middleware(ManagerMiddleware::class)->name('admin/delete-requests');

// Route::post('admin/delete-requests', [ManagerProfileController::class, 'view_del_req'])
// ->middleware(ManagerMiddleware::class)->name('admin/delete-requests');

Route::get('customer/profile', [ProfileController::class, 'view_profile'])
->middleware('auth')->name('customer/profile');

// Route::post('customer/profile', [ProfileController::class, 'edit_profile'])
// ->middleware('auth')->name('customer/profile');

Route::get('customer/reservation-records', [ProfileController::class, 'view_reservations'])
->middleware('auth')->name('customer/reservation-records');

// Route::post('customer/profile', [ProfileController::class, 'edit_profile'])
// ->middleware('auth')->name('customer/profile');