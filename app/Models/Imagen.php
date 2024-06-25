<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
class Imagen extends Model
{
    use HasFactory;
    protected $fillable = [
        'recuerdo_id',
        'url',
     
    ];
    public function recuerdo()
    {
        return $this->belongsTo(Recuerdo::class);
    }
}
