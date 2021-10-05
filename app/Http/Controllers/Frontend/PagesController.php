<?php

namespace App\Http\Controllers\Frontend;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\UpdatePassword;
use Illuminate\Support\Facades\Hash;

class PagesController extends Controller
{
    public function home(){
        $user=Auth::guard("web")->user();
        return view("frontend.home",compact("user"));
    }
    public function profile(){
        $user=Auth::guard("web")->user();
        $token=Str::random(64);
        return view("frontend.profile",compact("user",'token'));
    }
    public function passwordUpdate(){
        return view("frontend.passwordupdate");
    }
    public function passwordUpdateStore(UpdatePassword $request){
        $old_password=$request->old_password;
        $new_password=$request->new_password;

        $user=Auth::guard("web")->user();
        if(Hash::check($old_password,$user->password)){
            $user->password=Hash::make($new_password);
            $user->update();
            return redirect()->route("profile")->with("update","Password Update Successfully");
        }
        return back()->withErrors(["old_password"=>"Current Password is invalid"])->withInput();
    }
}
