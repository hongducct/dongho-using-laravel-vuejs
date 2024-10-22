<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attribute extends Model
{
    protected $fillable = [
        'movement',
        'case',
        'strap',
        'water_resistance',
        'product_id',
    ];
    use HasFactory;
}
