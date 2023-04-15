<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Seance extends Model
{
    use HasFactory;
    protected $fillable = [
        'time_begin', 'film_id', 'hall_id', 'types_of_chairs', 'price_of_chair'
    ];
    protected $hidden = [
        'created_at', 'updated_at'
    ];
}
