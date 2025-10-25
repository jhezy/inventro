<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('peminjaman_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('peminjaman_id');
            $table->unsignedBigInteger('commodity_id');
            $table->integer('jumlah');
            $table->boolean('dikembalikan')->default(false);
            $table->date('tanggal_pengembalian')->nullable();
            $table->timestamps();

            // $table->foreign('peminjaman_id')->references('id')->on('peminjaman')->onDelete('cascade');
            // $table->foreign('commodity_id')->references('id')->on('commodities')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('peminjaman_items');
    }
};
