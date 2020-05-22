<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Lineapedidos extends Model
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
