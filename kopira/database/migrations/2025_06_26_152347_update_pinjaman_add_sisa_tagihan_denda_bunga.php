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
        Schema::table('pinjaman', function (Blueprint $table) {
            $table->decimal('sisa_tagihan', 12, 2)->after('nominal')->nullable();
            $table->decimal('denda', 12, 2)->after('sisa_tagihan')->nullable()->default(0);
            $table->decimal('bunga', 12, 2)->after('denda')->nullable();

            $table->enum('status', ['pending', 'sudah bayar', 'belum bayar', 'ditolak', 'lunas'])->default('pending')->change();
        });
    }

    public function down(): void
    {
        Schema::table('pinjaman', function (Blueprint $table) {
            $table->dropColumn(['sisa_tagihan', 'denda', 'bunga']);
            $table->enum('status', ['pending', 'aktif', 'ditolak', 'lunas'])->change(); // optional rollback
        });
    }

};
