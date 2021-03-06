<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    protected $fillable = ['cod_producto', 'precio_venta', 'precio_compra', 'stock_actual', 'stock_minimo', 'foto'];

    public function getFabricante()
    {
        return $this->belongsTo(Fabricante::class);
    }

    public function getCategorias()
    {
        return $this->belongsToMany(Categoria::class);
    }

    public function getDescripcion()
    {
        return $this->hasOne(descripcion::class);
    }
}
