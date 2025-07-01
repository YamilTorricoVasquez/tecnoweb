<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class InventoryDetail extends Model
{
    use HasFactory;
    protected $table = 'inventory_detail';
    // protected $fillable = ['name','descripcion', 'image', 'category_id', 'supplier_id'];
    protected $fillable = ['cantidad', 'cantidad_minima', 'precio_venta', 'product_id', 'inventory_id'];

    public $timestamps = false;

    protected $with = ['product', 'inventory'];

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function inventory()
    {
        return $this->belongsTo(Inventory::class, 'inventory_id');
    }
}
