<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class ResetPasswordController extends Controller
{
    // Tampilkan form reset password
    public function showResetForm()
    {
        return view('auth.reset');
    }

    // Proses reset password
    public function resetPassword(Request $request)
    {
        // Validasi input
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6|confirmed', // harus ada password_confirmation
        ]);

        // Cari user berdasarkan email
        $user = DB::table('users')->where('email', $request->email)->first();

        if (!$user) {
            return back()->withErrors(['email' => 'Email tidak ditemukan.'])->withInput();
        }

        // Update password
        DB::table('users')->where('email', $request->email)->update([
            'password' => Hash::make($request->password),
            'updated_at' => now(),
        ]);

        return redirect()->route('login')->with('success', 'Password berhasil diubah. Silakan login.');
    }
}
