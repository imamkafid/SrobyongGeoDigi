<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Warga;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'nik' => 'required|string',
            'password' => 'required_if:role,admin',
            'role' => 'required|in:admin,warga'
        ]);

        if ($credentials['role'] === 'admin') {
            // Cek login admin dengan password langsung (tanpa hash)
            $admin = Admin::where('nik', $credentials['nik'])
                        ->where('password', $credentials['password'])
                        ->first();
            
            if ($admin) {
                session(['role' => 'admin', 'nik' => $admin->nik]);
                return redirect()->route('admin.dashboard');
            }
        } else {
            // Cek login warga (hanya dengan NIK)
            $warga = Warga::where('nik', $credentials['nik'])->first();
            
            if ($warga) {
                session(['role' => 'warga', 'nik' => $warga->nik]);
                return redirect()->route('warga.dashboard');
            }
        }

        return back()->withErrors(['login' => 'NIK atau password tidak valid']);
    }

    public function logout()
    {
        session()->flush();
        return redirect()->route('login');
    }
}