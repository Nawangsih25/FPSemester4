<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('transaksi', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('anggota_id')->nullable();
            $table->enum('user_role', ['anggota', 'kolektor']);
            $table->unsignedBigInteger('user_id');
            $table->string('kode_transaksi')->unique();
            $table->enum('jenis', ['sukarela', 'wajib', 'tagihan', 'pinjaman']);
            $table->string('keterangan')->nullable();
            $table->decimal('jumlah', 12, 2);
            $table->date('tanggal');
            $table->timestamps();

            $table->foreign('anggota_id')->references('id')->on('anggota')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transaksi');
    }
};
