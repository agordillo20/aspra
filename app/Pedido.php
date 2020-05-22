<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pedido extends Model
{
    protected $fillable = [
        'fecha_pedido', 'total', 'fecha_entrega',
    ];

    public function getDireccion()
    {
        return $this->belongsTo(Direccion::class);
    }

    public function getTransportista()
    {
        return $this->belongsTo(Transportista::class);
    }

    public function getFacturas()
    {
        return $this->hasMany(Lineapedidos::class);
    }
}
