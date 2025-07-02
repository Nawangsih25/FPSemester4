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
        Schema::create('transaksi', function (Blueprint $table) {
            $table->id();
            $table->foreignId('anggota_id')->nullable()->constrained('anggota')->onDelete('cascade');
            $table->string('kode_transaksi')->unique();
            $table->enum('jenis', ['simpanan', 'pinjaman', 'pembayaran', 'denda']);
            $table->string('keterangan')->nullable();
            $table->decimal('jumlah', 12, 2);
            $table->date('tanggal');
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaksi');
    }
};
