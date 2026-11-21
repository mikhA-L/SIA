<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Mahasiswa;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $data = $request->validate([
            'nim'      => ['required', 'string', 'max:20'],
            'email'    => ['required', 'email', 'max:100', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $mhs = Mahasiswa::where('nim', $data['nim'])->first();

        if (! $mhs) {
            return back()->withErrors(['nim' => 'NIM belum terdaftar. Hubungi admin.'])->withInput();
        }
        if ($mhs->user_id) {
            return back()->withErrors(['nim' => 'NIM ini sudah punya akun. Silakan login.'])->withInput();
        }

        $user = DB::transaction(function () use ($data, $mhs) {
            $user = User::create([
                'name'     => $mhs->nama,
                'username' => $mhs->nim,
                'email'    => $data['email'],
                'password' => Hash::make($data['password']),
                'role'     => 'mahasiswa',
            ]);
            $mhs->update(['user_id' => $user->id]);
            return $user;
        });

        Auth::login($user);
        $request->session()->regenerate();

        return redirect($user->homePath());
    }
}