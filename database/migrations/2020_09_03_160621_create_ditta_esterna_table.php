<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDittaEsternaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ditta_esterna', function (Blueprint $table) {
            $table->string('partita_iva')->primary();
            $table->string('nome');
            $table->string('indirizzo');
            $table->string('telefono');
            $table->string('email');
            $table->text('descrizione')->nullable();
            $table->string('iban');
            $table->string('categoria');
            $table->string('tipo_contratto');
            $table->string('paga');
            $table->date('data_inizio');
            $table->date('data_fine')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ditta_esterna');
    }
}
