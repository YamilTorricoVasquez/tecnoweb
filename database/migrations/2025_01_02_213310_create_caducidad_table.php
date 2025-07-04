<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('caducidad', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_nota_compra')->constrained('nota_compra')->onDelete('cascade');
            $table->foreignId('id_detalle_compra')->constrained('detalle_compra')->onDelete('cascade');
            $table->foreignId('id_producto')->constrained('products')->onDelete('no action');
            $table->integer('cantidad');
            $table->date('fecha_caducidad');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('caducidad');
    }
};
