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
        Route::patch('/users/{id}/deactivate', [UserController::class, 'deactivate'])->name('users.deactivate');

        Route::patch('/kategori-barangs/{id}/deactivate', [KategoriBarangController::class, 'deactivate'])->name('kategori-barangs.deactivate');

        Route::patch('/detail-gudangs/{id}/deactivate', [DetailGudangController::class, 'deactivate'])->name('detail-gudangs.deactivate');

        Route::resource('tokos', TokoController::class);
        Route::patch('/tokos/{id}/deactivate', [TokoController::class, 'deactivate'])->name('tokos.deactivate');

        Route::resource('suppliers', SupplierController::class);
        Route::patch('/suppliers/{id}/deactivate', [SupplierController::class, 'deactivate'])->name('suppliers.deactivate');

        Route::resource('gudangs', GudangController::class);
        Route::patch('/gudangs/{id}/toggle', [GudangController::class, 'toggle'])->name('gudangs.toggle');
    });

    Route::middleware(['role:SuperAdmin,Admin'])->group(function () {
        Route::resource('barangs', BarangController::class);
        Route::patch('/barangs/{id}/deactivate', [BarangController::class, 'deactivate'])->name('barangs.deactivate');
        
        Route::resource('kategori-barangs', KategoriBarangController::class);
    
        Route::resource('detail-gudangs', DetailGudangController::class);
        
        Route::resource('pusat-ke-suppliers', PusatKeSupplierController::class);
        Route::patch('/pusat-ke-suppliers/{id}/deactivate', [PusatKeSupplierController::class, 'deactivate'])->name('pusat-ke-suppliers.deactivate');
        Route::patch('/pusat-ke-suppliers/{id}/update-status', [PusatKeSupplierController::class, 'updateStatus'])->name('pusat-ke-suppliers.update-status');
        Route::get('/pusat-ke-suppliers/{id}/invoice', [PusatKeSupplierController::class, 'downloadInvoice'])->name('pusat-ke-suppliers.invoice');

        Route::resource('cabang-ke-pusats', CabangKePusatController::class);
        Route::patch('/cabang-ke-pusats/{id}/deactivate', [CabangKePusatController::class, 'deactivate'])->name('cabang-ke-pusats.deactivate');
        Route::patch('/cabang-ke-pusats/{id}/update-status', [CabangKePusatController::class, 'updateStatus'])->name('cabang-ke-pusats.update-status');
        Route::get('/cabang-ke-pusats/{id}/invoice', [CabangKePusatController::class, 'downloadInvoice'])->name('cabang-ke-pusats.invoice');
    
        Route::resource('cabang-ke-tokos', CabangKeTokoController::class);
        Route::patch('/cabang-ke-tokos/{id}/deactivate', [CabangKeTokoController::class, 'deactivate'])->name('cabang-ke-tokos.deactivate');
        Route::patch('/cabang-ke-tokos/{id}/update-status', [CabangKeTokoController::class, 'updateStatus'])->name('cabang-ke-tokos.update-status');
        Route::get('/cabang-ke-tokos/{id}/invoice', [CabangKeTokoController::class, 'downloadInvoice'])->name('cabang-ke-tokos.invoice');

        Route::resource('pusat-ke-cabangs', PusatKeCabangController::class);
        Route::patch('/pusat-ke-cabangs/{id}/deactivate', [PusatKeCabangController::class, 'deactivate'])->name('pusat-ke-cabangs.deactivate');
        Route::patch('/pusat-ke-cabangs/{id}/update-status', [PusatKeCabangController::class, 'updateStatus'])->name('pusat-ke-cabangs.update-status');
        Route::get('/pusat-ke-cabangs/{id}/invoice', [PusatKeCabangController::class, 'downloadInvoice'])->name('pusat-ke-cabangs.invoice');

        Route::resource('penerimaan-di-pusats', PenerimaanDiPusatController::class);
        Route::patch('/penerimaan-di-pusats/{id}/deactivate', [PenerimaanDiPusatController::class, 'deactivate'])->name('penerimaan-di-pusats.deactivate');
        Route::get('/penerimaan-di-pusats/{id}/invoice', [PenerimaanDiPusatController::class, 'downloadInvoice'])->name('penerimaan-di-pusats.invoice');

        Route::resource('penerimaan-di-cabangs', PenerimaanDiCabangController::class);
        Route::patch('/penerimaan-di-cabangs/{id}/deactivate', [PenerimaanDiCabangController::class, 'deactivate'])->name('penerimaan-di-cabangs.deactivate');
        Route::get('/penerimaan-di-cabangs/{id}/invoice', [PenerimaanDiCabangController::class, 'downloadInvoice'])->name('penerimaan-di-cabangs.invoice');
    });
});