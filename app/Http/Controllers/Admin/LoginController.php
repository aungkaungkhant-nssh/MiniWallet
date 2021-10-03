<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AdminUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest:admin_user')->except('logout');
    }
    public function login(){
        return view("auth.admin-login");
    }
    public function storeLogin(Request $request){
        if(Auth::guard("admin_user")
            ->attempt(
                [
                    "email"=>$request->email,
                    "password"=>$request->password,
                ]
            )
        ){
            AdminUser::where("email",$request->email)->update([
                "ip"=>$request->ip(),
                "user_agent"=>$request->server("HTTP_USER_AGENT")
            ]);
            return redirect("/admin");
        }
        return back()->withInput($request->only('email', 'remember'));
    }
}
