<?php

namespace App\Http\Controllers;

use App\Models\Device;
use Illuminate\Http\Request;

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
}
