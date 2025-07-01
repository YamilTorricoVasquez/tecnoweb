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
        Schema::create('detalle_cantidad_venta', function (Blueprint $table) {
            $table->id();
            $table->integer('cantidad');
            $table->foreignId('id_nota_venta')->constrained('nota_venta')->onDelete('cascade');
            $table->foreignId('id_detalle_venta')->constrained('detalle_venta')->onDelete('cascade');
            $table->foreignId('id_caducidad')->constrained('caducidad');



            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detalle_cantidad_venta');
    }
};
