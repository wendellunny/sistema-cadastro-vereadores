<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReunioesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reunioes', function (Blueprint $table) {
            $table->id();
            $table->string('tipo',15);
            $table->foreignId('arquivo_pauta');
            $table->foreignId('arquivo_ata');
            $table->foreign('arquivo_pauta')->references('id')->on('arquivos')->onDelete('cascade');
            $table->foreign('arquivo_ata')->references('id')->on('arquivos')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('reunioes');
    }
}
