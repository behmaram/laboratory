<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'test_id', 'price', 'status', 'transaction_id', 'reference_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
