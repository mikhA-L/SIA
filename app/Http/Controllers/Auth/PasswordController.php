<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class PasswordController extends Controller
{
    public function edit()
    {
        return view('auth.ganti-password');
    }

    public function update(Request $request)
    {
        $request->validate([
            'password_lama' => ['required', 'current_password'],
            'password'      => ['required', 'string', 'min:8', 'confirmed', 'different:password_lama'],
        ], [
            'password_lama.current_password' => 'Kata sandi lama salah.',
            'password.different'             => 'Kata sandi baru harus berbeda dari yang lama.',
        ]);

        $request->user()->update(['password' => Hash::make($request->password)]);

        return back()->with('success', 'Kata sandi berhasil diubah.');
    }
}