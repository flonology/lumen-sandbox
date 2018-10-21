<?php
use Laravel\Lumen\Testing\DatabaseTransactions;
use App\Models\User;
use App\Models\Token;
use Illuminate\Http\UploadedFile;

class BackupRestoreTest extends TestCase
{
    use DatabaseTransactions;


    public function testCanRestoreUploadedBack()
    {
        $this->json('POST', '/login', [
            'username' => 'John Doe',
            'password' => 'Johns Secret Password'
        ]);

        $this->seeStatusCode(201);
        $api_key = json_decode($this->response->content());

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
        $this->markTestIncomplete('Test if entries are really restored or updated');
    }
}
