<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    protected $table = 'productos';
    protected $fillable = [
        'marca', 'modelo', 'categoria'
    ];

    public function arriendo(){
        return $this->hasMany('App\Arriendo');
    }

}
