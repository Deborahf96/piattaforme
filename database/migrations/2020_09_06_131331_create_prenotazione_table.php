<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePrenotazioneTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('prenotazione', function (Blueprint $table) {
            $table->id();
            $table->integer('camera_numero');
            $table->date('data_checkin');
            $table->date('data_checkout');
            $table->string('cliente_email');   //modifica il nome inserendo la chiave di cliente
            $table->integer('num_persone');
            $table->integer('importo');
            $table->string('metodo_pagamento');
            $table->boolean('check_pernottamento');

            $table->foreign('camera_numero')->references('numero')->on('camera')->onDelete('cascade');
            $table->unique(['camera_numero', 'data_checkin', 'data_checkout'], 'camera_datain_dataout');
            
            $table->foreign('cliente_email')->references('email')->on('cliente')->onDelete('cascade');
           //valutare se mettere cascade oppure set_null
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('prenotazione');
    }
}
