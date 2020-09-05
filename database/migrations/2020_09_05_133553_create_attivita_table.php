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
            $table->string('ditta_esterna');
            $table->date('data');
            $table->time('ora');
            $table->integer('max_persone');
            $table->string('destinazione');
            $table->string('tipologia');
        });
    }

    public function down()
    {
        Schema::dropIfExists('attivita');
    }
}
