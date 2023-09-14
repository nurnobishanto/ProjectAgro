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
        Schema::create('cattle_types', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->enum('status', ['active', 'deactivate'])->default('active');

            $table->unsignedBigInteger('created_by');
            $table->foreign('created_by')->references('id')->on('admins');

            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cattle_types');
    }
};
