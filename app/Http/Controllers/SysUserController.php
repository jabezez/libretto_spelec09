<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\SysUser;

class SysUserController extends Controller
{
    public function login(){
        return view('auth.login');
    }

    public function authenticate(Request $request){
        $credentials = $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended('/dashboard');
        }

        return back()->withErrors([
            'username' => 'The provided credentials do not match our records.',
        ]);
    }

    public function register(){
        return view('auth.register');
    }

    public function store(Request $request){
        $validated = $request->validate([
            'username' => 'required|unique:sys_users',
            'password' => 'required|min:6',
        ]);

        SysUser::create([
            'username' => $validated['username'],
            'password' => bcrypt($validated['password']),
        ]);

        return redirect()->route('login');
    }
    public function logout(Request $request){
        Auth::logout();

        return redirect()->route('login');
    }
}