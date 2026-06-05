<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StallAuthController extends Controller
{
    public function index() {
        return view('auth.stall-login');
    }

    public function login(LoginRequest $request) {
        
        $credentials = $request->only('phone_number', 'password');

        if (Auth::guard('stall')->attempt($credentials)) {
            
            $request->session()->regenerate();
            return redirect()->route('stall.dashboard');
        } 

        return back()->withErrors([
            'login' => 'Nomor telepon atau password salah.',
        ])->onlyInput('phone_number');
    }

    public function logout(Request $request) {
        Auth::guard('stall')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('stall.login');
    }
}
