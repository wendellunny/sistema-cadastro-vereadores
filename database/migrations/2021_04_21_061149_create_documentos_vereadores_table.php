<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDocumentosVereadoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('documentos_vereadores', function (Blueprint $table) {
            $table->foreignId('id_documentos');
            $table->foreignId('id_vereadores');
            $table->foreign('id_documentos')->references('id')->on('documentos')->onDelete('cascade');
            $table->foreign('id_vereadores')->references('id')->on('documentos')->onDelete('cascade');
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
        Schema::dropIfExists('documentos_vereadores');
    }
}
