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
        Schema::create('feeding_category_cattle', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('feeding_category_id');
            $table->unsignedBigInteger('cattle_id');
            // Add other columns as needed for the relationship

            $table->timestamps();

            // Define foreign key constraints
            $table->foreign('feeding_category_id')->references('id')->on('feeding_categories')->onDelete('cascade');
            $table->foreign('cattle_id')->references('id')->on('cattle')->onDelete('cascade');

            // Add unique constraint to avoid duplicates
            $table->unique(['feeding_category_id', 'cattle_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('feeding_category_cattle');
    }
};
