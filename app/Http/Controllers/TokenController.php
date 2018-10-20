<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Token;

class TokenController extends Controller
{
    public function createToken(Request $request)
    {
        $user = app('auth')->user();

        $token = new Token(['token' => str_random(96)]);
        $token->user()->associate($user);
        $token->save();

        return response()->json($token->token, 201);
    }


    private function notFoundResponse()
    {
        return response()->json('Invalid credentials', 404);
    }
}
