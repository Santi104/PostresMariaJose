<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('productos', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('categoria_id');
            $table->string('codigo', 30)->unique();
            $table->string('nombre', 120);
            $table->string('descripcion', 255)->nullable();
            $table->decimal('precio_venta', 12, 2)->unsigned();
            $table->decimal('costo_unitario', 12, 2)->unsigned()->default(0);
            $table->integer('stock_actual')->default(0);
            $table->unsignedInteger('stock_minimo')->default(0);
            $table->string('imagen', 255)->nullable();
            $table->boolean('activo')->default(true);
            $table->timestamps();

            $table->foreign('categoria_id')
                ->references('id')
                ->on('categorias')
                ->onUpdate('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('productos');
    }
};
