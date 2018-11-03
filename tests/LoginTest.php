<?php
class LoginTest extends TestCase
{
    public function testCanLoginAndCallUserAreaWithApiKey()
    {
        $api_key = $this->loginAsJohnDoe();

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
