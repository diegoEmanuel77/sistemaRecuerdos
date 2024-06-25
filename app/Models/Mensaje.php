<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mensaje extends Model
{
    protected $fillable = [
        'recuerdo_id',
        'nombre',
        'mensaje',
        'imagen',
    ];
   
    use HasFactory;

    public function Mensaje()
    {
        return $this->belongsTo(Mensaje::class);
    }
}
