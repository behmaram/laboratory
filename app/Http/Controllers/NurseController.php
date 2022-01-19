<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class NurseController extends Controller
{
    public function get()
    {
        $users = User::whereHas('roles', function ($q) {
            $q->where('name', 'nurse');
        })->get();

        return response()
            ->json(['data' => $users,
                'message' => 'باموفقیت لیست شد',
                'status' => true]);
    }

    public function create(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'mobile' => 'required|regex:/^(09)[0-9]{9}/|unique:users,mobile',
            'password' => 'required',
            'national_code' => 'required',
            'email' => 'required|email',
        ]);

        $user = User::create($request->all());
        $user->assignRole('nurse');

        return response()
            ->json(['data' => $user,
                'message' => 'باموفقیت افزوده شد',
                'status' => true]);
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required',
            'mobile' => 'required|regex:/^(09)[0-9]{9}/|unique:users,mobile',
            'password' => 'required',
            'national_code' => 'required',
            'email' => 'required|email',
        ]);

        $user = User::where('id', $id)->upadte($request->all());

        return response()
            ->json(['data' => $user,
                'message' => 'باموفقیت ویرایش شد',
                'status' => true]);
    }

    public function delete($id)
    {
        User::find($id)->delete();

        return response()
            ->json(['data' => '',
                'message' => 'باموفقیت حذف شد',
                'status' => true]);
    }
}
