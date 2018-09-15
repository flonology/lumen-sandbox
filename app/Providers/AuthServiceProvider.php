<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    public function register()
    {
        //
    }

    public function boot()
    {
        $this->app['auth']->viaRequest('api', function ($request) {
            $bearer_token = $request->bearerToken();

            if ($bearer_token == '') {
                return null;
            }

            return User::where('api_key', $request->bearerToken())->first();
        });
    }
}
