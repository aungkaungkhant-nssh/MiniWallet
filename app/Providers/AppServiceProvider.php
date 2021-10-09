<?php

namespace App\Providers;


use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Paginator::useBootstrap();
        View::composer("*",function($view){
            $unread_notifications=0;
            if(auth()->guard('web')->check()){
               $unread_notifications=Auth::guard('web')->user()->unreadNotifications->count();
            }
            $view->with("unread_notifications",$unread_notifications);
        });
    }
}
