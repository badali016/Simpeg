<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    // Di dalam App\Http\Controllers\AuthController.php

    public function login(Request $request)
    {
        // 1. Validasi input 'identity' (bukan email saja)
        $request->validate([
            'identity' => 'required|string', // Bisa NIP, Username, atau Email
            'password' => 'required|string',
        ]);

        // 2. Tentukan apakah login pakai Email atau Username/NIP
        // Jika formatnya email, kita anggap email. Jika tidak, kita anggap 'nip' (atau 'username' sesuaikan dengan database kamu)
        $loginType = filter_var($request->input('identity'), FILTER_VALIDATE_EMAIL) ? 'email' : 'nip'; 
        // CATATAN: Ganti 'nip' di atas menjadi 'username' jika di database tabel users kolomnya bernama 'username'.

        // 3. Gabungkan kredensial untuk dicoba login
        $credentials = [
            $loginType => $request->input('identity'),
            'password' => $request->input('password')
        ];

        // 4. Coba Login
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended(route('admin.dashboard'));
        }

        // 5. Jika Gagal
        return back()->withErrors([
            'identity' => 'NIP/Email atau password salah.',
        ])->onlyInput('identity');
    }

    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        Auth::login($user);
        return redirect(route('pegawai.dashboard'))->with('success', 'Registrasi berhasil.');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/')->with('success', 'Logout berhasil.');
    }
}
