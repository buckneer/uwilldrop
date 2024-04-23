<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Journey extends Model
{
    use HasFactory;

    protected $fillable = ['from', 'to', 'from_coordinates', 'to_coordinates', 'price', 'departure_time', 'seats', 'used_seats','user_id', 'duration', 'route_data'];
    protected $primaryKey = 'id';
    protected $keyType = 'string';

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
