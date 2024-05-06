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
        Schema::table('faturas', function (Blueprint $table) {
            //deleta fatura caso assinatura seja deletada
            $table->foreignId('assinatura_id')->constrained()->onDelete('cascade');
            
        });

        Schema::table('assinaturas', function (Blueprint $table) {
            //deleta assinatura caso usuario seja deletado
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('faturas', function (Blueprint $table) {
            
        });
    }
};
