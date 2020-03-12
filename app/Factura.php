<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Factura extends Model
{
    public function getProducto()
    {
        return $this->belongsTo(Producto::class);
    }

    public function getPedido()
    {
        return $this->belongsTo(Pedido::class);
    }
}
