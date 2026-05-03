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
        // Create a table to store test NINs and their verification data
        Schema::create('nida_test_accounts', function (Blueprint $table) {
            $table->id();
            $table->string('nin', 20)->unique(); // 20-digit NIN
            $table->string('full_name');
            $table->string('date_of_birth'); // YYYY-MM-DD
            $table->string('mother_name'); // Verification question answer
            $table->string('birth_place'); // Alternative verification
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('nida_test_accounts');
    }
};
