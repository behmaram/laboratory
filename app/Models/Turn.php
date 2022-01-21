<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Turn extends Model
{
    use HasFactory;

    protected $table = 'turns';

    protected $fillable = [
        'user_id',
        'test_id',
        'turn_time',
        'result',
        'done'
    ];

    public function checkReservation($turnTime)
    {
        $record = self::where('done', 0)->where('turn_time', $turnTime)->first();
        return $record;
    }
}
