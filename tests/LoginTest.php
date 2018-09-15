<?php
class LoginTest extends TestCase
{
    public function testCanLoginAndCallUserAreaWithApiKey()
    {
        $this->json('POST', '/login', [
            'username' => 'John Doe',
            'password' => 'Johns Secret Password'
        ]);

        $this->seeStatusCode(201);
        $api_key = json_decode($this->response->content());

        $this->json('GET', 'user/creds', [], [
            'Authorization' => 'Bearer ' . $api_key
        ]);

        $this->seeStatusCode(200);
    }


    public function testCannotGetCredsWithoutValidApiKey()
    {
        $this->json('GET', 'user/creds', [], [
            'Authorization' => 'Bearer ' . 'Some Invalid Key'
        ]);

        $this->seeStatusCode(401);
    }
}
