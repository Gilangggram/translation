<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Auth;

class AdminAuthController extends Controller
{
    public function index() {
        return view('auth.admin-login');
    }

    public function login(LoginRequest $request) {
        
        $credentials = $request->only('phone_number', 'password');

        if (Auth::guard('admin')->attempt($credentials)) {
            
            $request->session()->regenerate();
            
            return match(Auth::guard('admin')->user()->role) {
                'admin' => redirect()->route('admin.dashboard'),
                'kasir' => redirect()->route('kasir.dashboard'),
            };
        } 
        
        return back()->withErrors([
            'login' => 'Nomor telepon atau password salah.',
        ])->onlyInput('phone_number');
        
    }

    public function logout() {

    }
}
