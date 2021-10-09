<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function index(){
        $user=Auth::guard('web')->user();
        $notifications=$user->notifications()->paginate(5);
        return view("frontend.notifications",compact("notifications"));
    }
    public function details($id){
        $user=Auth::guard('web')->user();
        $notification=$user->notifications()->where("id",$id)->first();
        $notification->markAsRead();
        return view("frontend.notificationsDetails",compact("notification"));
    }
}
