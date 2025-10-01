<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    // LOGIN by username (huruf saja)
    public function login(Request $request)
    {
        $data = $request->validate([
            'username' => ['required','regex:/^[A-Za-z]{3,20}$/'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($data, $request->boolean('remember'))) {
            $request->session()->regenerate();
            return redirect()->intended('/dashboard');
        }

        return back()->withErrors(['username' => 'Username atau password salah.'])
                     ->onlyInput('username');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }

    // ⬇⬇⬇ INI YANG HILANG — tampilkan form register
    public function showRegister()
    {
        return view('auth.register');
    }

    // Register: name = username (huruf saja)
    public function register(Request $request)
    {
        $data = $request->validate([
            'username' => ['required','regex:/^[A-Za-z]{3,20}$/','unique:users,username'],
            'email'    => ['required','email','max:255','unique:users,email'],
            'password' => ['required','string','min:8','confirmed'],
        ]);

        $uname = strtolower($data['username']);

        $user = User::create([
            'name'     => $uname,                    // name = username
            'username' => $uname,
            'email'    => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        Auth::login($user);
        $request->session()->regenerate();

        return redirect('/dashboard');
    }
}
