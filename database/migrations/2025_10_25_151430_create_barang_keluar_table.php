<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('barang_keluar', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('commodity_id');
            $table->integer('jumlah_keluar');
            $table->date('tanggal_keluar');
            $table->string('keterangan')->nullable();
            $table->timestamps();

            $table->foreign('commodity_id')->references('id')->on('commodities')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('barang_keluar');
    }
};
