<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;


class BackupController extends Controller
{
    public function downloadBackup(Request $request)
    {
        $user = app('auth')->user();

        return response()->json([
            'data' => 'This is backup'
        ]);
    }
}
