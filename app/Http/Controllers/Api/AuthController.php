<?php

namespace App\Http\Controllers\Api;

use App\Helpers\UUIDGenerator;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Wallet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request){
        $request->validate([
            "phone"=>$request->phone,
            "password"=>$request->password
        ]);
  
        if(Auth::attempt(["phone"=>$request->phone,"password"=>$request->password])){
            $user=auth()->user();
            Wallet::firstOrCreate(
                ["user_id",$user->id],
                [
                    "account_number"=>UUIDGenerator::accountNumber(),
                    "amount"=>0
                ]
            );
            
        }
    }
     
}
