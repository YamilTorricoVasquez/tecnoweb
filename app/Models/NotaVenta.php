<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class NotaVenta extends Model
{
    use HasFactory;

    protected $table = 'nota_venta';

    // Campos que se pueden llenar masivamente
    protected $fillable = [
        'fecha',
        'total',
        'user_id',
        'paymentmethod_id',
        'cliente_id',

    ];
    protected $with = ['user', 'paymentmethod', 'cliente'];
    // Relación con la tabla de productos
    public function paymentmethod()
    {
        return $this->belongsTo(PaymentMethod::class);
    }

    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'cliente_id');
    }


    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function detalleventa()
    {
        return $this->hasMany(DetalleVenta::class);
    }
    public function detallecantidadventa()
    {
        return $this->hasMany(DetalleCantidadVenta::class);
    }
}
