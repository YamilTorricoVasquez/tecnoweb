<?php

namespace App\Models;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    use HasFactory;

    protected $fillable = ['name','nombre_empresa', 'phone'];

    public function products()
    {
        return $this->hasMany(Product::class);
    }
    public function devolucion()
    {
        return $this->hasMany(Devolucion::class);
    }
}
