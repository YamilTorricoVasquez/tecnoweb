<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class PaymentMethod extends Model
{
    use HasFactory;
    protected $table = 'payment_method';
    protected $fillable = ['metodo'];
    public function notaventa()
    {
        return $this->hasMany(NotaVenta::class);
    }
}
