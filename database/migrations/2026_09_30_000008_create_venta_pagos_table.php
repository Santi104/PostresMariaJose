<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('venta_pagos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('venta_id');
            $table->unsignedInteger('metodo_pago_id');
            $table->decimal('monto', 12, 2)->unsigned();
            $table->string('referencia', 100)->nullable();
            $table->timestamps();

            $table->foreign('venta_id')
                ->references('id')
                ->on('ventas')
                ->onUpdate('cascade');

            $table->foreign('metodo_pago_id')
                ->references('id')
                ->on('metodos_pago')
                ->onUpdate('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('venta_pagos');
    }
};
