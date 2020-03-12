<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transportista extends Model
{
    protected $fillable = ['razon_social', 'precio', 'duracion'];

    public function getPedidos()
    {
        return $this->hasMany(Pedido::class);
    }
}
