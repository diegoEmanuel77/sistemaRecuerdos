<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
class Recuerdo extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
    'nombre',
    'descripcion',
    'portada',
    'audio',
    ];
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function imagenes()
    {
       
        return $this->hasMany(Imagen::class);
    }
    public function mensajes()
    {
        return $this->hasMany(Mensaje::class);
    }
}
