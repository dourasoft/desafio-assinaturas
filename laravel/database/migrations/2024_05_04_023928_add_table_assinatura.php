<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('assinaturas', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('id_tab_Cadastros');
            $table->foreign('id_tab_Cadastros')->references('id')->on('cadastros');
            $table->string('Descricao')->nullable();
            $table->timestamp('Vencimento')->nullable();
            $table->double('Valor');
            $table->timestamp('created_at');
            $table->timestamp('updated_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('assinaturas');
    }
};
