<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = ['type', 'card_id', 'user_id', 'amount'];
    protected $primaryKey = 'id';


    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function card() {
        $this->belongsTo(Billing::class, 'card_id');
    }
}
