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
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('cadastre_id')->nullable();
            $table->foreign('cadastre_id')->references('id')->on('cadastres');

            $table->unsignedBigInteger('signature_id')->nullable();
            $table->foreign('signature_id')->references('id')->on('signatures');

            $table->string('describe', 250);
            $table->date('expiration');
            $table->decimal('value', 10, 2);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
