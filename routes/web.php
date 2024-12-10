<?php

use App\Http\Controllers\KelolaAkunController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LandingPageController;
use App\Http\Controllers\MedicineController;
use App\Http\Controllers\OrderController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::middleware(['IsLogout'])->group(function () {
    Route::get('/', function () {
        return view('login');
    })->name('login');

    Route::post('/login', [KelolaAkunController::class, 'loginproses'])->name('login.proses');
});

// daftar halaman yang sudah di akses
Route::middleware(['IsLogin'])->group(function () {
    Route::get('/logout', [KelolaAkunController::class, 'logout'])->name('logout');

    // Route::httpMethod('/path', [NamaController::class, 'namaFunc'])->name('identitas_route');
    // httpMethod 
    // get -> mengambil data/menampilkan halaman,
    // post -> mengirim data ke database (tambah data)
    // patch/put -> mengubah data di database
    // delete -> menghapus data

    Route::get('/landing-page', [LandingPageController::class, 'index'])->name('landing_page');

    Route::middleware(['IsAdmin'])->group(function () {

        // mengelola data obat
        Route::prefix('/data-obat')->name('data_obat.')->group(function () {
            Route::get('/data', [MedicineController::class, 'index'])->name('data');
            Route::get('/tambah', [MedicineController::class, 'create'])->name('tambah');
            Route::post('/tambah/proses', [MedicineController::class, 'store'])->name('tambah.proses');
            Route::get('/ubah/{id}', [MedicineController::class, 'edit'])->name('ubah');
            Route::patch('/ubah/proses/{id}', [MedicineController::class, 'update'])->name('ubah.proses');
            Route::delete('/hapus/{id}', [MedicineController::class, 'destroy'])->name('hapus');
            Route::patch('ubah/stok/{id}', [MedicineController::class, 'updateStock'])->name('ubah.stock');
        });
        // mengelola data akun
        Route::prefix('/kelola-akun')->name('kelola_akun.')->group(function () {
            Route::get('/kelola', [KelolaAkunController::class, 'index'])->name('kelola');
            Route::get('tambah', [KelolaAkunController::class, 'create'])->name('tambah');
            Route::post('/tambah/proses', [KelolaAkunController::class, 'store'])->name('tambah.proses');
            Route::get('/ubah/{id}', [KelolaAkunController::class, 'edit'])->name('ubah');
            Route::patch('/ubah/{id}/proses', [KelolaAkunController::class, 'update'])->name('ubah.proses');
            Route::delete('/hapus/{id}', [KelolaAkunController::class, 'destroy'])->name('hapus');
        });

        
            Route::get('/admin/order', [OrderController::class, 'indexadmin'])->name('admin.order');
            Route::get('/export/excel', [OrderController::class, 'createExcel'])->name('export.excel');
        
    });

    Route::middleware('IsKasir')->group(function () {
        Route::prefix('/kasir')->name('kasir.')->group(function () {
            Route::get('/', [OrderController::class, 'index'])->name('order');
            Route::get('/create', [OrderController::class, 'create'])->name('create');
            Route::post('/store', [OrderController::class, 'store'])->name('store');
            Route::get('/print/{id}', [OrderController::class, 'show'])->name('print');
            Route::get('/download/{id}', [OrderController::class, 'downloadPDF'])->name('download');
        });
    });
});
