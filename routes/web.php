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

Route::get('/', function () {
    return redirect()->route('login');
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

    // ✅ Generate OTP
    $otp = rand(100000, 999999);

    // ✅ Simpan ke database
    $user->otp = $otp;
    $user->save();

    // ✅ Simpan user ke session sementara
    session(['otp_user_id' => $user->id]);


    // ✅ Kirim email (atau sementara dd dulu)
    // Mail::to($user->email)->send(new \App\Mail\OtpMail($otp));

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

        // hapus OTP setelah berhasil
        $user->otp = null;
        $user->save();

        return redirect('/dashboard');
    } else {
        return back()->with('error', 'OTP salah!');
    }
});

Route::post('/verify-otp', function (Illuminate\Http\Request $request) {
    $user = \App\Models\User::find(session('otp_user_id'));

    if (!$user) {
        return redirect('/login');
    }

    if ($user->otp == $request->otp) {
        Auth::login($user);

        // hapus OTP setelah berhasil
        $user->otp = null;
        $user->save();

        return redirect('/dashboard');
    } else {
        return back()->with('error', 'OTP salah!');
    }
});

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