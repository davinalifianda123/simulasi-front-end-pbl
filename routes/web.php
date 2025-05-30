<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TokoController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\GudangController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CabangKeTokoController;
use App\Http\Controllers\DetailGudangController;
use App\Http\Controllers\TokoKeCabangController;
use App\Http\Controllers\CabangKePusatController;
use App\Http\Controllers\PusatKeCabangController;
use App\Http\Controllers\KategoriBarangController;
use App\Http\Controllers\PusatKeSupplierController;
use App\Http\Controllers\SupplierKePusatController;
use App\Http\Controllers\PenerimaanDiPusatController;
use App\Http\Controllers\PenerimaanDiCabangController;

Route::get('/', function () {
  return redirect()->route('login');
});

// Halaman untuk guest (login, register, dll)
Route::middleware('jwt.guest')->group(function () {
    Route::get('/login', function () {
        return view('Auth.login');
    })->name('login');

    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
});
  
// Halaman yang hanya untuk user yang sudah login
Route::middleware('jwt.auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // dashboard
    Route::middleware(['role:SuperAdmin,Supervisor,Admin'])->group(function () {
        Route::resource('dashboard', DashboardController::class);
        Route::post('dashboard-graph', [DashboardController::class, 'dashboardGraph'])->name('dashboard.graph');
        Route::post('dashboard-low-stock', [DashboardController::class, 'dashboardLowStock'])->name('dashboard.low-stock');

        Route::resource('profile', ProfileController::class);
    });

    Route::middleware(['role:SuperAdmin'])->group(function () {
        Route::resource('users', UserController::class);

        Route::resource('kategori-barangs', KategoriBarangController::class);
        Route::patch('kategori-barangs/{id}/activate', [KategoriBarangController::class, 'activate'])->name('kategori-barangs.activate');
        Route::patch('kategori-barangs/{id}/deactivate', [KategoriBarangController::class, 'deactivate'])->name('kategori-barangs.deactivate');
    
        Route::resource('tokos', TokoController::class);
        Route::patch('tokos/{id}/activate', [TokoController::class, 'activate'])->name('tokos.activate');
        Route::patch('tokos/{id}/deactivate', [TokoController::class, 'deactivate'])->name('tokos.deactivate');
    
        Route::resource('suppliers', SupplierController::class);
        Route::patch('suppliers/{id}/activate', [SupplierController::class, 'activate'])->name('supplier.activate');
        Route::patch('suppliers/{id}/deactivate', [SupplierController::class, 'activate'])->name('supplier.deactivate');
    
        Route::resource('gudangs', GudangController::class);
        Route::patch('gudangs/{id}/activate', [GudangController::class, 'activate'])->name('gudangs.activate');
        Route::patch('gudangs/{id}/deactivate', [GudangController::class, 'deactivate'])->name('gudangs.deactivate');
    });

    Route::middleware(['role:SuperAdmin,Admin'])->group(function () {
        // Route::resource('barangs', BarangController::class);
        // Route::patch('barangs/{id}/activate', [BarangController::class, 'activate'])->name('barangs.activate');
        // Route::patch('barangs/{id}/deactivate', [BarangController::class, 'deactivate'])->name('barangs.deactivate');
        Route::resource('kategori-barangs', KategoriBarangController::class);
    
        Route::resource('pusat-ke-suppliers', PusatKeSupplierController::class);
    
        Route::resource('cabang-ke-pusats', CabangKePusatController::class);
    
        Route::resource('cabang-ke-tokos', CabangKeTokoController::class);
    
        Route::resource('supplier-ke-pusats', SupplierKePusatController::class);
    
        Route::resource('penerimaan-di-pusats', PenerimaanDiPusatController::class);
    
        Route::resource('detail-gudangs', DetailGudangController::class);
    
        Route::resource('pusat-ke-cabangs', PusatKeCabangController::class);
    
        Route::resource('penerimaan-di-cabangs', PenerimaanDiCabangController::class);
    
        Route::resource('toko-ke-cabangs', TokoKeCabangController::class);
    });
});