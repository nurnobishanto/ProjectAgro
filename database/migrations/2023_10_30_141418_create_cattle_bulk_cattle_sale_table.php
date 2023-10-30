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
        Schema::create('cattle_bulk_cattle_sale', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('cattle_id');
            $table->unsignedBigInteger('bulk_cattle_sale_id');
            $table->timestamps();

            $table->foreign('cattle_id')->references('id')->on('cattle');
            $table->foreign('bulk_cattle_sale_id')->references('id')->on('bulk_cattle_sales');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cattle_bulk_cattle_sale');
    }
};
