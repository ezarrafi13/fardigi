<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    public function login()
    {
        if (Auth::check()) {
            return redirect()->route('catalog.index');
        }
        return view('auth.login');
    }

    public function authenticate(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        $user = User::where('username', $request->username)->first();

        if ($user && Hash::check($request->password, $user->password)) {
            Auth::login($user);
            $request->session()->regenerate();

            // Restore cart dari database jika ada
            if ($user->cart_data) {
                $cartKey = 'cart_user_' . $user->id;
                $parsed  = json_decode($user->cart_data, true);
                if (is_array($parsed)) {
                    session([$cartKey => $parsed]);
                }
            }

            return redirect()->intended(route('catalog.index'))
                ->with('success', 'Selamat datang kembali, ' . $user->fullname . '!');
        }

        return back()->withErrors([
            'username' => 'Username atau Password salah!',
        ])->withInput($request->only('username'));
    }

    public function logout(Request $request)
    {
        $user = Auth::user();

        // Simpan cart ke database sebelum logout
        if ($user) {
            $cartKey   = 'cart_user_' . $user->id;
            $cartData  = session($cartKey, []);
            $user->cart_data = !empty($cartData) ? json_encode($cartData) : null;
            $user->save();
            session()->forget($cartKey);
        }

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('catalog.index');
    }

    public function registerForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'username' => 'required|string|max:50|unique:users,username',
            'password' => 'required|string|min:6',
            'fullname' => 'required|string|max:100',
            'email'    => 'required|email|unique:users,email',
            'phone'    => 'required|string|max:20',
            'address'  => 'nullable|string',
            'city'     => 'nullable|string|max:100',
            'zip'      => 'nullable|string|max:20',
        ]);

        $user = User::create([
            'name'      => $request->fullname,
            'username'  => $request->username,
            'fullname'  => $request->fullname,
            'email'     => $request->email,
            'password'  => Hash::make($request->password),
            'phone'     => $request->phone,
            'address'   => $request->address,
            'city'      => $request->city,
            'zip'       => $request->zip,
            'user_type' => 'user',
            'is_admin'  => 0,
        ]);

        Auth::login($user);

        return redirect()->route('catalog.index')
            ->with('success', 'Akun berhasil dibuat! Selamat datang, ' . $user->fullname . '!');
    }
}
