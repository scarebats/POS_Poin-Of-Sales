<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SalesController;
use App\Http\Controllers\LevelController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\BarangController;

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

Route::get('/',[WelcomeController::class,'index']);

Route::group(['prefix' => 'user'], function () {
    Route::get('/', [UserController::class, 'index']);          // Menampilkan halaman awal user
    Route::post('/list', [UserController::class, 'list']);      // Menampilkan data user dalam bentuk json untuk datatables
    Route::get('/create', [UserController::class, 'create']);   // menampilkan halaman form tambah user
    Route::post('/', [UserController::class, 'store']);         // menyimpan data user baru
    Route::get('/create_ajax', [UserController::class, 'create_ajax']);         // Menampilkan halaman form tambah user Ajax
    Route::post('/ajax', [UserController::class, 'store_ajax']);                // Menyimpan data user baru Ajax
    Route::get('/{id}', [UserController::class, 'show']);       // menampilkan detail user
    Route::get('/{id}/edit', [UserController::class, 'edit']);  // Menampilkan halaman form edit user
    Route::put('/{id}', [UserController::class, 'update']);     // menyimpan perubahan data user
    Route::get('/{id}/edit_ajax', [UserController::class, 'edit_ajax']);        // Menampilkan halaman form edit user Ajax
    Route::put('/{id}/update_ajax', [UserController::class, 'update_ajax']);    // Menyimpan perubahan data user Ajax
    Route::get('/{id}/delete_ajax', [UserController::class, 'confirm_ajax']);   // Untuk tampilkan form confirm delete user Ajax 
    Route::delete('/{id}/delete_ajax', [UserController::class, 'delete_ajax']); // Untuk hapus data user Ajax 
    Route::delete('/{id}', [UserController::class, 'destroy']); // menghapus data user
});

Route::group(['prefix' => 'level'], function () {
    Route::get('/', [LevelController::class, 'index']);          // Menampilkan halaman awal level
    Route::post('/list', [LevelController::class, 'list']);      // Menampilkan data level dalam bentuk json untuk datatables
    Route::get('/create', [LevelController::class, 'create']);   // menampilkan halaman form tambah level
    Route::post('/', [LevelController::class, 'store']);         // menyimpan data level baru
    Route::get('/create_ajax', [LevelController::class, 'create_ajax']);        // Menampilkan halaman form tambah user Ajax
    Route::post('/ajax', [LevelController::class, 'store_ajax']);               // Menyimpan data user baru Ajax
    Route::get('/{id}', [LevelController::class, 'show']);       // menampilkan detail level
    Route::get('/{id}/edit', [LevelController::class, 'edit']);  // Menampilkan halaman form edit level
    Route::put('/{id}', [LevelController::class, 'update']);     // menyimpan perubahan data level
    Route::get('/{id}/edit_ajax', [LevelController::class, 'edit_ajax']);        // Menampilkan halaman form edit user Ajax
    Route::put('/{id}/update_ajax', [LevelController::class, 'update_ajax']);    // Menyimpan perubahan data user Ajax
    Route::get('/{id}/delete_ajax', [LevelController::class, 'confirm_ajax']);   // Untuk tampilkan form confirm delete level Ajax
    Route::delete('/{id}/delete_ajax', [LevelController::class, 'delete_ajax']); // Untuk hapus data level Ajax
    Route::delete('/{id}', [LevelController::class, 'destroy']); // menghapus data level
});

Route::group(['prefix' => 'kategori'], function () {
    Route::get('/', [KategoriController::class, 'index']);          // Menampilkan halaman awal kategori
    Route::post('/list', [KategoriController::class, 'list']);      // Menampilkan data kategori dalam bentuk json untuk datatables
    Route::get('/create', [KategoriController::class, 'create']);   // menampilkan halaman form tambah kategori 
    Route::post('/', [KategoriController::class, 'store']);         // menyimpan data kategori baru
    Route::get('/create_ajax', [KategoriController::class, 'create_ajax']);         // Menampilkan halaman form tambah kategori Ajax
    Route::post('/ajax', [KategoriController::class, 'store_ajax']);                // Menyimpan data kategori baru Ajax
    Route::get('/{id}', [KategoriController::class, 'show']);       // menampilkan detail kategori
    Route::get('/{id}/edit', [KategoriController::class, 'edit']);  // Menampilkan halaman form edit kategori
    Route::put('/{id}', [KategoriController::class, 'update']);     // menyimpan perubahan data kategori
    Route::get('/{id}/edit_ajax', [KategoriController::class, 'edit_ajax']);        // Menampilkan halaman form edit kategori Ajax
    Route::put('/{id}/update_ajax', [KategoriController::class, 'update_ajax']);    // Menyimpan perubahan data kategori Ajax
    Route::get('/{id}/delete_ajax', [KategoriController::class, 'confirm_ajax']);   // Untuk tampilkan form confirm delete level Ajax
    Route::delete('/{id}/delete_ajax', [KategoriController::class, 'delete_ajax']); // Untuk hapus data level Ajax
    Route::delete('/{id}', [KategoriController::class, 'destroy']); // menghapus data kategori
});

