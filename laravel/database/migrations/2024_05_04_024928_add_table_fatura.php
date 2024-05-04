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
        Schema::create('faturas', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('id_tab_Cadastros');
            $table->unsignedInteger('id_tab_Assinaturas');
            $table->tinyInteger('status_pago')->default(0);
            $table->string('descricao')->nullable();
            $table->timestamp('vencimento')->nullable();
            $table->double('valor', 8, 2);
            $table->timestamp('created_at');
            $table->timestamp('updated_at')->useCurrent();

            // Foreign key constraints
            $table->foreign('id_tab_Cadastros')->references('id')->on('cadastros');
            $table->foreign('id_tab_Assinaturas')->references('id')->on('assinaturas');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('faturas');
    }
};
