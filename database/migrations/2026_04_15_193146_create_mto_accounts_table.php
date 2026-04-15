<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('mto_accounts', function (Blueprint $table) {
            $table->id();
            $table->string('client_id');
            $table->string('identifier')->unique();
            $table->enum('identifier_type', ['MSISDN', 'BANK']);
            $table->string('fsp_id');
            $table->string('destination_fsp')->nullable();
            $table->string('full_name');
            $table->enum('account_category', ['PERSON', 'BUSINESS']);
            $table->enum('account_type', ['WALLET', 'BANK']);
            $table->string('identity_type'); // NIN or TIN
            $table->string('identity_value');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('mto_accounts');
    }
};
