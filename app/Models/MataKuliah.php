<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MataKuliah extends Model
{
    protected $fillable = [
        'kode_mk',
        'nama_mk',
        'sks',
        'semester',
        'dosen_id',
        'hari', 
        'jam_mulai', 
        'jam_selesai', 
        'ruang', 
        'kuota',
    ];

    public function dosen()
    {
    return $this->belongsTo(Dosen::class);
    }

}