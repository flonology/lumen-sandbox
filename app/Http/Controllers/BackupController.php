<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Date;

class BackupController extends Controller
{
    public function downloadBackup(Request $request)
    {
        $user = app('auth')->user();
        $creds = $user->creds()->get();
        $file_name = date('Y_m_d') . '_CredsBackup.json';

        return response($creds, 200, [
           'Content-Type' => 'application/json',
           'Content-Disposition' => "attachment; filename=\"{$file_name}\""
       ]);
    }


    public function restoreBackup(Request $request)
    {
        return response()->json([
            'data' => ['entries_restored' => 3000]
        ], 201);
    }
}
