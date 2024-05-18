<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Billing extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'number', 'expiry_date', 'cvv', 'user_id'];
    protected $primaryKey = 'id';
    protected $table = 'billing';


    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
