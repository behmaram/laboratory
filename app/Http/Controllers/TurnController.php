<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Turn;
use Illuminate\Support\Facades\Auth;

class TurnController extends Controller
{
    public function __construct(Turn $turnObj)
    {
        $this->turnObj = $turnObj;

    }

    //user select tests
    public function setTurn(Request $request)
    {
        $this->validate($request, [
            'test_id' => 'required',
            'turn_time' => 'required',
        ]);

        $turnTime = $request->turn_time;
        $testId = $request->test_id;
        $record = $this->turnObj->checkReservation($turnTime);
        if ($record) {
            return response()->json([
                'data' => '',
                'message' => 'زمان انتخابی شما از قبل رزو شده است. لطفا تایم دیگری را انتخاب کنید',
                'status' => true]);
        }
        $this->turnObj->create([
            'user_id' => Auth::id(),
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

    public function nurseSetTurn(Request $request)
    {
        $this->validate($request, [
            'user_id' => 'required',
            'test_id' => 'required',
            'turn_time' => 'required',
        ]);

        $turnTime = $request->turn_time;
        $testId = $request->test_id;
        $record = $this->turnObj->checkReservation($turnTime);
        if ($record) {
            return response()->json([
                'data' => '',
                'message' => 'زمان انتخابی شما از قبل رزو شده است. لطفا تایم دیگری را انتخاب کنید',
                'status' => true]);
        }
        $this->turnObj->create([
            'user_id' => $request->user_id,
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
