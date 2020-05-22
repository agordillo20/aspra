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
            $table->bigInteger('id_descripcion')->unsigned();
            $table->string('cod_producto')->unique();
            $table->string('nombre');
            $table->double('precio_venta');
            $table->double('precio_compra');
            $table->integer('stock_actual');
            $table->integer('stock_minimo');
            $table->string('foto');
            $table->boolean('rebajado');
            $table->dateTime('fecha_fin_rebaja')->nullable(true);
            $table->double('precio_anterior');
            $table->double('valoracion');
            $table->boolean('activo');
            $table->timestamps();
            $table->foreign('id_descripcion')->references('id')->on('descripcion')->cascadeOnDelete();
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
