<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAttivitaTable extends Migration
{
    public function up()
    {
        Schema::create('attivita', function (Blueprint $table) {
            $table->id();
            $table->string('ditta_esterna_partita_iva');
            $table->date('data');
            $table->time('ora');
            $table->string('destinazione');
            $table->string('tipologia');
            $table->integer('costo');

            $table->foreign('ditta_esterna_partita_iva')->references('partita_iva')->on('ditta_esterna')->onDelete('cascade');
            $table->unique(['ditta_esterna_partita_iva', 'data', 'ora'], 'ditta_data_ora');
        });
    }

    public function down()
    {
        Schema::dropIfExists('attivita');
    }
}
