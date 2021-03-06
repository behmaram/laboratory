<?php

namespace App\Http\Controllers;

use App\Models\Test;
use App\Models\Transaction;
use App\Models\Turn;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Shetabit\Multipay\Exceptions\InvalidPaymentException;
use Shetabit\Multipay\Invoice;
use Shetabit\Payment\Facade\Payment;
use Symfony\Component\HttpKernel\Exception\HttpException;
use App\Classes\MessageClass;
class UserController extends Controller
{
    public function __construct(Turn $turnObj, Test $testObj)
    {
        $this->turnObj = $turnObj;
        $this->testObj = $testObj;
    }

    public function signUp(Request $request)
    {
        $this->validate($request, [
            'mobile' => 'required|regex:/^(09)[0-9]{9}/|unique:users,mobile',
            'password' => 'required',
            'national_code' => 'required|unique:users,national_code',
            'email' => 'required|email|unique:users,email',
        ]);

        $user = User::create($request->all());
        $user->assignRole('user');

        return response()
            ->json(['data' => $user,
                'message' => 'باموفقیت ثبت نام کردید',
                'status' => true]);

    }

    public function signIn(Request $request)
    {
        $this->validate($request, [
            'mobile' => 'required|regex:/^(09)[0-9]{9}/',
            'password' => 'required',
        ]);

        $user = User::where('mobile', $request->mobile)->first();
        if ($user) {
            if ($user->password != $request->password) {
                throw new HttpException(401, 'پسورد وارد شده اشتباه است');
            } else {
                $token = $user->createToken('MyApp');
                $user['token'] = $token->accessToken;
                return response()
                    ->json(['data' => $user,
                        'message' => 'باموفقیت وارد شدید',
                        'status' => true]);
            }
        } else
            throw new HttpException(401, 'لطفا ابتدا ثبت نام کنید');
    }

    public function purchase()
    {
        $user_id = Auth::id();
        $user_tests = Turn::where('user_id', $user_id)->where('done', 0)->where('payment', 0)->where('turn_time', '>=', Carbon::now())->get();

        $prices = [];
        $transactions = [];
        foreach ($user_tests as $user_test) {
            $transactions[] = Transaction::create([
                'user_id' => $user_id,
                'test_id' => $user_test->test->id,
                'price' => $user_test->test->price,
            ]);
            $prices[] = $user_test->test->price;
        }

        $invoice = (new Invoice)->amount(array_sum($prices));

        $payment = Payment::callbackUrl(route('purchase.result', ['userId' => $user_id]));
        return $payment->purchase($invoice, function ($driver, $transactionId) use ($transactions) {
//            foreach ($transactions as $transaction) {
//                Transaction::where('id', $transaction->id)->first()->update(['transaction_id' => $transactionId]);
//            }
        })->pay()->render();
    }

    public function result($userId)
    {
        try {
            $paids = Turn::where('user_id', $userId)->where('payment', 0)->get();
            $transactions = Transaction::where('user_id', $userId)->where('status', 0)->get();
            $prices = array_sum($transactions->pluck('price')->toArray());

            $receipt = Payment::amount($prices)->transactionId($transactions[0]->transaction_id)->verify();
            $messageObj = new MessageClass();
            $testCondition = '';
            $transactions->each(function ($item) {
               $item->update(['status' => 1]);
            });
            foreach ($paids as $paid) {

                    $user = User::find($paid->user_id);
                    $testInfo = $this->testObj->find($paid->id);
                    $testCondition .= 'شرایط آزمایش '.$testInfo->name.' : ';
                    if (is_null($testInfo->description)){
                        $testCondition .= "شرایط خاصی ندارد.";
                    }
                    else{
                        $testCondition .=  $testInfo->description;
                    }

                    $testCondition .= "\n"." آزمایش ".$testInfo->name." تقریبا ".$testInfo->estimate." روز بعد از انجام آزمایش آماده ی تحویل است. ";

                $paid->update(['payment' => 1]);
            }

            foreach ($transactions as $transaction) {
                $transaction->update(['status' => 1, 'reference_id' => $receipt->getReferenceId()]);
            }
            try {
            $emailData = array('title' => 'آزمایشگاه الزهرا', 'message' => $testCondition);
            $messageObj->sendEmail($user->email, $emailData ,'email.conditionTest');
            } catch (\Exception $e) {
                \Log::info($e);
                 \Log::info("error in sending condition of test");
              }
            return view('success');
        } catch (InvalidPaymentException $exception) {
            if ($exception->getCode() < 0) {
                $transactions = Transaction::where('user_id', $userId)->where('status', 0)->get();

                foreach ($transactions as $transaction) {
                    $transaction->update(['status' => 2]);
                }
                return view('error', ['message' => $exception->getMessage()]);
            }
        }
    }
}
