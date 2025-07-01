<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetalleCompra extends Model
{
    use HasFactory;

    protected $table = 'detalle_compra';

    // Campos que se pueden llenar masivamente
    protected $fillable = [
        'fecha_caducidad',
        'cantidad',
        'precio_compra',
        'total',
        'id_nota_compra',
        'id_producto',

    ];
    protected $with = ['notacompra', 'producto'];
    // Relación con la tabla de productos
    public function notacompra()
    {
        return $this->belongsTo(NotaCompra::class,'id_nota_compra');
    }

    public function producto()
    {
        return $this->belongsTo(Product::class,'id_producto');
    }
    public function caducidad()
    {
        return $this->hasMany(Caducidad::class);
    }
    public function detallecantidadventa()
    {
        return $this->hasMany(DetalleCantidadVenta::class);
    }
    
}
