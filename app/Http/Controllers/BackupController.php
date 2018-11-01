<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Date;
use App\Models\Cred;
use App\Models\User;

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

        $backup = json_decode(
            file_get_contents($request->file('backup_file')->getPathname())
        );

        if (json_last_error() !== JSON_ERROR_NONE) {
            return response()->json([
                'data' => 'Could not decode backup file (valid JSON expected)'
            ], 422);
        }

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
                if ($this->updateIfContentsDiffer($cred, $entry)) {
                    $updated++;
                } else {
                    $untouched++;
                }
            } else {
                $this->recreateCred($user, $entry);
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


    private function recreateCred(User $user, \stdClass $entry)
    {
        $cred = new Cred();
        $cred->cred_item = $entry->cred_item;
        $cred->user()->associate($user);
        $cred->save();
    }


    private function updateIfContentsDiffer(Cred $cred, \stdClass $entry)
    {
        if ($cred->cred_item == $entry->cred_item) {
            return false;
        }

        $cred->cred_item = $entry->cred_item;
        $cred->save();

        return true;
    }
}
