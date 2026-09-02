<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        if (Auth::check()) {
            $redirectRoute = Auth::user()->isSuperAdmin()
                ? 'admin.dashboard'
                : 'staf.dashboard';

            return redirect()->route($redirectRoute);
        }

        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'    => 'required|email',
            'password' => 'required|string',
        ]);

        $remember = $request->boolean('remember');

        if (! Auth::attempt($credentials, $remember)) {
            throw ValidationException::withMessages([
                'email' => 'Email atau kata sandi yang Anda masukkan salah.',
            ]);
        }

        $request->session()->regenerate();

        $redirectRoute = Auth::user()->isSuperAdmin()
            ? 'admin.dashboard'
            : 'staf.dashboard';

        return redirect()
            ->intended(route($redirectRoute))
            ->with(
                'success',
                'Selamat datang kembali, ' . Auth::user()->name . '!'
            );
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login')
            ->with('success', 'Anda berhasil keluar.');
    }
}
