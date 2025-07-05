<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::dropIfExists('transaksi');
    }

    public function down(): void
    {
        // kosong, karena ini memang untuk drop
    }
};
