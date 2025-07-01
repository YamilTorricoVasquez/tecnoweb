<?php

namespace App\Models;

use App\Models\Category;
use App\Models\Supplier;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    // protected $fillable = ['name','descripcion', 'image', 'category_id', 'supplier_id'];
    protected $fillable = ['name', 'descripcion', 'image', 'category_id'];

    protected $with = ['category'];
    public $timestamps = false;
    // protected $with = ['category', 'supplier'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }
    public function devolucion()
    {
        return $this->hasMany(Devolucion::class);
    }
    public function detalleventa()
    {
        return $this->hasMany(DetalleVenta::class);
    }
    public function detallecompra()
    {
        return $this->hasMany(DetalleCompra::class);
    }
    public function caducidad()
    {
        return $this->hasMany(Caducidad::class);
    }
}
