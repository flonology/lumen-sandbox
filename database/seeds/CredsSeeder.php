<?php
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Cred;

class CredsSeeder extends Seeder
{
    public function run()
    {
        $user = User::where('name', 'John Doe')->first();
        $sample_creds = explode(PHP_EOL, file_get_contents(__DIR__ . '/creds.json.txt'));

        /**
         * Password: Johns Encryption Phrase
         */
        foreach ($sample_creds as $sample_cred) {
            if ($sample_cred == '') {
                continue;
            }

            $cred = new Cred([
                'cred_item' => $sample_cred
            ]);

            $cred->user()->associate($user);
            $cred->save();
        }
    }
}
