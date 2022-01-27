<?php

namespace App\Http\Controllers;

use App\Models\Turn;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Shetabit\Multipay\Exceptions\InvalidPaymentException;
use Shetabit\Multipay\Invoice;
use Shetabit\Payment\Facade\Payment;
use Symfony\Component\HttpKernel\Exception\HttpException;

class UserController extends Controller
{
    public function __construct(Turn $turnObj)
    {
        $this->turnObj = $turnObj;
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
        $user = Auth::user();
        $user_tests = Turn::where('user_id', $user->id)->where('done', 0)->where('turn_time', '>=', Carbon::now())->get();

        foreach ($user_tests as $user_test) {
            $prices[] = $user_test->test->price;
        }

        $invoice = (new Invoice)->amount(array_sum($prices));

        $payment = Payment::callbackUrl(route('purchase.result'));
        return $payment->purchase($invoice, function ($driver, $transactionId) {

        })->pay()->render();
    }

    public function result()
    {
        try {

            return view('success');

        } catch (InvalidPaymentException $exception) {
            if ($exception->getCode() < 0) {
                $transaction = $this->planRepository->failed_status($id);
                return view('error', ['user_id' => $transaction->user_id, 'error' => $exception->getMessage()]);
            }
        }
    }
}
