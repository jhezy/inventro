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
        Schema::table('commodities', function (Blueprint $table) {
            $table->string('nomor_seri')->nullable();
            $table->string('ukuran')->nullable();
            $table->string('warna')->nullable();

            $table->string('pengguna')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('commodities', function (Blueprint $table) {
            $table->dropColumn([
                'nomor_seri',
                'ukuran',
                'warna',

                'pengguna',
            ]);
        });
    }
};
