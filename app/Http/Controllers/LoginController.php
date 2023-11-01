<?php

namespace App\Http\Controllers;

use App\Models\Karyawan;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function showLoginForm()
    {
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

        if (auth()->check()) {
            // redirect ke halaman home / intended
            return redirect()->intended('/');
        }
    }

    public function logout()
    {
        auth()->logout();

        session()->invalidate();

        session()->regenerateToken();

        return redirect()->route('login');
    }
}
