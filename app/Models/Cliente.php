<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    use HasFactory;
    protected $table = 'cliente';
    protected $fillable = ['nombre', 'apellido'];
    public function notaventa()
    {
        return $this->hasMany(NotaVenta::class, 'cliente_id');
    }
}
