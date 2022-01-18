<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Turn;
class TurnController extends Controller
{
    public function __construct(Turn $turnObj)
    {
        $this->turnObj = $turnObj;
        
    }
    public function setTurn(Request $request){
        $userId = 3;
        //auth()->user()->id;
        $turnTime = $request->turn_time;
        $testId = $request->test_id;
        $record = $this->turnObj->checkReservation($turnTime);
        if ($record){
            return response()->json([
                    'data' => '',
                    'message' => 'زمان انتخابی شما از قبل رزو شده است.لطفا تایم دیگری را انتخاب کنید',
                    'status' => true]);   
        }
        $this->turnObj->create([
            'user_id' => $userId,
            'test_id' => $testId,
            'turn_time' => $turnTime,
            'done' => 0,
            'result' => 0
        ]);
        return response()->json([
            'data' => '',
            'message' => 'نوبت آزمایش شما با موفقیت ثبت شد.',
            'status' => true]);
    }
  
}
