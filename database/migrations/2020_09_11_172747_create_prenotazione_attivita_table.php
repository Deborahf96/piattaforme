<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePrenotazioneAttivitaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('prenotazione_attivita', function (Blueprint $table) {
            $table->bigInteger('prenotazione_id')->unsigned()->index();
            $table->bigInteger('attivita_id')->unsigned()->index();
            $table->primary(['prenotazione_id', 'attivita_id'], 'prenotazione_attivita_id');

            $table->foreign('prenotazione_id')->references('id')->on('prenotazione')->onDelete('cascade');
            $table->foreign('attivita_id')->references('id')->on('attivita')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('prenotazione_attivita');
    }
}
