<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{
    use HasFactory;
    protected $table='doctors';

    protected  $fillable = [
        'name',
        'expertise_code',
        'address',
        'phone_number'
    ];

    public function getAll(){
        $record = self::all();
        return $record;
    }
    public function getRelevantDoctors($code){
        $records = self::where('expertise_code',$code)->selectRaw('name')->get();
        return $records;

    }
}
