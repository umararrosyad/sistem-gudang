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
        Schema::create('migrasis', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id'); // Menambahkan kolom untuk foreign key ke tabel users
            $table->string('barang_kode'); // Menambahkan kolom untuk foreign key ke tabel barangs
            $table->date('tanggal');
            $table->unsignedBigInteger('jenis_mutasi_id');
            $table->string('jumlah');
            $table->timestamps();

            // Menambahkan foreign key
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('barang_kode')->references('kode')->on('barangs')->onDelete('cascade');
            $table->foreign('jenis_mutasi_id')->references('id')->on('jenis_mutasis')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
{
    Schema::table('migrasis', function (Blueprint $table) {
        // Drop the foreign key constraints
        $table->dropForeign(['user_id']);
        $table->dropForeign(['barang_kode']);
        $table->dropForeign(['jenis_mutasi_id']);
    });

    // Drop the 'migrasis' table
    Schema::dropIfExists('migrasis');
}
};
