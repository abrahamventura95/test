<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFacturasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('facturas', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('cliente_id')->unsigned()->index(); 
            $table->bigInteger('cajero_id')->unsigned()->index(); 
            $table->bigInteger('franquicia_id')->unsigned()->index(); 
            $table->enum('metodo',['debito','credito','efectivo']);
            $table->float('subtotal');
            $table->integer('iva');
            $table->timestamps();
            $table->foreign('cliente_id')
                  ->references('id')->on('clientes')
                  ->onUpdate('cascade')
                  ->onDelete('restrict');
            $table->foreign('cajero_id')
                  ->references('id')->on('cajeros')
                  ->onUpdate('cascade')
                  ->onDelete('restrict');
            $table->foreign('franquicia_id')
                  ->references('id')->on('franquicias')
                  ->onUpdate('cascade')
                  ->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('facturas');
    }
}
