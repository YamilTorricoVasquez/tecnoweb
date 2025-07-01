<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class Devolucion extends Model
{
    use HasFactory;

    protected $table = 'devolucion';

    // Campos que se pueden llenar masivamente
    protected $fillable = [
        'fecha_caducidad',
        'cantidad',
        'reason_id',
        'user_id',
        'product_id',
        'supplier_id',
    ];
    protected $with = ['product', 'supplier','reason'];
    // Relación con la tabla de productos
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id'); // 'id_producto' es la clave foránea
    }

    // Relación con la tabla de proveedores
    public function supplier()
    {
        return $this->belongsTo(Supplier::class); // 'id_proveedor' es la clave foránea
    }

    // Relación con la tabla de razones
    public function reason()
    {
        return $this->belongsTo(Reason::class); // 'id_razon' es la clave foránea
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
