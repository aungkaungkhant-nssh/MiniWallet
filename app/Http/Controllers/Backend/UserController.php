<?php

namespace App\Http\Controllers\Backend;

use App\Helpers\UUIDGenerator;
use App\Http\Controllers\Controller;
use App\Http\Requests\EditUser;
use App\Http\Requests\StoreUser;
use App\Models\AdminUser;
use App\Models\User;
use App\Models\Wallet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Yajra\Datatables\Datatables;
use Jenssegers\Agent\Agent;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Exception;
class UserController extends Controller
{
    public function index(){
        return view("backend.user.index");
    }
    public function create(){
        return view("backend.user.create");
    }
    public function store(StoreUser $request){
        DB::beginTransaction();
        try{
            $admin_users=new User();
            $admin_users->name=$request->name;
            $admin_users->email=$request->email;
            $admin_users->phone=$request->phone;
            $admin_users->password=Hash::make($request->password);
            $admin_users->save();
    
            Wallet::firstOrCreate(
                ["user_id"=>$admin_users->id],
                [
                    "account_number"=>UUIDGenerator::accountNumber(),
                    "amount"=>0
                ]
            );
            DB::commit();
            return redirect()->route("admin.user.index")->with("create","Created Successfully");
        }catch(Exception $e){
            DB::rollBack();
            return back()->withErrors(["fails",$e->getMessage()]);
        }
       

      
    }
    public function ssd(){
        $users=User::query();
        return DataTables::of($users)
        ->addColumn("action",function($user){
            $delete_icon='<a href="" class="text-danger" id="delete"><i class="fas fa-trash" id="delete" data-id='.$user->id.'></i></a>';
           $edit_icon='<a href="'.route("admin.user.edit",$user->id).'" class="text-warning"><i class="fas fa-edit"></i></a>';
           return '<div class="action-icon">'.$edit_icon .$delete_icon.'<div>';
        })
        ->editColumn("user_agent",function($user){
            if($user->user_agent){
             $agent = new Agent();
             $agent->setUserAgent($user->user_agent);
             $device = $agent->device();
             $platform = $agent->platform();
             $browser = $agent->browser();
             return '<table class="table-striped">
                         <tbody>
                             <tr>
                                 <td>'.$device.'</td>
                             </tr>
                             <tr>
                                 <td>'.$platform.'</td>
                             </tr>
                             <tr>
                                 <td>'.$browser.'</td>
                             </tr>
                         </tbody>
                        
                     </table>';
            }
            return "-";
            
         })
         ->editColumn("created_at",function($user){
            return Carbon::parse($user->created_at)->format("Y-m-d H:i:s");
        })
        ->editColumn("updated_at",function($user){
            return Carbon::parse($user->updated_at)->format("Y-m-d H:i:s");
        })
         ->rawColumns(["action","user_agent"])
        ->make(true);
    }
    public function edit($id){
       $user=User::findOrFail($id);
        return view("backend.user.edit",compact("user"));
    }
    public function update(EditUser $request,$id){
        $user=User::findOrFail($id);
        $user->name=$request->name;
        $user->email=$request->email;
        $user->phone=$request->phone;
        $user->password=$request->password?Hash::make($request->password):$user->password;
        $user->save();
        return redirect()->route("admin.user.index")->with("update","Updated Successfully");
    }
    public function destroy($id){
        User::find($id)->delete();
        return "success";
    }
}
