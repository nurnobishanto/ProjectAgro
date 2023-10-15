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
        Schema::create('feeding_records', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->unsignedBigInteger('feeding_group_id');
            $table->double('per_cattle_cost')->default(0.0);
            $table->double('total_cost')->default(0.0);
            $table->text('comment')->nullable();
            $table->enum('status', ['pending', 'success'])->default('pending');
            $table->unsignedBigInteger('created_by');
            $table->unsignedBigInteger('updated_by');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('feeding_group_id')->references('id')->on('feeding_groups');
            $table->foreign('created_by')->references('id')->on('admins');
            $table->foreign('updated_by')->references('id')->on('admins');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('feeding_records');
    }
};
