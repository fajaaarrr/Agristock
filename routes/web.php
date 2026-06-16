<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\IncomingGoodsController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\OutgoingGoodsController;
use App\Http\Controllers\ReportController;
use Illuminate\Support\Facades\Route;

// Home root displays the welcome landing page
Route::get('/', function () {
    return view('welcome');
});

// Authentication routes (Guest)
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

// Protected routes (Admin Gudang)
Route::middleware('auth')->group(function () {
    // Logout
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Category CRUD (no show details view needed for categories)
    Route::resource('categories', CategoryController::class)->except(['show']);

    // Item CRUD (complete resource with index, show, create, edit, update, destroy)
    Route::resource('items', ItemController::class);

    // Incoming Goods transactions (CRUD, but typically resource with list, create, store, delete)
    Route::resource('incoming-goods', IncomingGoodsController::class)->only(['index', 'create', 'store', 'destroy']);

    // Outgoing Goods transactions (CRUD, but typically resource with list, create, store, delete)
    Route::resource('outgoing-goods', OutgoingGoodsController::class)->only(['index', 'create', 'store', 'destroy']);

    // Reports Page
    Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
});
