<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\User;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        $this->validate($request, [
            'username' => 'required|string',
            'password' => 'required|string'
        ]);

        $user = User::where('name', $request->input('username'))->first();
        if ($user == null) {
            return $this->notFoundResponse();
        }

        if (app('hash')->check($request->input('password'), $user->password)) {
            return response()->json($user->api_key, 201);
        }

        return $this->notFoundResponse();
    }


    private function notFoundResponse()
    {
        return response()->json('Invalid credentials', 404);
    }
}
