<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('simpanan', function (Blueprint $table) {
            // Hapus kolom lama 'jumlah'
            $table->dropColumn('jumlah');

            // Tambahkan kolom baru untuk jenis simpanan
            $table->decimal('total_simpanan_wajib', 12, 2)->nullable()->after('jenis');
            $table->decimal('total_simpanan_sukarela', 12, 2)->nullable()->after('total_simpanan_wajib');
        });
    }

    public function down(): void
    {
        Schema::table('simpanan', function (Blueprint $table) {
            $table->dropColumn(['total_simpanan_wajib', 'total_simpanan_sukarela']);
            $table->decimal('jumlah', 12, 2)->after('jenis');
        });
    }
};
