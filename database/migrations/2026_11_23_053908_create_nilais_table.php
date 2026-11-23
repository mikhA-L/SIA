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
    Schema::create('nilai', function (Blueprint $table) {
        $table->id();
        $table->foreignId('mahasiswa_id')->constrained('mahasiswa')->cascadeOnDelete();
        $table->foreignId('mata_kuliah_id')->constrained('mata_kuliahs')->cascadeOnDelete();
        $table->string('semester', 20);                 // sama dengan KRS, misal 2026/2027 Ganjil
        $table->decimal('nilai_angka', 5, 2)->nullable(); // 0 sampai 100
        $table->string('nilai_huruf', 1)->nullable();     // A, B, C, D, E
        $table->timestamps();

        $table->unique(['mahasiswa_id', 'mata_kuliah_id', 'semester']);
    });
}

public function down(): void
{
    Schema::dropIfExists('nilai');
}
};
