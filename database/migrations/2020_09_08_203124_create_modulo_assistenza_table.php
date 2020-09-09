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
            $table->string('tipologia');
            $table->string('oggetto');
            $table->text('messaggio');
            $table->timestamps();
            
            $table->foreign('cliente_user_id')->references('user_id')->on('cliente')->onDelete('cascade');
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
