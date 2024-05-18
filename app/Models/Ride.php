<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Ride extends Model
{
    use HasFactory;
    protected $fillable = ['active', 'journey_id', 'user_id', 'rating', 'user_done', 'driver_done', 'rider_id', 'comment', 'user_comment', 'user_rating'];


    public function journey()
    {
        return $this->belongsTo(Journey::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function driver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'rider_id');
    }

}
