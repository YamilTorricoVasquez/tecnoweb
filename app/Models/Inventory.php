<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    use HasFactory;
    
    protected $fillable = ['fecha'];


    public function inventoryDetail()
    {
        return $this->hasMany(InventoryDetail::class,'inventory_id');
    }
}
