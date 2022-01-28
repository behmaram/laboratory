<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Turn;
use App\Models\Test;
use App\Models\Doctor;
use App\Models\User;
use App\Classes\MessageClass;
use Illuminate\Support\Facades\Auth;

class TurnController extends Controller
{
    public function __construct(Turn $turnObj,Test $testObj,Doctor $doctorObj)
    {
        $this->turnObj = $turnObj;
        $this->testObj = $testObj;
        $this->doctorObj = $doctorObj;
        
    }
    public function setTurn(Request $request){
        $userId = auth()->user()->id;
        $this->validate($request, [
            'test_id' => 'required',
            'turn_time' => 'required',
        ]);
        $turnTime = $request->turn_time;
        $testId = $request->test_id;
       
        if ($turnTime <= now()){
            return response()->json([
                'data' => '',
                'message' => 'تایم غیر مجاز (مجاز به انتخاب تایم گذشته نیستید.)',
                'status' => true]);
        }
        $record = $this->turnObj->checkReservation($turnTime);
       
        if ($record){
            return response()->json([
                'data' => '',
                'message' => 'زمان انتخابی شما از قبل رزو شده است. لطفا تایم دیگری را انتخاب کنید',
                'status' => true]);
        }
        $this->turnObj->create([
            'user_id' => Auth::id(),
            'test_id' => $testId,
            'turn_time' => $turnTime,
            'done' => 0
           
        ]);
        try {
            $messageObj = new MessageClass();
            $user = User::find($userId);
            $testInfo = $this->testObj->find($testId);
            if (is_null($testInfo->description)){
                $testCondition->description = "شرایط خاصی ندارد.";
            }
            
            $testCondition = 'شرایط آزمایش '.$testInfo->name.' : '.$testInfo->description;
            $testCondition .= "\n"." آزمایش ".$testInfo->name." تقریبا ".$testInfo->estimate." روز بعد از انجام آزمایش آماده ی تحویل است. ";
            $emailData = array('title' => 'آزمایشگاه الزهرا', 'message' => $testCondition);
            $messageObj->sendEmail($user->email, $emailData ,'email.conditionTest');
          
          } catch (\Exception $e) {
            \Log::info($e);
             \Log::info("error in sending condition of test");
          }
        return response()->json([
            'data' => $testCondition,
            'message' => 'نوبت آزمایش شما با موفقیت ثبت شد.',
            'status' => true]);
    }
    public function getDoneTurn(Request $request){
        $userId = auth()->user()->id;
        $records = $this->turnObj->getDoneTurnByUserId($userId,$request->hasResult);

        return response()->json([
            'data' => $records,
            'message' => '',
            'status' => true]);
      
    }
    public function getResult($testId){

        $record = $this->turnObj->find($testId);
        if ($record){
        if (is_null($record->result)){

            return response()->json([
                'data' => '',
                'message' => 'جواب آزمایش شما هنوز آماده نیست.',
                'status' => true]);
        }
        $analysis = $this->testObj->checkResult($record->test_id,$record->result);
        $testInfo = $this->testObj->find($record->test_id);
        $message = ' نتیجه آزمایش شما'. $analysis['value'] .' میباشد.';
        if ($analysis['key'] == 0 || $analysis['key'] == 2){
            $doctors= $this->doctorObj->getRelevantDoctors($testInfo->expertise_code);
            $message .= ' برای رفع مشکل مربوطه میتوانید به دکترهای معرفی شده مراجعه فرمایید.';
            foreach ($doctors as $doctor) {
                $message .= $doctor->name .' _ ';
                
            }
            $record['doctors'] = $doctors;
            
        }
        
        
        return response()->json([
            'data' => $record,
            'message' => $message,
            'status' => true]);
    }
    }
    // _____________________________________ nurse Api ____________________________________//
    
    public function getTests($filter){

        $testUsers = $this->turnObj->getAllWithoutResult($filter);

        return response()->json([
            'data' => $testUsers,
            'message' => '',
            'status' => true]);
    }
    
    public function setResult(Request $request){
    
        $record = $this->turnObj->setResult($request->id,$request->result);
        
        try {
            $messageObj = new MessageClass();
            $user = User::find($record->user_id);
            $emailData = array('title' => ' آزمایشگاه الزهرا');
            $messageObj->sendEmail($user->email, $emailData , 'email.emailResult');
        }catch(\Exeption $e){
            \Log::info("error in sending Email Result");
        }

        return response()->json([
            'data' => $record,
            'message' => 'جواب آزمایش با موفقیت ثبت شد.',
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
