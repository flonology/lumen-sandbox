<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\User;

class RegisterController extends Controller
{
    public function register(Request $request)
    {
        $this->validate($request, [
            'username' => 'required|string',
            'password' => 'required|string'
        ]);

        $user = User::where('name', $request->input('username'))->first();
        if ($user) {
            return response()->json('Username already taken', 409);
        }

        $user = new User(['name' => $request->input('username')]);
        $user->password = app('hash')->make($request->input('password'));
        $user->api_key = str_random(63);
        $user->save();

        return response()->json('Registration successful', 201);
    }
}
