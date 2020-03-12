<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('productos', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('id_categoria')->unsigned();
            $table->bigInteger('id_fabricante')->unsigned();
            $table->string('cod_producto');
            $table->double('predio_venta');
            $table->double('predio_compra');
            $table->integer('stock_actual');
            $table->integer('stock_minimo');
            $table->string('descripcion');
            $table->string('foto');
            $table->timestamps();
            $table->foreign('id_fabricante')->references('id')->on('fabricantes');
            $table->foreign('id_categoria')->references('id')->on('categorias');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('productos');
    }
}
