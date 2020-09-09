<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateModuloAssistenzaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('modulo_assistenza', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('cliente_user_id')->unsigned();
            $table->date('data');
            $table->time('ora');
            $table->string('tipologia');
            $table->text('messaggio');
            
            $table->foreign('cliente_user_id')->references('user_id')->on('cliente')->onDelete('set null');
            $table->unique(['cliente_user_id', 'data', 'ora'], 'cliente_data_ora');
        
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('modulo_assistenza');
    }
}
