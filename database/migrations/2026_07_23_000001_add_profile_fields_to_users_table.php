<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('linkedin')->nullable();
            $table->string('github')->nullable();
            $table->string('phone')->nullable();
            $table->text('bio')->nullable();
            $table->string('locale')->default('pt_BR');
            $table->boolean('is_admin')->default(false);
            $table->integer('credits')->default(0);
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['linkedin', 'github', 'phone', 'bio', 'locale', 'is_admin', 'credits']);
        });
    }
};
