<?php

namespace App\Http\Controllers;

use App\Models\Device;
use Illuminate\Http\Request;
use App\Classes\MessageClass;
class DeviceController extends Controller
{
    public function get()
    {
        $devices = Device::all();
        return response()->json([
            'data' => $devices,
            'message' => 'دستگاه ها با موفقیت لیست شد',
            'status' => true]);
    }

    public function create(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'number' => 'required',
        ]);

        Device::create($request->all());
        return response()->json([
            'data' => '',
            'message' => 'دستگاه با موفقیت اضافه شد',
            'status' => true]);
    }
    public function notifForEnd(Request $request){

        $endDevice = Device::find($request->id);
        $endDevice->update([
            'numner' => 0
        ]);
        $message =   " دستگاه ".$endDevice->name .' به اتمام رسیده است .';
        try {
            $messageObj = new MessageClass();
            $emailData = array('title' => 'آزمایشگاه الزهرا', 'message' => $message);
            $messageObj->sendEmail(@config('mail.mailers.smtp.devicecontroller'), $emailData ,'email.alertServices');
            return response()->json([
                'data' => '',
                'message' => 'پیام شما برای مسئول مربوطه ایمیل شد.',
                'status' => true]);
        } catch(\Exeption $e){
            \Log::info("error in sending alert for ending device.");
            return response()->json([
                'data' => '',
                'message' => 'مشکلی در ارسال پیام رخ داده.لطفا بار دیگر تلاش کنید.',
                'status' => true]);
        }

    }
    public function notifForBecomeToEnd(Request $request){

        $endDevice = Device::find($request->id);
        $endDevice->update([
            'numner' => 0
        ]);
        $message =   " دستگاه ".$endDevice->name." رو به اتمام است.لطفا در اسرع وقت پیگیری فرمایید.";
        try {
            $messageObj = new MessageClass();
            $emailData = array('title' => 'آزمایشگاه الزهرا', 'message' => $message);
            $messageObj->sendEmail(@config('mail.mailers.smtp.devicecontroller'), $emailData ,'email.alertServices');
            return response()->json([
                'data' => '',
                'message' => 'پیام شما برای مسئول مربوطه ایمیل شد.',
                'status' => true]);
        } catch(\Exeption $e){
            \Log::info("error in sending alert for ending device.");
            return response()->json([
                'data' => '',
                'message' => 'مشکلی در ارسال پیام رخ داده.لطفا بار دیگر تلاش کنید.',
                'status' => true]);
        }

    }
    public function notifForBroken(Request $request){

        $brokenDevice = Device::find($request->id);
        $brokenDevice->update([
            'numner' => ($brokenDevice->number)-1
        ]);
        $message =   " دستگاه ".$brokenDevice->name." با مشکل مواجه شده است.لطفا پیگیری فرمایید .";
        try {
            $messageObj = new MessageClass();
            $emailData = array('title' => 'آزمایشگاه الزهرا', 'message' => $message);
            $messageObj->sendEmail(@config('mail.mailers.smtp.devicecontroller'), $emailData ,'email.alertServices');
            return response()->json([
                'data' => '',
                'message' => 'پیام شما برای مسئول مربوطه ایمیل شد.',
                'status' => true]);
        } catch(\Exeption $e){
            \Log::info("error in sending alert for ending device.");
            return response()->json([
                'data' => '',
                'message' => 'مشکلی در ارسال پیام رخ داده.لطفا بار دیگر تلاش کنید.',
                'status' => true]);
        }

    }
}
