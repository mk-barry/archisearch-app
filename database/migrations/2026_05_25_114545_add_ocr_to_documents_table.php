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
        Schema::table('documents', function (Blueprint $table) {
            Schema::table('documents', function (Blueprint $table) {

                $table->json('ocr_words')->nullable();

                $table->json('flags')->nullable();

                $table->integer('ocr_score')->nullable();

                $table->float('semantic_score')->nullable();

                $table->float('name_match_score')->nullable();

                $table->boolean('is_valid')->default(false);

                $table->boolean('is_flagged')->default(false);

                $table->boolean('is_expired')->default(false);

                $table->date('expiry_date')->nullable();
            });
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('documents', function (Blueprint $table) {
            //
        });
    }
};
