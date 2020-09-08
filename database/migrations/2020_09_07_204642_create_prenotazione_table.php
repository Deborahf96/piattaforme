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
            //$table->string('cliente_user_id')->nullable;
            $table->string('cliente')->nullable;  
            $table->integer('num_persone');
            $table->integer('importo')->nullable(); //messo nullable togliere
            $table->string('metodo_pagamento');
            $table->boolean('check_pernottamento')->nullable(); //messo nullable togliere

            $table->foreign('camera_numero')->references('numero')->on('camera')->onDelete('cascade');
            $table->unique(['camera_numero', 'data_checkin', 'data_checkout'], 'camera_datain_dataout');
            
            //$table->foreign('cliente_user_id')->references('user_id')->on('cliente')->onDelete('set null');
           
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
