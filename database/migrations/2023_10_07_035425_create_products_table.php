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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('code')->unique();
            $table->string('type');
            $table->unsignedBigInteger('unit_id');
            $table->foreign('unit_id')->references('id')->on('units');

            $table->double('purchase_price')->default(0.0);
            $table->double('sale_price')->default(0.0);
            $table->integer('alert_quantity')->default(1);
            $table->text('description')->nullable();
            $table->text('image')->nullable();

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
        Schema::dropIfExists('products');
    }
};
