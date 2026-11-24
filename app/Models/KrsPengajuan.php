<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KrsPengajuan extends Model
{
    protected $table = 'krs_pengajuan';
    protected $fillable = ['mahasiswa_id', 'semester', 'status', 'catatan'];

    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class);
    }
}