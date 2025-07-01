<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NotaCompra extends Model
{
    use HasFactory;

    protected $table = 'nota_compra';

    // Campos que se pueden llenar masivamente
    protected $fillable = [
        'fecha',
        'total',
        'id_usuario',
        'id_proveedor',
        'id_metodo_pago',

    ];
    protected $with = ['user', 'paymentmethod', 'proveedor'];
    // Relación con la tabla de productos
    public function paymentmethod()
    {
        return $this->belongsTo(PaymentMethod::class, 'id_metodo_pago');
    }

    public function proveedor()
    {
        return $this->belongsTo(Supplier::class, 'id_proveedor');
    }


    public function user()
    {
        return $this->belongsTo(User::class, 'id_usuario');
    }
    public function detallecompra()
    {
        return $this->hasMany(DetalleCompra::class, 'id_nota_compra');
    }
    public function caducidad()
    {
        return $this->hasMany(Caducidad::class);
    }

}
