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
    public function register(Request $request){
        $request->validate([
            "name"=>["required"],
            "email"=>["required","string","email","unique:users"],
            "phone"=>["required"],
            "password"=>["required","string","min:8","max:16"]
        ]);
        $user=new User();
        $user->name=$request->name;
        $user->email=$request->email;
        $user->phone=$request->phone;
        $user->password=Hash::make($request->password);
        $user->save();
        Wallet::firstOrCreate(
            ["user_id"=>$user->id],
            [
                "account_number"=>UUIDGenerator::accountNumber(),
                "amount"=>0
            ]
        );
        $token=$user->createToken("mini wallet")->accessToken;
        return success("Registered Successfully",["token"=>$token]);
    }
    public function login(Request $request){
        $request->validate([
            "phone"=>['required', 'string'],
            "password"=>['required','string']
        ]);
  
        if(Auth::attempt(["phone"=>$request->phone,"password"=>$request->password])){
            $user=auth()->user();
            Wallet::firstOrCreate(
                ["user_id"=>$user->id],
                [
                    "account_number"=>UUIDGenerator::accountNumber(),
                    "amount"=>0
                ]
            );
            $token=$user->createToken("mini wallet")->accessToken;
            return success("Successfully login",["token"=>$token]);
        }
        return fail("These credential do not match our records",null);
    }
    public function logout(){
        $user=Auth::user();
        $user->token()->revoke();
        return success("Successfully logout",null);
    }
}
