<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('plans', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->string('price');
            $table->string('currency', 3)->default('BRL');
            $table->string('interval')->default('month'); // month, year, lifetime
            $table->integer('credits_included')->default(0);
            $table->boolean('is_active')->default(true);
            $table->json('features')->nullable();
            $table->string('gateway_id')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('plans');
    }
};
