<?php

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function verifyOtp(Request $request)
    {
        $user = User::find(session('otp_user_id'));

        if ($user && $user->otp == $request->otp) {
            Auth::login($user);

            // hapus OTP setelah dipakai
            $user->otp = null;
            $user->save();

            return redirect('/home');
        }

        return back()->with('error', 'OTP salah');
    }
}
