<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\HttpException;

class UserController extends Controller
{
    public function signUp(Request $request)
    {
        $this->validate($request, [
            'mobile' => 'required|regex:/^(09)[0-9]{9}/|unique:users,mobile',
            'password' => 'required',
            'national_code' => 'required',
            'email' => 'required|email',
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
                throw new HttpException(401,'پسورد وارد شده اشتباه است');
            } else {
                $token = $user->createToken('MyApp');
                $user['token'] = $token->accessToken;
                return response()
                    ->json(['data' => $user,
                        'message' => 'باموفقیت وارد شدید',
                        'status' => true]);
            }
        } else
            throw new HttpException(401,'لطفا ابتدا ثبت نام کنید');
    }
}
