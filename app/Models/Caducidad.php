<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Caducidad extends Model
{
    use HasFactory;

    protected $table = 'caducidad';

    // Campos que se pueden llenar masivamente
    protected $fillable = [
        'fecha_caducidad',
        'cantidad',
        'id_detalle_compra ',
        'id_nota_compra',
        'id_producto',

    ];
    protected $with = ['notacompra', 'producto', 'detallecompra'];
    // Relación con la tabla de productos
    public function notacompra()
    {
        return $this->belongsTo(NotaCompra::class, 'id_nota_compra');
    }

    public function producto()
    {
        return $this->belongsTo(Product::class, 'id_producto');
    }
    public function detallecompra()
    {
        return $this->belongsTo(DetalleCompra::class, 'id_detalle_compra');
    }
    public function detallecantidadventa()
    {
        return $this->hasMany(DetalleCantidadVenta::class);
    }
   
}
