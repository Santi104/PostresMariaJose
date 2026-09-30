<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('detalle_ventas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('venta_id');
            $table->unsignedInteger('producto_id');
            $table->unsignedInteger('cantidad');
            $table->decimal('precio_unitario', 12, 2)->unsigned();
            $table->decimal('subtotal', 12, 2)->unsigned();
            $table->timestamps();

            $table->foreign('venta_id')
                ->references('id')
                ->on('ventas')
                ->onUpdate('cascade');

            $table->foreign('producto_id')
                ->references('id')
                ->on('productos')
                ->onUpdate('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('detalle_ventas');
    }
};
