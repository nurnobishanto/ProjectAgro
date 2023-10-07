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
        Schema::create('cattle_structures', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('cattle_id');
            $table->foreign('cattle_id')->references('id')->on('cattle');
            $table->date('date');
            $table->text('images')->nullable();
            $table->float('weight')->nullable();
            $table->float('height')->nullable();
            $table->float('width')->nullable();
            $table->string('health')->nullable();
            $table->string('color')->nullable();
            $table->text('foot')->nullable();
            $table->unsignedBigInteger('created_by');
            $table->foreign('created_by')->references('id')->on('admins');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cattle_structures');
    }
};
