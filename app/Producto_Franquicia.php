<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Producto_Franquicia extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'productos_franquicia';
    /**
     * Get the producto record associated with the productoXfactura.
     */
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'producto_id','franquicia_id'
    ];
}
