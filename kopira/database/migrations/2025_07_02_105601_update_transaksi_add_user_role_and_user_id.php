<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateTransaksiAddUserRoleAndUserId extends Migration
{
    public function up()
    {
        Schema::table('transaksi', function (Blueprint $table) {
            $table->enum('user_role', ['anggota', 'kolektor'])->after('anggota_id');
            $table->unsignedBigInteger('user_id')->after('user_role');
        });
    }

    public function down()
    {
        Schema::table('transaksi', function (Blueprint $table) {
            $table->dropColumn('user_role');
            $table->dropColumn('user_id');
        });
    }
}

