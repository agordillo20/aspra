<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class descripcion extends Model
{
    protected $table = "descripcion";

    public function getProductos()
    {
        $this->hasOne(Producto::class);
    }
}
