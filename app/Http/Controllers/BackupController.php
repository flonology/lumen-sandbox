<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Date;
use App\Models\Cred;

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
        $this->validate($request, [
            'backup_file' => 'required|file'
        ]);

        // Validate if valid json
        // See http://php.net/manual/en/function.json-last-error.php

        $backup = json_decode(
            file_get_contents($request->file('backup_file')->getPathname())
        );

        $user = app('auth')->user();

        $restored = 0;
        $updated = 0;
        $untouched = 0;

        foreach ($backup as $entry) {
            if (property_exists($entry, 'cred_item') == false) {
                continue;
            }

            $cred = $user->creds()->find($entry->id);
            if ($cred) {
                if ($cred->cred_item != $entry->cred_item) {
                    $cred->cred_item = $entry->cred_item;
                    $cred->save();
                    $updated++;
                } else {
                    $untouched++;
                }
            } else {
                $cred = new Cred();
                $cred->cred_item = $entry->cred_item;
                $cred->user()->associate($user);
                $cred->save();
                $restored++;
            }
        }

        return response()->json([
            'data' => [
                'restored' => $restored,
                'updated' => $updated,
                'untouched' => $untouched
            ]
        ], 201);
    }
}
