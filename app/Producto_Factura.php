<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Producto_Factura extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'productos_factura';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
    	'cantidad', 'producto_id','factura_id'
    ];
   
}
