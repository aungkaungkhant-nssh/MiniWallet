<?php

namespace App\Http\Controllers\Backend;

use App\Helpers\UUIDGenerator;
use App\Http\Controllers\Controller;
use App\Models\AdminUser;
use App\Models\Transcation;
use App\Models\User;
use App\Models\Wallet;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\Datatables\Datatables;

class WalletController extends Controller
{
    public function index(){
        return view("backend.wallet.index");
    }
    public function ssd(){
      
       $wallet= Wallet::with("user");
      return DataTables::of($wallet)
      ->editColumn("account_person",function($wallet){
          if($wallet->user){
              return '<p>'.$wallet->user->name.'</p>'.'<p>'.$wallet->user->email.'</p>'.'<p>'.$wallet->user->phone.'</p>';
          };
      })
      ->editColumn("created_at",function($wallet){
          return Carbon::parse($wallet->created_at)->format("Y-m-d H:i:s");
      })
      ->editColumn("updated_at",function($wallet){
        return Carbon::parse($wallet->created_at)->format("Y-m-d H:i:s");
        })
      ->rawColumns(["account_person"])
      ->make(true);
    }
    public function addAmount(){
        $users=User::orderBy("name")->get();
        return view("backend.wallet.addAmount",compact("users"));
    }
    public function addAmountStore(Request $request){
        $request->validate(
            [
            "user_id"=>"required",
            "amount"=>"required|integer"
            ],
            [
                "user_id.required"=>"The user field is required"
            ]
        );
        if($request->amount<1000){
            return back()->withErrors(["amount"=>"Transfer Amount at least 1000(MMK)"])->withInput();
        }
        DB::beginTransaction();
        try{
           $user= User::where("id",$request->user_id)->firstOrFail();
           $user->wallets->increment("amount",$request->amount);
           $user->wallets->update();

           $ref_id=UUIDGenerator::refNumber();
           $transcations=new Transcation();
           $transcations->ref_id=$ref_id;
           $transcations->trx_id=UUIDGenerator::trxNumber();
           $transcations->user_id=$user->id;
           $transcations->type=2;
           $transcations->amount=$request->amount;
           $transcations->source_id=0;
            $transcations->description=$request->description;
            DB::commit();
            return redirect()->route("admin.wallet.index")->with("create","successfully reduce amount");
        }catch(Exception $e){
            DB::rollBack();
            return back()->withErrors("fails",$e->getMessage());
        }
    }
    public function reduceAmount(){
        $users=User::orderBy("name")->get();
        return view("backend.wallet.reduceAmount",compact("users"));
    }
    public function reduceAmountStore(Request $request){
      
        $request->validate(
            [
            "user_id"=>"required",
            "amount"=>"required|integer"
            ],
            [
                "user_id.required"=>"The user field is required"
            ]
        );
        
        if($request->amount<1000){
            return back()->withErrors(["amount"=>"Transfer Amount at least 1000(MMK)"])->withInput();
        }
       
        DB::beginTransaction();
        try{
           $user= User::where("id",$request->user_id)->firstOrFail();
           if($user->wallets->amount < $request->amount){
            throw new Exception("The amount is greater than wallet balance");
           }
           $user->wallets->decrement("amount",$request->amount);
           $user->wallets->update();

           $ref_id=UUIDGenerator::refNumber();
           $transcations=new Transcation();
           $transcations->ref_id=$ref_id;
           $transcations->trx_id=UUIDGenerator::trxNumber();
           $transcations->user_id=$user->id;
           $transcations->type=2;
           $transcations->amount=$request->amount;
           $transcations->source_id=0;
            $transcations->description=$request->description;
            DB::commit();
            return redirect()->route("admin.wallet.index")->with("create","successfully reduce amount");
        }catch(Exception $e){
            DB::rollBack();
            return back()->withErrors(["fail"=>"Something Went Wrong".$e->getMessage()])->withInput();
        }
    }
}
