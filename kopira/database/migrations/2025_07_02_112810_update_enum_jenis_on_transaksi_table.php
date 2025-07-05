<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class UpdateEnumJenisOnTransaksiTable extends Migration
{
    public function up()
    {
        DB::statement("ALTER TABLE transaksi MODIFY jenis ENUM('sukarela', 'wajib', 'tagihan', 'pinjaman') NOT NULL");
    }

    public function down()
    {
        DB::statement("ALTER TABLE transaksi MODIFY jenis ENUM('simpanan','pinjaman','pembayaran','denda') NOT NULL");
    }
}

