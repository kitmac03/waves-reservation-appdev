<?php

use App\Http\Controllers\AdminDashboardController;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\ManagerMiddleware;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserAuthController;
use App\Http\Controllers\RegisteredUserController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\AmenitiesController;

Route::get('/', [UserAuthController::class, 'home'])
    ->name('home');

Route::get('/login', [UserAuthController::class, 'create'])
    ->name('login');

Route::post('/login', [UserAuthController::class, 'store']);

Route::get('/register', [RegisteredUserController::class, 'create'])
    ->name('register');

Route::post('/register', [RegisteredUserController::class, 'store']);

Route::get('/dashboard', [ReservationController::class, 'create'])
->middleware('auth')->name('dashboard');

Route::post('/dashboard', [ReservationController::class, 'store'])
->middleware('auth');

Route::get('admin/dashboard', [AdminDashboardController::class, 'create'])
->middleware(AdminMiddleware::class)->name('admin/dashboard');

Route::get('admin/cottages', [AmenitiesController::class, 'view_cottages'])
->middleware(AdminMiddleware::class)->name('admin/cottages');

Route::post('admin/cottages', [AmenitiesController::class, 'add_cottage'])
    ->name('admin/cottages');

Route::get('admin/tables', [AmenitiesController::class, 'view_tables'])
->middleware(AdminMiddleware::class)->name('admin/cottages');
    
Route::post('admin/tables', [AmenitiesController::class, 'add_table'])
    ->name('admin/tables');

Route::get('admin/create-account', [AdminDashboardController::class, 'create_admin'])
->middleware(ManagerMiddleware::class)->name('admin/create-account');

Route::post('admin/create-account', [AdminDashboardController::class, 'store'])
->name('admin/create-account');