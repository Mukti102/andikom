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
        Schema::table('jadwals', function (Blueprint $table) {
            // Hapus foreign key lama terlebih dahulu
            // Biasanya formatnya: namaTabel_namaKolom_foreign
            $table->dropForeign(['tutor_id']);

            // Buat foreign key baru ke tabel users
            $table->foreign('tutor_id')->references('id')->on('users')->onDelete('cascade')->change();
        });
    }

    public function down(): void
    {
        Schema::table('jadwals', function (Blueprint $table) {
            $table->dropForeign(['tutor_id']);
            $table->foreign('tutor_id')->references('id')->on('courses')->onDelete('cascade')->change();
        });
    }
};