Route::group(['prefix' => 'supplier'], function () {
    Route::get('/', [SupplierController::class, 'index']);          // Menampilkan halaman awal supplier
    Route::post('/list', [SupplierController::class, 'list']);      // Menampilkan data supplier dalam bentuk json untuk datatables
    Route::get('/create', [SupplierController::class, 'create']);   // menampilkan halaman form tambah supplier
    Route::post('/', [SupplierController::class, 'store']);         // menyimpan data supplier baru
    Route::get('/create_ajax', [SupplierController::class, 'create_ajax']);         // Menampilkan halaman form tambah supplier Ajax
    Route::post('/ajax', [SupplierController::class, 'store_ajax']);                // Menyimpan data supplier baru Ajax
    Route::get('/{id}', [SupplierController::class, 'show']);       // menampilkan detail supplier
    Route::get('/{id}/edit', [SupplierController::class, 'edit']);  // Menampilkan halaman form edit supplier
    Route::put('/{id}', [SupplierController::class, 'update']);     // menyimpan perubahan data supplier
    Route::get('/{id}/edit_ajax', [SupplierController::class, 'edit_ajax']);        // Menampilkan halaman form edit supplier Ajax
    Route::put('/{id}/update_ajax', [SupplierController::class, 'update_ajax']);    // Menyimpan perubahan data supplier Ajax
    Route::get('/{id}/delete_ajax', [SupplierController::class, 'confirm_ajax']);   // Untuk tampilkan form confirm delete level Ajax
    Route::delete('/{id}/delete_ajax', [SupplierController::class, 'delete_ajax']); // Untuk hapus data level Ajax
    Route::delete('/{id}', [SupplierController::class, 'destroy']); // menghapus data supplier
});

Route::group(['prefix' => 'barang'], function () {
    Route::get('/', [BarangController::class, 'index']);          // Menampilkan halaman awal barang
    Route::post('/list', [BarangController::class, 'list']);      // Menampilkan data barang dalam bentuk json untuk datatables
    Route::get('/create', [BarangController::class, 'create']);   // menampilkan halaman form tambah barang
    Route::post('/', [BarangController::class, 'store']);         // menyimpan data barang baru
    Route::get('/create_ajax', [BarangController::class, 'create_ajax']);           // Menampilkan halaman form tambah barang Ajax
    Route::post('/ajax', [BarangController::class, 'store_ajax']);                  // Menyimpan data barang baru Ajax
    Route::get('/{id}', [BarangController::class, 'show']);       // menampilkan detail barang
    Route::get('/{id}/edit', [BarangController::class, 'edit']);  // Menampilkan halaman form edit barang
    Route::put('/{id}', [BarangController::class, 'update']);     // menyimpan perubahan data barang
    Route::get('/{id}/edit_ajax', [BarangController::class, 'edit_ajax']);          // Menampilkan halaman form edit barang Ajax
    Route::put('/{id}/update_ajax', [BarangController::class, 'update_ajax']);      // Menyimpan perubahan data barang Ajax
    Route::get('/{id}/delete_ajax', [BarangController::class, 'confirm_ajax']);     // Untuk tampilkan form confirm delete level Ajax
    Route::delete('/{id}/delete_ajax', [BarangController::class, 'delete_ajax']);   // Untuk hapus data level Ajax
    Route::delete('/{id}', [BarangController::class, 'destroy']); // menghapus data barang
});

// Route::get('/', function () {
//     return view('welcome');
// });

// Route::get('/level', [LevelController::class, 'index']);
// Route::get('/kategori', [KategoriController::class, 'index']);
// Route::get('/user', [UserController::class, 'index']);
// Route::get('/user/tambah', [UserController::class, 'tambah']);
// Route::post('/user/tambah_simpan', [UserController::class, 'tambah_simpan']);
// Route::get('/user/ubah/{id}', [UserController::class, 'ubah']);
// Route::put('/user/ubah_simpan/{id}', [UserController::class, 'ubah_simpan']);
// Route::get('/user/hapus/{id}', [UserController::class, 'hapus']);

// Route::get('/', [HomeController::class, 'index'])->name('home');

// Route::prefix('category')->group(function () {
//     Route::get('/food-beverage', [ProductController::class, 'foodBeverage']);
//     Route::get('/beauty-health', [ProductController::class, 'beautyHealth']);
//     Route::get('/home-care', [ProductController::class, 'homeCare']);
//     Route::get('/baby-kid', [ProductController::class, 'babyKid']);
// });

// Route::get('/user/{id}/name/{name}', [UserController::class, 'show']);

// Route::get('/sales', [SalesController::class, 'index'])->name('sales');