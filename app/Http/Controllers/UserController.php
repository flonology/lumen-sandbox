<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function deleteAccount(Request $request)
    {
        $user = app('auth')->user();

        $user->tokens()->delete();
        $user->creds()->delete();
        $user->delete();

        return response()->json('Account deleted');
    }
}
