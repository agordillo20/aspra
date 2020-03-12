<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    protected $fillable = ['cod_producto', 'predio_venta', 'predio_compra', 'stock_actual', 'stock_minimo', 'descripcion', 'foto'];

    public function getFabricante()
    {
        return $this->belongsTo(Fabricante::class);
    }

    public function getCategorias()
    {
        return $this->belongsToMany(Categoria::class);
    }
}