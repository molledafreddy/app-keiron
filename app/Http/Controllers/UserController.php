<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $tickets = User::where('type_user_id',2)->get();
       
        return response()->json(['status' => 'ok', 'data' => $tickets], 200);
    }
        
}
