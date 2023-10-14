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
        Schema::create('feeding_record_cattle', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('feeding_record_id');
            $table->unsignedBigInteger('cattle_id');
            $table->timestamps();

            $table->foreign('feeding_record_id')->references('id')->on('feeding_records');
            $table->foreign('cattle_id')->references('id')->on('cattle');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('feeding_record_cattle');
    }
};
