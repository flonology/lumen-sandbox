<?php
use Laravel\Lumen\Testing\DatabaseTransactions;


class TokenTest extends TestCase
{
    use DatabaseTransactions;

    public function testCanLoginAndCallUserAreaWithApiKey()
    {
        $this->json('POST', '/login', [
            'username' => 'John Doe',
            'password' => 'Johns Secret Password'
        ]);

        $this->seeStatusCode(201);
        $api_key = json_decode($this->response->content());

        $this->json('POST', 'user/token', [], [
            'Authorization' => 'Bearer ' . $api_key
        ]);

        $this->seeStatusCode(201);
        $token = json_decode($this->response->content());
        $this->assertEquals(96, strlen($token));
    }
}
