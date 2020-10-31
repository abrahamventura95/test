<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductosFacturaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('productos_factura', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('producto_id')->unsigned()->index(); 
            $table->bigInteger('factura_id')->unsigned()->index(); 
            $table->foreign('producto_id')
                  ->references('id')->on('productos')
                  ->onUpdate('cascade')
                  ->onDelete('restrict');
            $table->foreign('factura_id')
                  ->references('id')->on('facturas')
                  ->onUpdate('cascade')
                  ->onDelete('cascade');
            $table->integer('cantidad');      
            $table->timestamps();
            $table->unique(['producto_id','factura_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('productos_factura');
    }
}
