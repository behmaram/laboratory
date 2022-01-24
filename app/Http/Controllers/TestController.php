<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Test;

class TestController extends Controller
{
    public function __construct(Test $testObj)
    {
        $this->testObj = $testObj;
    }

    public function getTestList()
    {
        $list = $this->testObj->getAll();
        return response()->json([
            'data' => $list,
            'message' => '',
            'status' => true]);
    }

}
