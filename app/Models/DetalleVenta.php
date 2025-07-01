<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetalleVenta extends Model
{
    use HasFactory;

    protected $table = 'detalle_venta';

    // Campos que se pueden llenar masivamente
    protected $fillable = [
        'cantidad',
        'precio_venta',
        'total',
        'id_nota_venta',
        'id_producto',

    ];
    protected $with = ['notaventa', 'producto'];
    // Relación con la tabla de productos
    public function notaventa()
    {
        return $this->belongsTo(NotaVenta::class,'id_nota_venta');
    }

    public function producto()
    {
        return $this->belongsTo(Product::class,'id_producto');
    }


}
