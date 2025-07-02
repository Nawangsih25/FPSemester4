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
        Schema::table('pinjaman', function (Blueprint $table) {
            $table->decimal('tagihan_hari_ini', 12, 2)->nullable()->after('sisa_tagihan');
        });
    }

    public function down()
    {
        Schema::table('pinjaman', function (Blueprint $table) {
            $table->dropColumn('tagihan_hari_ini');
        });
    }

};
