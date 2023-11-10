<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('subproductos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('users_id')
            ->constrained('users')
            ->onUpdate('cascade')->onDelete('restrict');
            $table->foreignId('subcontenedores_id')
            ->constrained('subcontenedores')
            ->onUpdate('cascade')->onDelete('restrict');
            $table->string('name');
            $table->string('contenedores_id');
            $table->string('factura');
            $table->double('cod_producto');
            $table->integer('cant_producto');
            $table->integer('cant_cajas');
            $table->double('precio_caja');
            $table->double('precio_total');
            $table->double('precio_unitariousd');
            $table->double('porciento_total');
            $table->double('costo_flete');
            $table->double('total_gastousd');
            $table->double('unitario_gastousd');
           
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
