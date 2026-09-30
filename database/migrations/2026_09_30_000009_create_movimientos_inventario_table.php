<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('movimientos_inventario', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('producto_id');
            $table->unsignedInteger('usuario_id');
            $table->unsignedBigInteger('venta_id')->nullable();
            $table->enum('tipo', [
                'entrada',
                'salida',
                'ajuste',
                'produccion',
                'anulacion'
            ]);
            $table->unsignedInteger('cantidad');
            $table->integer('stock_anterior');
            $table->integer('stock_resultante');
            $table->string('motivo', 255)->nullable();
            $table->dateTime('fecha')->useCurrent();
            $table->timestamps();

            $table->foreign('producto_id')
                ->references('id')
                ->on('productos')
                ->onUpdate('cascade');

            $table->foreign('usuario_id')
                ->references('id')
                ->on('usuarios')
                ->onUpdate('cascade');

            $table->foreign('venta_id')
                ->references('id')
                ->on('ventas')
                ->onUpdate('cascade');

            $table->index('fecha');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('movimientos_inventario');
    }
};
