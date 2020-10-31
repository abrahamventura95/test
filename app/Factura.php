<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Factura extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'facturas';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
    	'metodo','subtotal','iva','cliente_id','cajero_id','franquicia_id','created_at'
    ];
}
