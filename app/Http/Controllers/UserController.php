<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function signUp(Request $request)
    {
        $this->validate($request, [
            'mobile' => 'required',
            'password' => 'required',
            'national_code' => 'required',
        ]);

        User::create($request->all());

    }
}
