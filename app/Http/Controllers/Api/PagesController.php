<?php

namespace App\Http\Controllers\Api;

use Exception;
use App\Models\User;
use App\Models\Transcation;
use Illuminate\Http\Request;
use App\Helpers\UUIDGenerator;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Resources\ProfileResource;
use App\Http\Resources\PhoneCheckResource;
use App\Notifications\GeneralNotification;
use App\Http\Resources\NotificationResource;
use App\Http\Resources\TranscationsResource;
use Illuminate\Support\Facades\Notification;
use App\Http\Resources\NotificationDeailResource;
use App\Http\Resources\TranscationDetailsResource;
use App\Http\Resources\NotificationsDetailsResource;

class PagesController extends Controller
{
    public function profile(){
        $user=Auth::user();
        $data=new ProfileResource($user);
        return success("success",$data);
    }
    public function transcations(Request $request){
        $id=Auth::user()->id;
        $transcations=Transcation::with("source")->orderBy("created_at","desc")->where("user_id",$id);
        if($request->date){
            $transcations=$transcations->whereDate("created_at",$request->date);
        }
        if($request->type){
            $transcations=$transcations->where("type",$request->type);
        }
        $transcations=$transcations->paginate(4);
        $transcations=TranscationsResource::collection($transcations);
        return success("success",$transcations);
    }
    public function transcationsDetails($trx_id){
        $id=Auth::user()->id;
        $transcation=Transcation::with("source")->orderBy("created_at","desc")->where("user_id",$id)->where("trx_id",$trx_id)->first();
        $transcation=new TranscationDetailsResource($transcation);
        return success("success",$transcation);
    }
    public function notifications(){
        $notifications=auth()->user()->notifications()->paginate(5);
        $data=NotificationResource::collection($notifications)->additional(["result"=>1,"message"=>"success"]);
        
        return $data;
    }
    public function notificationsDetails($id){
        $auth_user=auth()->user();
        $notification=$auth_user->notifications()->where("id",$id)->firstOrFail();
        $data=new NotificationsDetailsResource($notification);
        return success("success",$data);
    }
    public function phoneCheck(Request $request){
        $auth_user=auth()->user();
        $to_phone=$request->to_phone;
        $user=User::where("phone",$to_phone)->first();
        if($request->phone !== $auth_user->phone){
            if($user){
                $data=new PhoneCheckResource($user);
                return success("success",$data);
            }
        }
       
        return fail("fail",null);
    }
    public function transferConfirm(Request $request){
        $from_user=auth()->user();
        $to_user=User::where("phone",$request->to_phone)->first();
        
        $hash_value=$request->hash_value;
        $str=$request->to_phone.$request->amount.$request->description;
        $hash2_value=hash_hmac('sha256', $str, 'akkmagicpaynssh@!');
      
        if($hash_value !==$hash2_value){
            return fail("The given data is invalid",null);
        }
        if($from_user->phone === $request->to_phone){
            return fail("Phone number not found",null);
        }
        if($from_user->wallets->amount < $request->amount){
            return fail("You don't enough money",null);
        }
        if($request->amount<1000){
            return fail("You are amount at least 1000(MMK)",null);
        }
        if(!$to_user){
            return fail("Phone Number is not found",null);
        }
        $amount=$request->amount;
        $description=$request->description;
        return success("success",[
            "from_account_name"=>$from_user->name,
            "from_account_phone"=>$from_user->phone,

            "to_account_name"=>$to_user->name,
            "to_account_phone"=>$to_user->phone,

            "amount"=>$amount,
            "description"=> $description,
            "hash_value"=>$hash2_value
        ]);
    }
    public function transferComplete(Request $request){
        $from_user=auth()->user();
        $to_user=User::where("phone",$request->to_phone)->first();
        if(!$request->password){
            return fail("please fill password",null);
          }
        if(!Hash::check($request->password, $from_user->password)){
            return fail("password incorrect",null);
        }
        $hash_value=$request->hash_value;

        $str=$request->to_phone.$request->amount.$request->description;
        $hash2_value=hash_hmac('sha256', $str, 'akkmagicpaynssh@!');
      
        if($hash_value !==$hash2_value){
            return fail("The given data is invalid",null);
        }
        if($from_user->phone === $request->to_phone){
            return fail("Phone Number is not found",null);
          
        }
        if($from_user->wallets->amount < $request->amount){
            return fail("You don't enough money",null);
        }
        if($request->amount<1000){
            return fail("You are amount at least 1000(MMK)",null);
        }
        if(!$to_user){
            return fail("Phone Number is not found",null);
            
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

            //from noti
            $title="E-money Transfered!";
            $message="Your transfered".number_format($amount)." (MMK) to ".$to_user->name;
            $sourceable_id=$from_transcations->id;
            $sourceable_type=Transcation::class;
            $deep_link=[
                "target"=>"transcation_details",
                "parameter"=>[
                    "trx_id"=>$from_transcations->trx_id
                ]
               ];
            $web_link=url("/transcations-details/".$from_transcations->trx_id);
            Notification::send([$from_user],new GeneralNotification($title,$message,$sourceable_id,$sourceable_type,$web_link,$deep_link));

            //to noti
            $title="E-money Transfered!";
            $message="Your recieved".number_format($amount)." (MMK) from ".$from_user->name;
            $sourceable_id=$to_transcations->id;
            $sourceable_type=Transcation::class;
            $web_link=url("/transcations-details/".$to_transcations->trx_id);
            $deep_link=[
                "target"=>"transcation_details",
                "parameter"=>[
                    "trx_id"=>$to_transcations->trx_id
                ]
               ];
            Notification::send([$to_user],new GeneralNotification($title,$message,$sourceable_id,$sourceable_type,$web_link,$deep_link));
            DB::commit();
            return success("success",[
                "trx_id"=>$from_transcations->trx_id
              ]);
        }catch(Exception $e){
            DB::rollBack();
            return fail($e->getMessage(),null);
        }
    }
    public function scanAndPayForm(Request $request){
        
        $from_phone=auth()->user();
       
        if($request->to_phone === $from_phone->phone){
            return fail("Your Phone Number Not Found",null);
            
        }
        $to_phone=User::where("phone",$request->to_phone)->first();
        return success("success",[
            "from_account_name"=>$from_phone->name,
            "from_account_phone"=>$from_phone->phone,
     
            "to_account_name"=>$to_phone->name,
            "to_account_phone"=>$to_phone->phone,
     
          ]);
    }
    public function scanAndPayConfirm(Request $request){
        $from_user=auth()->user();
        $to_user=User::where("phone",$request->to_phone)->first();

        $hash_value=$request->hash_value;

        $str=$request->to_phone.$request->amount.$request->description;
        $hash2_value=hash_hmac('sha256', $str, 'akkmagicpaynssh@!');
      
        if($hash_value !==$hash2_value){
            return fail("The given data is invalid",null);
        }
        if($from_user->phone === $request->to_phone){
            return fail("Phone Number is not found",null);
          
        }
        if($from_user->wallets->amount < $request->amount){
            return fail("You don't enough money",null);
        }
        if($request->amount<1000){
            return fail("You are amount at least 1000(MMK)",null);
        }
        if(!$to_user){
            return fail("Phone Number is not found",null);
            
        }
        $amount=$request->amount;
        $description=$request->description;
        return success("success",[
            "from_account_name"=>$from_user->name,
            "from_account_phone"=>$from_user->phone,

            "to_account_name"=>$to_user->name,
            "to_account_phone"=>$to_user->phone,

            "amount"=>$amount,
            "description"=> $description,
            "hash_value"=>$hash2_value
        ]);
    }
    public function scanAndPayComplete(Request $request){
        $from_user=auth()->user();
        $to_user=User::where("phone",$request->to_phone)->first();
        if(!$request->password){
            return fail("please fill password",null);
          }
        if(!Hash::check($request->password, $from_user->password)){
            return fail("password incorrect",null);
        }
        $hash_value=$request->hash_value;

        $str=$request->to_phone.$request->amount.$request->description;
        $hash2_value=hash_hmac('sha256', $str, 'akkmagicpaynssh@!');
      
        if($hash_value !==$hash2_value){
            return fail("The given data is invalid",null);
        }
        if($from_user->phone === $request->to_phone){
            return fail("Phone Number is not found",null);
          
        }
        if($from_user->wallets->amount < $request->amount){
            return fail("You don't enough money",null);
        }
        if($request->amount<1000){
            return fail("You are amount at least 1000(MMK)",null);
        }
        if(!$to_user){
            return fail("Phone Number is not found",null);
            
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

            //from noti
            $title="E-money Transfered!";
            $message="Your transfered".number_format($amount)." (MMK) to ".$to_user->name;
            $sourceable_id=$from_transcations->id;
            $sourceable_type=Transcation::class;
            $deep_link=[
                "target"=>"transcation_details",
                "parameter"=>[
                    "trx_id"=>$from_transcations->trx_id
                ]
               ];
            $web_link=url("/transcations-details/".$from_transcations->trx_id);
            Notification::send([$from_user],new GeneralNotification($title,$message,$sourceable_id,$sourceable_type,$web_link,$deep_link));

            //to noti
            $title="E-money Transfered!";
            $message="Your recieved".number_format($amount)." (MMK) from ".$from_user->name;
            $sourceable_id=$to_transcations->id;
            $sourceable_type=Transcation::class;
            $web_link=url("/transcations-details/".$to_transcations->trx_id);
            $deep_link=[
                "target"=>"transcation_details",
                "parameter"=>[
                    "trx_id"=>$to_transcations->trx_id
                ]
               ];
            Notification::send([$to_user],new GeneralNotification($title,$message,$sourceable_id,$sourceable_type,$web_link,$deep_link));
            DB::commit();
            return success("success",[
                "trx_id"=>$from_transcations->trx_id
              ]);
        }catch(Exception $e){
            DB::rollBack();
            return fail($e->getMessage(),null);
        }
    }
}
