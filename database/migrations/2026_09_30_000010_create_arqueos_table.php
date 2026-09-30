<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('arqueos', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('turno_caja_id')->unique();
            $table->unsignedInteger('usuario_id');
            $table->decimal('total_esperado', 12, 2)->unsigned();
            $table->decimal('total_declarado', 12, 2)->unsigned();
            $table->decimal('diferencia', 12, 2);
            $table->text('observaciones')->nullable();
            $table->dateTime('fecha')->useCurrent();
            $table->timestamps();

            $table->foreign('turno_caja_id')
                ->references('id')
                ->on('turnos_caja')
                ->onUpdate('cascade');

            $table->foreign('usuario_id')
                ->references('id')
                ->on('usuarios')
                ->onUpdate('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('arqueos');
    }
};
