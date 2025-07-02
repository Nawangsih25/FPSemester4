<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('anggota', function (Blueprint $table) {
            $table->string('pekerjaan')->nullable()->after('alamat');
            $table->string('no_rekening')->unique()->after('pekerjaan');
        });
    }

    public function down(): void
    {
        Schema::table('anggota', function (Blueprint $table) {
            $table->dropColumn(['pekerjaan', 'no_rekening']);
        });
    }
};

