<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Cred;
use App\Models\User;

class CredsController extends Controller
{
    public function listCreds()
    {
        $user = $this->getUser();

        return response()->json([
            'data' => $user->creds()->get()
        ]);
    }


    public function createCred(Request $request)
    {
        $user = $this->getUser();

        $this->validate($request, [
            'cred_item' => 'required|json'
        ]);

        $cred = new Cred([
            'cred_item' => $request->input('cred_item')
        ]);

        $cred->user()->associate($user);
        $cred->save();

        return response()->json([
            'data' => 'Created'
        ], 201);
    }


    private function getUser(): User
    {
        return app('auth')->user();
    }
}
