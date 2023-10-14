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
        Schema::create('feeding_groups', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('farm_id');
            $table->unsignedBigInteger('cattle_type_id');
            $table->unsignedBigInteger('feeding_category_id');
            $table->unsignedBigInteger('feeding_moment_id');
            $table->enum('status', ['active', 'deactivate'])->default('active');
            $table->unsignedBigInteger('created_by');
            $table->unsignedBigInteger('updated_by');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('created_by')->references('id')->on('admins');
            $table->foreign('updated_by')->references('id')->on('admins');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('feeding_groups');
    }
};
