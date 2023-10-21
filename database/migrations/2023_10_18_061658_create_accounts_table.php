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
        Schema::create('accounts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('admin_id');
            $table->string('bank_name');
            $table->string('account_name');
            $table->string('account_no');
            $table->string('account_type');
            $table->double('previous_balance')->default(0);
            $table->double('current_balance')->default(0);
            $table->enum('status', ['pending', 'active'])->default('pending');
            $table->unsignedBigInteger('created_by');
            $table->unsignedBigInteger('updated_by');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('admin_id')->references('id')->on('admins');
            $table->foreign('created_by')->references('id')->on('admins');
            $table->foreign('updated_by')->references('id')->on('admins');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('accounts');
    }
};
