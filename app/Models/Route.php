<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Route extends Model
{
    use HasFactory;
    protected $fillable = ['user_id', 'journey_id'];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function journey() {
        return $this->belongsTo(Journey::class);
    }
}
