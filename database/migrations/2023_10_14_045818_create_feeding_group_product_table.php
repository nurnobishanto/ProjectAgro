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
        Schema::create('feeding_group_product', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('feeding_group_id');
            $table->unsignedBigInteger('product_id');
            $table->timestamps();

            $table->foreign('feeding_group_id')->references('id')->on('feeding_groups');
            $table->foreign('product_id')->references('id')->on('products');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('feeding_group_product');
    }
};
