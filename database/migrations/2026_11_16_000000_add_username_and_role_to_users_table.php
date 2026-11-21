<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // NIM (mahasiswa), NIP/NIDN (dosen), atau username (admin)
            $table->string('username')->nullable()->unique()->after('name');
            // admin | dosen | mahasiswa
            $table->string('role', 20)->default('mahasiswa')->after('password');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropUnique(['username']);
            $table->dropColumn(['username', 'role']);
        });
    }
};
