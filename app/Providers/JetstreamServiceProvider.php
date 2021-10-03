<?php

namespace App\Providers;

use App\Actions\Jetstream\DeleteUser;
use App\Models\AdminUser;
use App\Models\User;
use Illuminate\Support\ServiceProvider;
use Laravel\Jetstream\Jetstream;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Laravel\Fortify\Fortify;
class JetstreamServiceProvider extends ServiceProvider
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
        $this->configurePermissions();

        Jetstream::deleteUsersUsing(DeleteUser::class);
        Fortify::authenticateUsing(function (Request $request) {
            $user = User::where('email', $request->email)
                 ->first();
    
            if ($user &&
                Hash::check($request->password, $user->password)) {
                User::where('email', $request->email)->update(
                    ["ip"=>$request->ip(),
                    "user_agent"=>$request->server("HTTP_USER_AGENT"),
                    "login_at"=>date("Y-m-d H:i:s")
                    ]
                    );
                return $user;
            }
        });
    }

    /**
     * Configure the permissions that are available within the application.
     *
     * @return void
     */
    protected function configurePermissions()
    {
        Jetstream::defaultApiTokenPermissions(['read']);

        Jetstream::permissions([
            'create',
            'read',
            'update',
            'delete',
        ]);
    }
}
