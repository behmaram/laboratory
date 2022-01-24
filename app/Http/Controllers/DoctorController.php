<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Doctor;
class DoctorController extends Controller
{
    public function __construct(Doctor $doctorObj)
    {
        $this->doctorbj = $doctorObj;
        
    }
    public function getDoctors(){
        
        $dectors = $this->doctorbj->getAll();

        return response()->json([
            'data' => $dectors,
            'message' => '',
            'status' => true]);
    }
}
