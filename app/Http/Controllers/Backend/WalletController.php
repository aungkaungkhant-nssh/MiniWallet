<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Wallet;
use Carbon\Carbon;
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
}
