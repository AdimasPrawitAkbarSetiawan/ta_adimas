<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ], [
            'email.required'    => 'Email wajib diisi.',
            'email.email'       => 'Format email tidak valid.',
            'password.required' => 'Password wajib diisi.',
        ]);

        if (!Auth::attempt($request->only('email', 'password'), $request->boolean('remember'))) {
            return back()->withErrors(['email' => 'Email atau password salah.'])->withInput();
        }

        $user = Auth::user();

        if (!$user->is_active) {
            Auth::logout();
            return back()->withErrors(['email' => 'Akun Anda telah dinonaktifkan.'])->withInput();
        }

        $request->session()->regenerate();

        return redirect($this->redirectByRole($user->role));
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }

    private function redirectByRole(string $role): string
    {
        return match($role) {
            'admin'       => route('admin.dashboard'),
            'owner'       => route('owner.dashboard'),
            'marketing'   => route('marketing.dashboard'),
            'operasional' => route('operasional.dashboard'),
            'klien'       => route('klien.dashboard'),
            default       => '/',
        };
    }

    public function showReset()
{
    return view('auth.reset-password');
}

public function reset(Request $request)
{
    $request->validate([
        'email'        => 'required|email|exists:users,email',
        'old_password' => 'required',
        'new_password' => 'required|min:6|confirmed',
    ], [
        'email.exists'        => 'Email tidak ditemukan.',
        'old_password.required' => 'Password lama wajib diisi.',
        'new_password.min'    => 'Password baru minimal 6 karakter.',
        'new_password.confirmed' => 'Konfirmasi password tidak cocok.',
    ]);

    $user = \App\Models\User::where('email', $request->email)->first();

    // Cek password lama
    if (!\Illuminate\Support\Facades\Hash::check($request->old_password, $user->password)) {
        return back()->withErrors(['old_password' => 'Password lama tidak sesuai.'])->withInput();
    }

    // Update password
    $user->update([
        'password' => \Illuminate\Support\Facades\Hash::make($request->new_password)
    ]);

    return redirect()->route('login')->with('success', 'Password berhasil direset! Silakan login.');
}
}