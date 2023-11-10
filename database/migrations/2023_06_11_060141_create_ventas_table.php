<?php

use App\Models\productos;
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
        Schema::create('ventas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('users_id')
            ->constrained('users')
            ->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('productos_id')
            ->constrained('productos')
            ->onUpdate('cascade')->onDelete('cascade');
            $table->double('valorcup_producto', 8,2);
            $table->string('venta_propuesta', 8,2);
            $table->double('porciento_ganancia', 8,2);
            $table->double('precio_venta',8,2);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ventas');
    }
};
