<?php
use Laravel\Lumen\Testing\DatabaseTransactions;


class UpdateCredTest extends TestCase
{
    use DatabaseTransactions;


    public function testCanUpdateCredItem()
    {
        $api_key = $this->loginAsJohnDoe();

        $this->json('PUT', '/user/creds/1', [
            'cred_item' => $this->getCredItem()
        ], [
            'Authorization' => 'Bearer ' . $api_key
        ]);

        $this->seeStatusCode(200);
        $this->seeInDatabase('creds', [
            'user_id' => 1,
            'cred_item' => $this->getCredItem()
        ]);
    }


    public function testCannotUpdateItemOfAnotherUser()
    {
        $api_key = $this->loginAsJaneDoe();

        $this->json('PUT', '/user/creds/1', [
            'cred_item' => $this->getCredItem()
        ], [
            'Authorization' => 'Bearer ' . $api_key
        ]);

        $this->seeStatusCode(404);
        $this->notSeeInDatabase('creds', [
            'user_id' => 1,
            'cred_item' => $this->getCredItem()
        ]);
    }


    private function getCredItem()
    {
        return json_encode([
            'iv' =>'4j+7wv7REUE5TvQauLnDgA==',
            'v' => 1,
            'iter' => 10000,
            'ks' => 256,
            'ts' => 64,
            'mode' => 'ccm',
            'adata' => '',
            'cipher' => 'aes',
            'salt' => 'EwDCxRoOh10=',
            'ct' => 'DFsLSy5yHKRbAkIR7Hn61Nsasw=='
        ]);
    }
}
