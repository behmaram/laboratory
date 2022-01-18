<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Test extends Model
{
    protected $table='tests';

    protected  $fillable = [
        'name',
        'en_name',
        'description',
        'high',
        'low',
        'estimate',
        'price'
    ];
    public function getAll(){

        $list = self::all();
        return $list;
    }
}
