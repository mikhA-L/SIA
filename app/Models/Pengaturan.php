<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pengaturan extends Model
{
    protected $table = 'pengaturan';
    protected $primaryKey = 'kunci';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = ['kunci', 'nilai'];

    public static function nilaiDibuka(): bool
    {
        return optional(static::find('nilai_dibuka'))->nilai === '1';
    }

    public static function setNilaiDibuka(bool $buka): void
    {
        static::updateOrCreate(['kunci' => 'nilai_dibuka'], ['nilai' => $buka ? '1' : '0']);
    }
}