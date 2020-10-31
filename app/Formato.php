<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Formato extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'formatos';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
    	'nombre'
    ];
}
