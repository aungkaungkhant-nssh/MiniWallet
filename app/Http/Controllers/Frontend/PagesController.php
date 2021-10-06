<?php

namespace App\Http\Controllers\Frontend;

use App\Helpers\UUIDGenerator;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\TransferRequest;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\UpdatePassword;
use App\Models\Transcation;
use Exception;
use Illuminate\Support\Facades\DB;
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
    public function wallets(){
        $user=Auth::guard('web')->user();
        return view("frontend.wallets",compact("user"));
    }
    public function transfer(){
        $user=Auth::guard('web')->user();
        return view("frontend.transfer",compact("user"));
    }
    public function transferHash(Request $request){
        $str=$request->phone.$request->amount.$request->description;
        $hash_value=hash_hmac('sha256', $str, 'akkmagicpaynssh@!');
        return response()->json([
            "status"=>"success",
            "data"=>$hash_value
        ]);
    }
    public function transferConfirm(TransferRequest $request){
            $from_user=Auth::guard('web')->user();
            $to_user=User::where("phone",$request->to_phone)->first();

            $hash_value=$request->hash_value;

            $str=$request->to_phone.$request->amount.$request->description;
            $hash2_value=hash_hmac('sha256', $str, 'akkmagicpaynssh@!');
          
            if($hash_value !==$hash2_value){
                return back()->withErrors(["fail"=>"The given data is invalid"]);
            }
            if($from_user->phone === $request->to_phone){
                return back()->withErrors(["to_phone"=>"Phone Number is not found"]);
            }
            if($from_user->wallets->amount < $request->amount){
                return back()->withErrors(["amount"=>"You don't enough money"]);
            }
            if($request->amount<1000){
                return back()->withErrors(["amount"=>"You are amount at least 1000(MMK)"]);
            }
            if(!$to_user){
                return back()->withErrors(["to_phone"=>"Phone Number is not found"]);
            }
            $amount=$request->amount;
            $description=$request->description;
            return view("frontend.transferConfirm",compact("from_user","to_user","amount","description","hash2_value"));
    }
    public function transferComplete(TransferRequest $request){
    
        $from_user=Auth::guard('web')->user();
        $to_user=User::where("phone",$request->to_phone)->first();

        $hash_value=$request->hash_value;

        $str=$request->to_phone.$request->amount.$request->description;
        $hash2_value=hash_hmac('sha256', $str, 'akkmagicpaynssh@!');
      
        if($hash_value !==$hash2_value){
            return back()->withErrors(["fail"=>"The given data is invalid"]);
        }
        if($from_user->phone === $request->to_phone){
            return back()->withErrors(["to_phone"=>"Phone Number is not found"]);
        }
        if($from_user->wallets->amount < $request->amount){
            return back()->withErrors(["amount"=>"You don't enough money"]);
        }
        if($request->amount<1000){
            return back()->withErrors(["amount"=>"You are amount at least 1000(MMK)"]);
        }
        if(!$to_user){
            return back()->withErrors(["to_phone"=>"Phone Number is not found"]);
        }
        $amount=$request->amount;
        $description=$request->description;
        DB::beginTransaction();
        try{
            $from_user->wallets->decrement('amount',$amount);
            $from_user->wallets->update();

            $to_user->wallets->increment("amount",$amount);
            $to_user->wallets->update();

            //transcation
            $ref_no=UUIDGenerator::refNumber();
            //from user transcation
          
            $from_transcations=new Transcation();
            $from_transcations->ref_id=$ref_no;
            $from_transcations->trx_id=UUIDGenerator::trxNumber();
            $from_transcations->user_id=$from_user->id;
            $from_transcations->type=2;
            $from_transcations->amount=$amount;
            $from_transcations->description=$description;
            $from_transcations->source_id=$to_user->id;
            $from_transcations->save();

            //to user transcation
           
            $to_transcations=new Transcation();
            $to_transcations->ref_id=$ref_no;
            $to_transcations->trx_id=UUIDGenerator::trxNumber();
            $to_transcations->user_id=$to_user->id;
            $to_transcations->type=1;
            $to_transcations->amount=$amount;
            $to_transcations->description=$description;
            $to_transcations->source_id=$from_user->id;
            $to_transcations->save();
            DB::commit();
            return redirect('/');
        }catch(Exception $e){
            DB::rollBack();
            return back()->withErrors(['fail',$e->getMessage()]);
        }
      
    }
    public function phoneCheck(Request $request){
        $to_phone=$request->to_phone;
        $user=User::where("phone",$to_phone)->first();
        if($user){
            return response()->json([
                "status"=>"success",
                "data"=>$user
            ]);
        }
        return response()->json([
            "status"=>"error",
        ]);
    }
    public function passwordCheck(Request $request){
           $user= Auth::guard("web")->user();
           if(Hash::check($request->password, $user->password)){
               return response()->json([
                   "status"=>"success",
                   "message"=>"The Password Correct"
               ]);
           }
           return response()->json([
               "status"=>"fail"
           ]);
    }
}
