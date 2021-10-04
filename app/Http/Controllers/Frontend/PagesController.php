<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PagesController extends Controller
{
    public function home(){
        $user=Auth::guard("web")->user();
        return view("frontend.home",compact("user"));
    }
}
