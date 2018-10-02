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
            'data' => ['id' => $cred->id]
        ], 201);
    }


    public function updateCred(Request $request, $id)
    {
        $user = $this->getUser();

        $this->validate($request, [
            'cred_item' => 'required|json'
        ]);

        $cred = Cred::findOrFail($id);
        $cred->fill([
            'cred_item' => $request->input('cred_item')
        ]);

        $cred->save();

        return response()->json([
            'data' => ['id' => $cred->id]
        ], 200);
    }


    private function getUser(): User
    {
        return app('auth')->user();
    }
}
