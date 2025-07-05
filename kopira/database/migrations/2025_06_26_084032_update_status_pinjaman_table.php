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
            Schema::table('pinjaman', function (Blueprint $table) 
            {
                $table->enum('status', ['pending', 'aktif', 'ditolak', 'lunas'])->default('pending')->change(); // update dari 'aktif'
                $table->integer('lama_angsuran')->nullable()->change(); // biar bisa kosong dulu
                $table->string('alasan_penolakan')->nullable()->after('lama_angsuran');
                $table->date('tanggal_respon')->nullable()->after('alasan_penolakan');
            });

        }

        /**
         * Reverse the migrations.
         */
        public function down(): void
        {
            //
        }
    };
