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
        Schema::create('company_pages', function (Blueprint $table) {
            $table->id();
            $table->string('shortname', 50)->nullable();
            $table->string('companyname', 50)->nullable();
            $table->string('cnpj', 50)->nullable();
            $table->string('logo', 100)->nullable();
            $table->string('street', 50)->nullable();
            $table->string('district', 50)->nullable();
            $table->string('uf', 50)->nullable();
            $table->string('city', 50)->nullable();
            $table->string('cep', 50)->nullable();
            $table->string('phone', 50)->nullable();
            $table->string('site', 50)->nullable();
            $table->string('email', 50)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('company_pages');
    }
};
