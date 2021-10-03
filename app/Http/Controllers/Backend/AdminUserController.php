<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\EditAdminUser;
use App\Http\Requests\StoreAdminUser;
use App\Models\AdminUser;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Yajra\Datatables\Datatables;
use Jenssegers\Agent\Agent;
class AdminUserController extends Controller
{
    public function index(){
       return view("backend.admin_user.index");
    }
    public function ssd(){
        $admin_users=AdminUser::query();
       return DataTables::of($admin_users)
       ->addColumn("action",function($user){
           $delete_icon='<a href="" class="text-danger" id="delete"><i class="fas fa-trash" id="delete" data-id='.$user->id.'></i></a>';
           $edit_icon='<a href="'.route("admin.admin_user.edit",$user->id).'" class="text-warning"><i class="fas fa-edit"></i></a>';
           return '<div class="action-icon">'.$edit_icon .$delete_icon.'<div>';
       })
       ->editColumn("created_at",function($user){
           return Carbon::parse($user->created_at)->format("Y-m-d H:i:s");
       })
       ->editColumn("updated_at",function($user){
           return Carbon::parse($user->updated_at)->format("Y-m-d H:i:s");
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
       ->rawColumns(["action","user_agent"])
       ->make(true);
    }
    public function create(){
        return view("backend.admin_user.create");
    }
    public function store(StoreAdminUser $request){
        $admin_users=new AdminUser();
        $admin_users->name=$request->name;
        $admin_users->email=$request->email;
        $admin_users->phone=$request->phone;
        $admin_users->password=Hash::make($request->password);
        $admin_users->save();
        return redirect()->route("admin.admin_user.index")->with("create","Created Successfully");
    }
    public function edit($id){
         $admin_user=AdminUser::findOrFail($id);
          return view("backend.admin_user.edit",compact("admin_user"));
    }
    public function update(EditAdminUser $request,$id){
     
        $admin_user=AdminUser::findOrFail($id);
        $admin_user->name=$request->name;
        $admin_user->email=$request->email;
        $admin_user->phone=$request->phone;
        $admin_user->password=$request->password?Hash::make($request->password):$admin_user->password;
        $admin_user->save();
        return redirect()->route("admin.admin_user.index")->with("update","Updated Successfully");
    }
    public function destroy($id){
        AdminUser::find($id)->delete();
        return "success";
    }
   
    
}
