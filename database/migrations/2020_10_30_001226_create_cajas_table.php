<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCajasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cajas', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('numero');
            $table->boolean('estado')->default(false);//Abierta: true||Cerrada: false
            $table->bigInteger('franquicia_id')->unsigned()->index(); 
            $table->foreign('franquicia_id')
                  ->references('id')->on('franquicias')
                  ->onUpdate('cascade')
                  ->onDelete('cascade');
            $table->timestamps();


            $table->unique(['numero','franquicia_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cajas');
    }
}
