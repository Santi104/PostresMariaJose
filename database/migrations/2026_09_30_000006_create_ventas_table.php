<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ventas', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('turno_caja_id');
            $table->unsignedInteger('usuario_id');
            $table->string('numero', 20)->unique();
            $table->dateTime('fecha')->useCurrent();
            $table->decimal('subtotal', 12, 2)->unsigned();
            $table->decimal('descuento', 12, 2)->unsigned()->default(0);
            $table->decimal('total', 12, 2)->unsigned();
            $table->enum('estado', ['completada', 'anulada'])->default('completada');
            $table->string('motivo_anulacion', 255)->nullable();
            $table->unsignedInteger('anulada_por')->nullable();
            $table->dateTime('fecha_anulacion')->nullable();
            $table->timestamps();

            $table->foreign('turno_caja_id')
                ->references('id')
                ->on('turnos_caja')
                ->onUpdate('cascade');

            $table->foreign('usuario_id')
                ->references('id')
                ->on('usuarios')
                ->onUpdate('cascade');

            $table->foreign('anulada_por')
                ->references('id')
                ->on('usuarios')
                ->onUpdate('cascade');

            $table->index('fecha');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ventas');
    }
};
