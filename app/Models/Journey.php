<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Journey extends Model
{
    use HasFactory;

    protected $fillable = ['from', 'to', 'date', 'price', 'user_id'];
    protected $primaryKey = 'journey_id';
    protected $keyType = 'string';

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
