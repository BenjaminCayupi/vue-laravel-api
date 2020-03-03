<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    protected $table = 'clientes';
    protected $fillable = [
        'nombre', 'email', 'telefono', 'direccion'
    ];
    public function arriendo(){
        return $this->hasMany('App\Arriendo');
    }

   
}
