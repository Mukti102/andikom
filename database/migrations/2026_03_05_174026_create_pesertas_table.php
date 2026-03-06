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
        Schema::create('peserta', function (Blueprint $blueprint) {
            $blueprint->id();
            // Relasi ke tabel users (Satu Peserta memiliki satu User)
            $blueprint->foreignId('user_id')->constrained('users')->onDelete('cascade');

            $blueprint->string('nis')->unique(); // Nomor Induk Siswa
            $blueprint->string('nama_lengkap');
            $blueprint->string('nama_panggilan')->nullable();
            $blueprint->string('tempat_lahir');
            $blueprint->date('tanggal_lahir');
            $blueprint->enum('jenis_kelamin', ['L', 'P']);
            $blueprint->string('agama');
            $blueprint->text('alamat_sekarang');
            $blueprint->string('pekerjaan')->nullable();
            $blueprint->string('no_hp');
            $blueprint->string('asal_sekolah')->nullable();

            // Data Keluarga
            $blueprint->string('nama_ayah');
            $blueprint->string('nama_ibu');
            $blueprint->string('hp_orang_tua');
            $blueprint->string('status_tempat_tinggal'); // Ikut ortu, saudara, kost

            $blueprint->boolean('status_aktif')->default(true);
            $blueprint->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pesertas');
    }
};
