<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory;

    protected $primaryKey = 'id';

    protected $fillable = [
        'user_id',
        'name',
        'phone_number',
        'province',
        'district',
        'ward',
        'address',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
