<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class Reason extends Model
{
    use HasFactory;
    protected $table = 'reason';
    protected $fillable = ['descripcion'];

    public function devolucion()
    {
        return $this->hasMany(Devolucion::class);
    }

}
