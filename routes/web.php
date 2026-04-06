<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\BukuController;
use Illuminate\Support\Facades\Route;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Buku;
use App\Http\Controllers\TagHargaController;
use App\Http\Controllers\WeekEmpat;
use App\Http\Controllers\WilayahController;
use App\Http\Controllers\PosController;
use App\Http\Controllers\KantinController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\VendorController;

/*
|--------------------------------------------------------------------------
| FIX: HALAMAN AWAL → KANTIN
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return redirect('/kantin'); // ✅ sebelumnya login
});


Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

Route::middleware('auth')->group(function () {

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('kategori', KategoriController::class);
    Route::resource('buku', BukuController::class);

});

require __DIR__ . '/auth.php';

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/auth/google', function () {
    return Socialite::driver('google')->redirect();
});

Route::get('/auth/google/callback', function () {
    $googleUser = Socialite::driver('google')->stateless()->user();

    $user = User::firstOrCreate([
        'email' => $googleUser->email,
    ], [
        'name' => $googleUser->name,
        'password' => bcrypt('123456'),
    ]);

    $otp = rand(100000, 999999);
    $user->otp = $otp;
    $user->save();

    session(['otp_user_id' => $user->id]);

    Mail::to($user->email)->send(new \App\Mail\OtpMail($otp));

    return redirect()->route('otp');
});

Route::get('/otp', function () {
    return view('otp');
})->name('otp');

Route::post('/verify-otp', function (Illuminate\Http\Request $request) {
    $user = \App\Models\User::find(session('otp_user_id'));

    if (!$user) {
        return redirect('/login');
    }

    if ($user->otp == $request->otp) {
        Auth::login($user);
        $user->otp = null;
        $user->save();

        return redirect('/dashboard');
    } else {
        return back()->with('error', 'OTP salah!');
    }
});

/*
|--------------------------------------------------------------------------
| PDF & TAG
|--------------------------------------------------------------------------
*/

Route::get('/export-pdf', function () {
    $data = Buku::all();
    $pdf = Pdf::loadView('pdf.buku', compact('data'));
    return $pdf->download('data-buku.pdf');
});

Route::get('/pdf-sertifikat', function () {
    $pdf = PDF::loadView('pdf.sertifikat')
        ->setPaper('A4', 'landscape');

    return $pdf->download('sertifikat.pdf');
});

Route::get('/pdf-surat', function () {
    $pdf = PDF::loadView('pdf.surat');
    return $pdf->download('surat.pdf');
});

Route::get('/tagharga', [TagHargaController::class, 'index']);
Route::get('/tagharga/create', [TagHargaController::class, 'create']);
Route::post('/tagharga/store', [TagHargaController::class, 'store']);
Route::get('/tagharga/edit/{id}', [TagHargaController::class, 'edit']);
Route::post('/tagharga/update/{id}', [TagHargaController::class, 'update']);
Route::get('/tagharga/delete/{id}', [TagHargaController::class, 'delete']);
Route::post('/tagharga/cetak', [TagHargaController::class, 'cetak']);

/*
|--------------------------------------------------------------------------
| MODUL
|--------------------------------------------------------------------------
*/

Route::get('/modul-html', function () {
    return view('modul.table-html');
});

Route::get('/modul-datatable', function () {
    return view('modul.table-datatable');
});

Route::get('/select-kota', function () {
    return view('modul.select-kota');
});

/*
|--------------------------------------------------------------------------
| AJAX & WILAYAH (TIDAK DIUBAH)
|--------------------------------------------------------------------------
*/

Route::get('/week4', [WeekEmpat::class, 'index']);

Route::post('/ajax-submit', [WeekEmpat::class, 'submit'])
    ->name('ajax.submit');

Route::get('/wilayah-ajax', [WilayahController::class, 'ajaxPage'])
    ->name('wilayah.ajax');

Route::get('/wilayah-axios', [WilayahController::class, 'axiosPage'])
    ->name('wilayah.axios');

Route::get('/wilayah', [WilayahController::class, 'index'])->name('wilayah.index');

Route::post('/get-kabupaten', [WilayahController::class, 'getKabupaten'])->name('wilayah.kabupaten');
Route::post('/get-kecamatan', [WilayahController::class, 'getKecamatan'])->name('wilayah.kecamatan');
Route::post('/get-kelurahan', [WilayahController::class, 'getKelurahan'])->name('wilayah.kelurahan');

/*
|--------------------------------------------------------------------------
| POS (TIDAK DIUBAH)
|--------------------------------------------------------------------------
*/

Route::get('/pos', [PosController::class, 'index'])->name('pos.index');
Route::post('/get-barang', [PosController::class, 'getBarang'])->name('pos.barang');
Route::post('/tambah-item', [PosController::class, 'tambahItem'])->name('pos.tambah');
Route::post('/bayar', [PosController::class, 'bayar'])->name('pos.bayar');
Route::post('/pos/simpan', [PosController::class, 'simpan'])->name('pos.simpan');

Route::get('/penjualan', [PosController::class, 'riwayat'])->name('penjualan.index');
Route::get('/penjualan/{id}', [PosController::class, 'detail'])->name('penjualan.detail');

Route::get('/pos-ajax', function () {
    return view('pos_ajax.index');
})->name('pos.ajax');

Route::get('/pos-axios', function () {
    return view('pos_axios.index');
})->name('pos.axios');

/*
|--------------------------------------------------------------------------
| FIX: KANTIN (HANYA 1 ROUTE)
|--------------------------------------------------------------------------
*/
Route::get('/kantin', [KantinController::class, 'index'])->name('kantin');

/*
|--------------------------------------------------------------------------
| VENDOR
|--------------------------------------------------------------------------
*/
Route::get('/vendor', function () {
    return view('vendor.index');
})->name('vendor');
Route::get('/vendor', [KantinController::class, 'vendor']);
Route::get('/vendor/lunas', [KantinController::class, 'vendorLunas']);

Route::post('/checkout', [KantinController::class, 'checkout'])->name('kantin.checkout');
Route::get('/get-menu/{vendor}', [KantinController::class, 'getMenu']);
Route::get('/bayar-midtrans/{id}', [KantinController::class, 'bayarMidtrans']);
Route::post('/midtrans-callback', [KantinController::class, 'callback']);
Route::get('/check-status/{order_id}', [KantinController::class, 'checkStatus']);
Route::get('/fake-success/{id}', [KantinController::class, 'fakeSuccess']);
Route::get('/vendor/create', [VendorController::class, 'create']);
Route::post('/vendor/store', [VendorController::class, 'store']);
Route::get('/menu/create/{vendor_id}', [MenuController::class, 'create']);
Route::post('/menu/store', [MenuController::class, 'store']);
Route::get('/vendor/dashboard', function () {
    return view('vendor.dashboard');
});
Route::get('/menu/create', [MenuController::class, 'create']);
Route::post('/menu/store', [MenuController::class, 'store']);
Route::get('/menu/edit/{id}', [MenuController::class, 'edit']);
Route::post('/menu/update/{id}', [MenuController::class, 'update']);
Route::get('/menu/delete/{id}', [MenuController::class, 'destroy']);
Route::get('/vendor/create', [VendorController::class, 'create']);
Route::post('/vendor/store', [VendorController::class, 'store']);
Route::get('/vendor/create', [VendorController::class, 'create']);
Route::post('/vendor/store', [VendorController::class, 'store']);
Route::delete('/vendor/{id}', [VendorController::class, 'destroy']);
Route::get('/vendor/{id}/edit', [VendorController::class, 'edit']);
Route::put('/vendor/{id}', [VendorController::class, 'update']);