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
        Schema::table('users', function (Blueprint $table) {
            $table->text('application_text')->nullable();
            $table->text('cover_letter')->nullable();
            $table->foreignId('default_curriculo_id')->nullable()->constrained('curriculos')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['default_curriculo_id']);
            $table->dropColumn(['application_text', 'cover_letter', 'default_curriculo_id']);
        });
    }
};
