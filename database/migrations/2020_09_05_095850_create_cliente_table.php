<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClienteTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cliente', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('nome');
            $table->string('cognome');
            $table->date('data_nascita');
            $table->string('luogo_nascita');
            $table->string('indirizzo');
            $table->integer('telefono');
            $table->string('password');
            $table->string('metodo_pagamento')->nullable();
            //$table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cliente');
    }
}
