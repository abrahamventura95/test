<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Franquicia extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'franquicias';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
    	'nombre'
    ];
}
