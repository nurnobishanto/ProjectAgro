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
        Schema::create('cattle', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('session_year_id');
            $table->foreign('session_year_id')->references('id')->on('session_years');
            $table->unsignedBigInteger('farm_id');
            $table->foreign('farm_id')->references('id')->on('farms');
            $table->string('tag_id')->unique();
            $table->date('entry_date')->nullable();
            $table->tinyInteger('is_purchase');
            $table->date('purchase_date')->nullable();
            $table->date('dob');
            $table->string('shade_no')->nullable();
            $table->unsignedBigInteger('batch_id');
            $table->foreign('batch_id')->references('id')->on('batches');
            $table->unsignedBigInteger('cattle_type_id');
            $table->foreign('cattle_type_id')->references('id')->on('cattle_types');
            $table->unsignedBigInteger('breed_id');
            $table->foreign('breed_id')->references('id')->on('breeds');
            $table->text('galley')->nullable();
            $table->string('gender');
            $table->string('category');
            $table->string('status');
            $table->string('problem')->nullable();
            $table->string('death_reason')->nullable();
            $table->date('death_date')->nullable();
            $table->date('sold_date')->nullable();
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->foreign('parent_id')->references('id')->on('cattle');
            $table->date('dairy_date')->nullable();
            $table->date('last_dairy_date')->nullable();
            $table->integer('total_child')->nullable();
            $table->date('pregnant_date')->nullable();
            $table->integer('pregnant_no')->nullable();
            $table->date('delivery_date')->nullable();
            $table->unsignedBigInteger('created_by');
            $table->foreign('created_by')->references('id')->on('admins');
            $table->unsignedBigInteger('updated_by');
            $table->foreign('updated_by')->references('id')->on('admins');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cattle');
    }
};
