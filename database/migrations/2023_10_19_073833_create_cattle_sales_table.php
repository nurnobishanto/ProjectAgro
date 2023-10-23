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
        Schema::create('cattle_sales', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->unsignedBigInteger('account_id');
            $table->unsignedBigInteger('party_id');
            $table->unsignedBigInteger('cattle_id');
            $table->double('amount')->default(0);
            $table->enum('status', ['pending', 'success'])->default('pending');
            $table->unsignedBigInteger('created_by');
            $table->unsignedBigInteger('updated_by');

            $table->timestamps();
            $table->softDeletes();

            $table->foreign('account_id')->references('id')->on('accounts');
            $table->foreign('party_id')->references('id')->on('parties');
            $table->foreign('cattle_id')->references('id')->on('cattle');
            $table->foreign('created_by')->references('id')->on('admins');
            $table->foreign('updated_by')->references('id')->on('admins');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cattle_sales');
    }
};
