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
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->string('name_paket');
            $table->enum('category', ['private', 'intensif'])->default('intensif');
            $table->integer('durasi_bulan')->nullable();
            $table->integer('pertemuan_per_minggu')->nullable();
            $table->integer('durasi_jam');
            $table->integer('jumlah_pertemuan')->nullable();
            $table->decimal('jumlah_total', 10, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('courses');
    }
};
