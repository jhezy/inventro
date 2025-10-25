<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCommodityCategoriesTable extends Migration
{
    public function up(): void
    {
        Schema::create('commodity_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name_category');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('commodity_categories');
    }
}
