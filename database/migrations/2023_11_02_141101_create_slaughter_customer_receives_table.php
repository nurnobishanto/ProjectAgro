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
        Schema::create('slaughter_customer_receives', function (Blueprint $table) {
            $table->id();
            $table->string('unique_id');
            $table->date('date');
            $table->unsignedBigInteger('account_id');
            $table->unsignedBigInteger('slaughter_customer_id');
            $table->double('amount')->default(0);
            $table->text('note')->nullable();
            $table->enum('status', ['pending', 'success'])->default('pending');
            $table->enum('type', ['receive', 'return'])->default('receive');
            $table->unsignedBigInteger('created_by');
            $table->unsignedBigInteger('updated_by');
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('account_id')->references('id')->on('accounts');
            $table->foreign('slaughter_customer_id')->references('id')->on('slaughter_customers');
            $table->foreign('created_by')->references('id')->on('admins');
            $table->foreign('updated_by')->references('id')->on('admins');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('slaughter_customer_payments');
    }
};
