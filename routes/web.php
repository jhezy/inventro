<?php

use App\Http\Controllers\CommodityCategoryController;
use App\Http\Controllers\RabController;
use App\Http\Controllers\CommodityAcquisitionController;
use App\Http\Controllers\CommodityController;
use App\Http\Controllers\CommodityPenyusutanController;
use App\Http\Controllers\CommodityLocationController;
use App\Http\Controllers\PeminjamanController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\LogoutController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VerificationController;
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\ResetPasswordController;
use App\Http\Controllers\BarangKeluarController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('auth.login');
})->middleware('guest');

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login')->middleware('guest');
Route::post('/login', [LoginController::class, 'login'])->middleware('guest');
Route::post('/logout', LogoutController::class)->name('logout')->middleware('auth');

// Form lupa password
Route::get('password/forgot', [ForgotPasswordController::class, 'showForm'])->name('password.request');
Route::post('password/forgot', [ForgotPasswordController::class, 'sendResetLink'])->name('password.email');

// Form reset password


Route::get('password/reset', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('password/reset', [ResetPasswordController::class, 'resetPassword'])->name('password.update');



Route::middleware('auth')->group(function () {

    Route::get('/notifications/read/{id}', function ($id) {
        $notif = DB::table('notifications')
            ->where('id', $id)
            ->where('user_id', auth()->id())
            ->first();

        if ($notif) {
            DB::table('notifications')
                ->where('id', $id)
                ->update(['is_read' => 1]);
            return redirect($notif->link ?? '/');
        }

        return redirect()->back();
    })->name('notifications.read');

    Route::get('/notifications/mark-all-read', function () {
        DB::table('notifications')
            ->where('user_id', auth()->id())
            ->update(['is_read' => 1]);
        return redirect()->back();
    })->name('notifications.markAllRead');


    Route::get('/dashboard', [HomeController::class, 'index'])->name('home');
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');

    Route::resource('barang', CommodityController::class)->except('create', 'edit', 'show')->parameter('barang', 'commodity');
    Route::prefix('barang')->name('barang.')->group(function () {
        Route::post('/print', [CommodityController::class, 'generatePDF'])->name('print');
        Route::post('/print/{id}', [CommodityController::class, 'generatePDFIndividually'])->name('print-individual');
        Route::post('/export', [CommodityController::class, 'export'])->name('export');
        Route::post('/import', [CommodityController::class, 'import'])->name('import');
    });



    Route::resource('penyusutan', CommodityPenyusutanController::class)->except('create', 'edit', 'show')->parameter('penyusutan', 'commodity');
    Route::prefix('penyusutan')->name('penyusutan.')->group(function () {
        Route::post('/print', [CommodityPenyusutanController::class, 'generatePDF'])->name('print');
        Route::post('/print/{id}', [CommodityPenyusutanController::class, 'generatePDFIndividually'])->name('print-individual');
        Route::post('/export', [CommodityPenyusutanController::class, 'export'])->name('export');
        Route::post('/import', [CommodityPenyusutanController::class, 'import'])->name('import');
    });

    // Route::resource(
    //     'commodity-categories',
    //     CommodityCategoryController::class
    // )->except('create', 'edit', 'show')
    //     ->parameter('commodity-categories', 'commodity_category');


    Route::resource('kategori', CommodityCategoryController::class)
        ->except('create', 'edit', 'show')
        ->parameter('kategori', 'commodity_category');

    Route::resource('perolehan', CommodityAcquisitionController::class)
        ->except('create', 'edit', 'show')
        ->parameter('perolehan', 'commodity_acquisition');

    Route::resource('ruangan', CommodityLocationController::class)->except('create', 'edit', 'show')
        ->parameter('ruangan', 'commodity_location');
    Route::post('/ruangan/import', [CommodityLocationController::class, 'import'])->name('ruangan.import');
    Route::post('/ruangan/export', [CommodityLocationController::class, 'export'])->name('ruangan.export');

    Route::resource('rabs', RabController::class);
    Route::get('/rabs/{id}', [RabController::class, 'show'])->name('rabs.show');

    Route::resource('peminjaman', PeminjamanController::class);
    Route::get('peminjaman/approval', [PeminjamanController::class, 'approval'])->name('peminjaman.approval');

    Route::resource('barang-keluar', BarangKeluarController::class)->except('create', 'edit', 'show')->parameter('barang-keluar', 'barang_keluar');
    Route::get('/barang-keluar', [BarangKeluarController::class, 'index'])->name('barang-keluar.index');
    Route::post('/barang-keluar', [App\Http\Controllers\BarangKeluarController::class, 'store'])->name('barang_keluar.store');
    Route::delete('/barang-keluar/{id}', [App\Http\Controllers\BarangKeluarController::class, 'destroy'])->name('barang_keluar.destroy');

    // Resource utama
    Route::resource('peminjaman', PeminjamanController::class);

    // --- Tambahan: approval peminjaman ---
    Route::post('peminjaman/{id}/approve', [PeminjamanController::class, 'approve'])
        ->name('peminjaman.approve');

    Route::post('peminjaman/{id}/reject', [PeminjamanController::class, 'reject'])
        ->name('peminjaman.reject');

    // --- Tambahan: pengembalian barang ---
    Route::post('peminjaman/{id}/kembalikan', [PeminjamanController::class, 'kembalikan'])
        ->name('peminjaman.kembalikan');

    // --- Tambahan: approval pengembalian ---
    Route::post('peminjaman/{id}/approve_pengembalian', [PeminjamanController::class, 'approve_pengembalian'])
        ->name('peminjaman.approve_pengembalian');

    Route::post('peminjaman/{id}/reject_pengembalian', [PeminjamanController::class, 'reject_pengembalian'])
        ->name('peminjaman.reject_pengembalian');

    Route::resource('rab', RabController::class)->except('create', 'edit', 'show')
        ->parameter('rab', 'rab');

    Route::resource('pengguna', UserController::class)->except('create', 'edit', 'show')
        ->parameter('pengguna', 'user');

    Route::resource('peran-dan-hak-akses', RoleController::class)->parameter('peran-dan-hak-akses', 'role');

    Route::get('/verify/qrcode/{encrypted_id}', [VerificationController::class, 'show'])->name('verify.qrcode');
});
