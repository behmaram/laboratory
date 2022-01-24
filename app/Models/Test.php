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
        'price',
        'expertise_code'
    ];
    public function getAll(){

        $list = self::all();
        return $list;
    }
    public function checkResult($id,$result){
        $record = self::find($id);
        if ($result <= $record->high && $result >= $record->low){
            // ل
            return ['key' => 1 , 'value' => "نرمال"];
        }
        if ($result > $record->high && $result > $record->low){
            // بالاتر از حد نرمال
            return ['key' => 2 , 'value' => "بالاتر از حد نرمال"];
        }
        if ($result < $record->high && $result < $record->low){
            // پایین تر از حد نرمال
            return ['key' => 0 , 'value' => "پایین از حد نرمال"];
        }
    }
}
