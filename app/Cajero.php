<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cajero extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'cajeros';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
    	'codigo','nombres', 'caja_id'
    ];
}
