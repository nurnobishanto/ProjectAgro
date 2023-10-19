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
        Schema::create('vaccines', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->date('end_date')->nullable();
            $table->string('time')->nullable();
            $table->unsignedBigInteger('farm_id');
            $table->unsignedBigInteger('cattle_type_id');
            $table->unsignedBigInteger('product_id');
            $table->double('quantity')->default(0.0);
            $table->double('unit_price')->default(0.0);
            $table->double('total_cost')->default(0.0);
            $table->double('avg_cost')->default(0.0);
            $table->text('comment')->nullable();
            $table->enum('status', ['pending', 'success'])->default('pending');
            $table->unsignedBigInteger('created_by');
            $table->unsignedBigInteger('updated_by');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('farm_id')->references('id')->on('farms');
            $table->foreign('cattle_type_id')->references('id')->on('cattle_types');
            $table->foreign('product_id')->references('id')->on('products');
            $table->foreign('created_by')->references('id')->on('admins');
            $table->foreign('updated_by')->references('id')->on('admins');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vaccines');
    }
};
