<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'username',
        'email',
        'password',
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /** Halaman awal sesuai peran setelah login. */
    public function homePath(): string
    {
        return match ($this->role) {
            'admin' => '/admin',
            'dosen' => '/dosen',
            default => '/mahasiswa',
        };
    }

    public function roleLabel(): string
    {
        return match ($this->role) {
            'admin' => 'Admin prodi',
            'dosen' => 'Dosen',
            default => 'Mahasiswa',
        };
    }
}
