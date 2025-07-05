<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('pembayaran', function (Blueprint $table) {

            $table->date('tanggal_pembayaran')->after('pinjaman_id');
            $table->integer('jumlah_pembayaran')->after('tanggal_pembayaran');
            $table->string('bukti_pembayaran')->nullable()->after('jumlah_pembayaran');
            $table->enum('status_verifikasi', ['pending', 'diterima', 'ditolak'])->default('pending')->after('bukti_pembayaran');
            $table->text('catatan_admin')->nullable()->after('status_verifikasi');
        });
    }



    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('pembayaran', function (Blueprint $table) {
            $table->dropColumn([
                'tanggal_pembayaran',
                'jumlah_pembayaran',
                'bukti_pembayaran',
                'status_verifikasi',
                'catatan_admin',
            ]);
        });
    }
};
