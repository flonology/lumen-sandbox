<?php

namespace App\Providers;

use App\Models\User;
use App\Models\Token;
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
            if ($bearer_token) {
                return User::where('api_key', $request->bearerToken())->first();
            }

            return $this->tryOneTimeToken($request);
        });
    }


    private function tryOneTimeToken($request)
    {
        $route = $request->route();

        if (isset($route[2]['token']) === false) {
            return null;
        }

        $token_string = $route[2]['token'];
        $token = Token::where('token', $token_string)->first();

        if ($token == null) {
            return null;
        }

        $user = $token->user()->first();
        Token::where('token', $token_string)->delete();

        return $user;
    }
}
