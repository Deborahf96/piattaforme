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
            $table->bigInteger('camera_id')->unsigned();
            $table->date('data_checkin');
            $table->date('data_checkout');
            $table->bigInteger('cliente_user_id')->unsigned()->nullable();
            $table->integer('num_persone');
            $table->integer('importo');
            $table->string('metodo_pagamento');
            $table->string('check_pernottamento'); 
            $table->tinyInteger('conferma_pagamento')->default(0);

            $table->foreign('camera_id')->references('id')->on('camera')->onDelete('cascade');
            $table->foreign('cliente_user_id')->references('user_id')->on('cliente')->onDelete('set null');
            $table->unique(['camera_id', 'data_checkin', 'data_checkout'], 'camera_datain_dataout');
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
