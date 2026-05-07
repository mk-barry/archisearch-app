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
        Schema::table('action_descriptions', function (Blueprint $table) {
            $table->enum('badge', ['info', 'alerte', 'erreur'])->default('info')->after('slug');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('action_descriptions', function (Blueprint $table) {
            //
        });
    }
};
