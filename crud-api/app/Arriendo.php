<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Arriendo extends Model
{
    protected $table = 'arriendos';

    protected $fillable = [
        'producto_id', 'cliente_id', 'fentrega', 'ftermino', 'cantidad'
    ];

    public function producto(){
        return $this->belongsTo('App\Producto');
    }

    public function cliente(){
        return $this->belongsTo('App\Cliente');
    }
}
