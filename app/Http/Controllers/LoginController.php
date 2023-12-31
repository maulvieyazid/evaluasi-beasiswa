<?php

namespace App\Http\Controllers;

use App\Models\Karyawan;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        // Jika sudah login, langsung arahkan ke halaman home
        if (auth()->check()) return redirect()->route('home');

        return view('auth.login');
    }

    public function login(Request $req)
    {
        // Ambil Karyawan yang nik nya sesuai request
        // yang aktif, dan yang pass kar ok nya bernilai true
        $karyawan = Karyawan::where('nik', $req->nik)
            ->aktif()
            ->whereRaw("PASS_KAR_OK(nik, ?) = 'TRUE'", [$req->pin])
            ->first();


        // Kalo $karyawan nya null, maka redirect ke halaman login
        if (!$karyawan) return redirect()->route('login')->with('danger', 'NIK/PIN salah')->withInput();

        // Kalo ada, maka set sebagai user auth
        auth()->login($karyawan);

        // redirect ke halaman home / intended
        if (auth()->check()) return redirect()->intended('/');
    }

    public function logout()
    {
        auth()->logout();

        session()->invalidate();

        session()->regenerateToken();

        return redirect()->route('login');
    }
}
