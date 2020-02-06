<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ApiTestController extends Controller
{
    public function login(){ 
        
            return response()->json([
        "message" => "student record created"
    ], 200);
        
    }
}
