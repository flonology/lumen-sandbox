<?php
use Laravel\Lumen\Testing\DatabaseTransactions;


class DeleteCredTest extends TestCase
{
    use DatabaseTransactions;


    public function testCanDeleteCredItem()
    {
        $api_key = $this->login();

        $this->json('DELETE', '/user/creds/1', [], [
            'Authorization' => 'Bearer ' . $api_key
        ]);

        $this->seeStatusCode(200);
        $this->notSeeInDatabase('creds', [
            'id' => 1,
            'user_id' => 1
        ]);
    }
}
