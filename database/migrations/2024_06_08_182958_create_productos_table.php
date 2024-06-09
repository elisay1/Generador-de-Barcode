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
        Schema::create('productos', function (Blueprint $table) {
            $table->id();            
            $table->string('codigo');
            $table->string('nombre');
            $table->text('descripcion')->nullable();
            $table->string('imagen')->nullable();
            $table->decimal('precio_compra', 8, 2);
            $table->decimal('costo_venta', 8, 2);
            $table->integer('stock');
            $table->date('fechaven')->nullable();
            // $table->foreignId('id_categoria')->constrained('categorias');
            // $table->foreignId('id_moneda')->constrained('monedas');
            // $table->foreignId('id_medida')->constrained('medidas');
            $table->boolean('estado');
            $table->string('barcode_image')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('productos');
    }
};
