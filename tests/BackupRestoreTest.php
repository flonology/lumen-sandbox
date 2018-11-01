<?php
use Laravel\Lumen\Testing\DatabaseTransactions;
use App\Models\User;
use App\Models\Token;
use App\Models\Cred;
use Illuminate\Http\UploadedFile;

class BackupRestoreTest extends TestCase
{
    use DatabaseTransactions;


    public function testCanRestoreUploadedBackup()
    {
        $this->json('POST', '/login', [
            'username' => 'John Doe',
            'password' => 'Johns Secret Password'
        ]);

        $this->seeStatusCode(201);
        $api_key = json_decode($this->response->content());

        $deletedCreds = [
            Cred::find(11),
            Cred::find(22),
            Cred::find(77)
        ];

        $deletedCreds[0]->delete();
        $deletedCreds[1]->delete();
        $deletedCreds[2]->delete();

        $file = new UploadedFile(
            __DIR__ . '/../database/seeds/2018_10_21_CredsBackup.json', // path
            '2018_10_21_CredsBackup.json', // original name
            null, // mime type
            null, // error
            true // test
        );

        $this->call(
            'POST',
            '/user/backup/restore',
            [], // parameters,
            [], // cookies,
            [ 'backup_file' => $file ], // files
            [ 'HTTP_Authorization' => 'Bearer ' . $api_key ], // server
            null // content
        );

        $this->seeStatusCode(201);

        $this->seeInDatabase('creds', [
            'user_id' => 1,
            'cred_item' => $deletedCreds[0]->cred_item
        ]);
        $this->seeInDatabase('creds', [
            'user_id' => 1,
            'cred_item' => $deletedCreds[1]->cred_item
        ]);
        $this->seeInDatabase('creds', [
            'user_id' => 1,
            'cred_item' => $deletedCreds[2]->cred_item
        ]);
    }


    public function testValidatesIfValidJsonHasBeenUploaded()
    {
        $this->json('POST', '/login', [
            'username' => 'John Doe',
            'password' => 'Johns Secret Password'
        ]);

        $this->seeStatusCode(201);
        $api_key = json_decode($this->response->content());


        $file = new UploadedFile(
            __DIR__ . '/../database/seeds/2018_11_01_CredsBackupInvalid.json', // path
            '2018_11_012018_11_01_CredsBackupInvalid.json', // original name
            null, // mime type
            null, // error
            true // test
        );

        $this->call(
            'POST',
            '/user/backup/restore',
            [], // parameters,
            [], // cookies,
            [ 'backup_file' => $file ], // files
            [ 'HTTP_Authorization' => 'Bearer ' . $api_key ], // server
            null // content
        );

        $this->seeStatusCode(422);
    }
}
