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
            
           $table->string('camera');
           $table->date('data_checkin');
           $table->date('data_checkout');
           $table->string('cliente');
           $table->integer('num_persone');
           $table->integer('importo');
           $table->string('metodo_pagamento');
           $table->boolean('check_pernottamento');

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
