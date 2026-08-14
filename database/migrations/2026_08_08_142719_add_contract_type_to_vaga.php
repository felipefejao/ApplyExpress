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
        Schema::table('vagas', function (Blueprint $table) {
            $table->boolean('accept_pj')->default(false);
            $table->boolean('accept_clt')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('vagas', function (Blueprint $table) {
            $table->dropColumn('accept_pj');
            $table->dropColumn('accept_clt');
        });
    }
};
