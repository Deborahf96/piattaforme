<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDipendenteTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dipendente', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('nome');
            $table->string('cognome');
            $table->date('data_nascita');
            $table->string('luogo_nascita');
            $table->string('indirizzo');
            $table->integer('telefono');
            $table->string('password');
            $table->string('iban');
            $table->string('ruolo');
            $table->string('tipo_contratto');
            $table->string('stipendio');
            $table->date('data_inizio');
            $table->date('data_fine')->nullable();
            $table->integer('ore_settimanali');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('dipendente');
    }
}
