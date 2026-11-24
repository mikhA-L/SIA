<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('mata_kuliahs', function (Blueprint $table) {
            $table->string('hari', 10)->nullable()->after('sks');
            $table->time('jam_mulai')->nullable()->after('hari');
            $table->time('jam_selesai')->nullable()->after('jam_mulai');
            $table->string('ruang', 30)->nullable()->after('jam_selesai');
            $table->unsignedInteger('kuota')->default(40)->after('ruang');
        });

        Schema::create('pengaturan', function (Blueprint $table) {
            $table->string('kunci', 50)->primary();
            $table->string('nilai', 100)->nullable();
            $table->timestamps();
        });

        DB::table('pengaturan')->insert([
            'kunci' => 'nilai_dibuka', 'nilai' => '1',
            'created_at' => now(), 'updated_at' => now(),
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengaturan');
        Schema::table('mata_kuliahs', function (Blueprint $table) {
            $table->dropColumn(['hari', 'jam_mulai', 'jam_selesai', 'ruang', 'kuota']);
        });
    }
};
