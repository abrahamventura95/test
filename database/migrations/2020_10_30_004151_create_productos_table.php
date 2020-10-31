<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('productos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nombre',128);
            $table->string('descripcion',128);
            $table->float('monto_unitario');
            $table->bigInteger('formato_id')->unsigned()->index(); 
            $table->enum('categoria',['limpieza','comestible','decoracion']);
            $table->date('vida_util');
            $table->timestamps();

            $table->foreign('formato_id')
                  ->references('id')->on('formatos')
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
        Schema::dropIfExists('productos');
    }
}
