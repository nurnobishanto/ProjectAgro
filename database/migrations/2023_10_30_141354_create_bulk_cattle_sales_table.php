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
        Schema::create('bulk_cattle_sales', function (Blueprint $table) {
            $table->id();
            $table->string('unique_id');
            $table->date('date');
            $table->unsignedBigInteger('account_id');
            $table->unsignedBigInteger('party_id');
            $table->unsignedBigInteger('farm_id');
            $table->unsignedBigInteger('cattle_type_id');
            $table->double('amount')->default(0);
            $table->double('paid')->default(0);
            $table->double('due')->default(0);
            $table->double('expense')->default(0);
            $table->text('note')->nullable();
            $table->enum('status', ['pending', 'success'])->default('pending');
            $table->unsignedBigInteger('created_by');
            $table->unsignedBigInteger('updated_by');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('account_id')->references('id')->on('accounts');
            $table->foreign('party_id')->references('id')->on('parties');
            $table->foreign('farm_id')->references('id')->on('farms');
            $table->foreign('cattle_type_id')->references('id')->on('cattle_types');
            $table->foreign('created_by')->references('id')->on('admins');
            $table->foreign('updated_by')->references('id')->on('admins');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bulk_cattle_sales');
    }
};
