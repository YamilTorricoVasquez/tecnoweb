<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetalleCantidadVenta extends Model
{
    use HasFactory;

    protected $table = 'detalle_cantidad_venta';

    // Campos que se pueden llenar masivamente
    protected $fillable = [
        'cantidad',
        'id_nota_venta',
        'id_detalle_venta',
        'id_caducidad',
    ];
    protected $with = ['notaventa', 'detalleventa', 'caducidad'];
    // Relación con la tabla de productos
    public function notaventa()
    {
        return $this->belongsTo(NotaVenta::class, 'id_nota_venta');
    }

    public function detalleventa()
    {
        return $this->belongsTo(DetalleVenta::class, 'id_detalle_venta');
    }
    public function caducidad()
    {
        return $this->belongsTo(Caducidad::class, 'id_caducidad');
    }


}
