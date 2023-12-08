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
        Schema::table('slaughters', function (Blueprint $table) {
            $table->double('feeding_expense')->default(0);
            $table->double('other_expense')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('slaughters', function (Blueprint $table) {
            $table->dropColumn('feeding_expense');
            $table->dropColumn('other_expense');
        });
    }
};
