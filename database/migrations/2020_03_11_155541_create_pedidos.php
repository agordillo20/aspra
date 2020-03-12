<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePedidos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pedidos', function (Blueprint $table) {
            $table->id();
            $table->date('fecha_pedido')->nullable(false);
            $table->bigInteger('id_usuario')->unsigned();
            $table->bigInteger('id_direccion')->unsigned();
            $table->bigInteger('id_transportista')->unsigned();
            $table->date('fecha_entrega')->nullable(false);
            $table->foreign('id_usuario')->references('id')->on('users');
            $table->foreign('id_direccion')->references('id')->on('direcciones');
            $table->foreign('id_transportista')->references('id')->on('transportistas');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pedidos');
    }
}
