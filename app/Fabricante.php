<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Fabricante extends Model
{
    protected $fillable = ['razon_social', 'descripcion', 'origen'];

    public function getProductos()
    {
        return $this->hasMany(Producto::class);
    }
}
