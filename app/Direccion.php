<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Direccion extends Model
{
    protected $fillable = ['domicilio', 'localidad', 'provincia', 'cod_postal', 'pais'];
    protected $table = 'direcciones';

    public function usuario()
    {
        return $this->hasOne(User::class);
    }

    public function getPedidos()
    {
        return $this->hasMany(Pedido::class);
    }
}
