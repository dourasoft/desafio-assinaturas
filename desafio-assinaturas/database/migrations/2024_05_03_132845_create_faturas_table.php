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
        Schema::create('faturas', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('cadastro_id');
            $table->foreign('cadastro_id')->references('id')->on('cadastros')->onUpdate('cascade');

            $table->unsignedBigInteger('assinatura_id');
            $table->foreign('assinatura_id')->references('id')->on('assinaturas')->onUpdate('cascade');

            $table->string('descricao');
            $table->float('valor');
            $table->date("data_vencimento")->index();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('faturas');
    }
};
