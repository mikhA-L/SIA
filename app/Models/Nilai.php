<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Nilai extends Model
{
    protected $table = 'nilai';
    protected $fillable = ['mahasiswa_id', 'mata_kuliah_id', 'semester', 'nilai_angka', 'nilai_huruf'];

    public const BOBOT = ['A' => 4, 'B' => 3, 'C' => 2, 'D' => 1, 'E' => 0];

    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class);
    }

    public function mataKuliah()
    {
        return $this->belongsTo(MataKuliah::class);
    }

    /** Konversi nilai angka (0-100) ke huruf. */
    public static function konversi(float $angka): string
    {
        return match (true) {
            $angka >= 85 => 'A',
            $angka >= 70 => 'B',
            $angka >= 55 => 'C',
            $angka >= 40 => 'D',
            default      => 'E',
        };
    }

    /**
     * Hitung indeks prestasi dari kumpulan nilai (sudah di-load mataKuliah-nya).
     * Dipakai untuk IPS (satu semester) dan IPK (semua semester).
     */
    public static function hitungIndeks($daftar): float
    {
        $totalSks = 0;
        $totalMutu = 0;

        foreach ($daftar as $n) {
            if ($n->nilai_huruf === null) {
                continue;
            }
            $sks = $n->mataKuliah->sks;
            $totalSks  += $sks;
            $totalMutu += self::BOBOT[$n->nilai_huruf] * $sks;
        }

        return $totalSks > 0 ? round($totalMutu / $totalSks, 2) : 0.0;
    }
}