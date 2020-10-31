<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductosFranquiciaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('productos_franquicia', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('producto_id')->unsigned()->index(); 
            $table->bigInteger('franquicia_id')->unsigned()->index(); 
            $table->timestamps();
            $table->foreign('producto_id')
                  ->references('id')->on('productos')
                  ->onUpdate('cascade')
                  ->onDelete('cascade');
            $table->foreign('franquicia_id')
                  ->references('id')->on('franquicias')
                  ->onUpdate('cascade')
                  ->onDelete('cascade');
            $table->unique(['producto_id','franquicia_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('productos_franquicia');
    }
}
