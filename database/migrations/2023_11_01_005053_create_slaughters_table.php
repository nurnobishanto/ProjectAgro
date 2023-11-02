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
        Schema::create('slaughters', function (Blueprint $table) {
            $table->id();
            $table->string('unique_id');
            $table->date('date');
            $table->unsignedBigInteger('cattle_id');
            $table->unsignedBigInteger('farm_id');
            $table->unsignedBigInteger('slaughter_store_id');
            $table->text('note')->nullable();
            $table->enum('status', ['pending', 'success'])->default('pending');
            $table->unsignedBigInteger('created_by');
            $table->unsignedBigInteger('updated_by');
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('cattle_id')->references('id')->on('cattle');
            $table->foreign('farm_id')->references('id')->on('farms');
            $table->foreign('slaughter_store_id')->references('id')->on('slaughter_stores');
            $table->foreign('created_by')->references('id')->on('admins');
            $table->foreign('updated_by')->references('id')->on('admins');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('slaughters');
    }
};
