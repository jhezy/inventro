<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('rabs', function (Blueprint $table) {
            $table->id();
            $table->year('tahun');
            $table->string('bulan');
            $table->string('nama_barang');
            $table->integer('jumlah');
            $table->decimal('harga', 15, 2);
            $table->decimal('total', 15, 2)->virtualAs('jumlah * harga');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('rabs');
    }
};
