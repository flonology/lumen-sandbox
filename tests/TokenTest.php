<?php
use Laravel\Lumen\Testing\DatabaseTransactions;
use App\Models\User;
use App\Models\Token;

class TokenTest extends TestCase
{
    use DatabaseTransactions;


    public function testCanGenerateToken()
    {
        $api_key = $this->login();

        $this->post('user/token', [], [
            'Authorization' => 'Bearer ' . $api_key
        ]);

        $this->seeStatusCode(201);

        $token = json_decode($this->response->content());
        $this->assertEquals(96, strlen($token));
    }


    public function testCanUseTokenOnlyOneTime()
    {
        $user = User::where('name', 'John Doe')->first();

        $token = new Token(['token' => 'Some One Time Token']);
        $token->user()->associate($user);
        $token->save();

        $this->get("/user/backup/{$token->token}");
        $this->seeStatusCode(200);
        $this->notSeeInDatabase('tokens', ['token' => $token->token]);
    }


    public function testGetUnauthorizedWithoutToken()
    {
        $this->get('/user/backup/someToken');
        $this->seeStatusCode(401);
    }


    private function login()
    {
        $this->json('POST', '/login', [
            'username' => 'John Doe',
            'password' => 'Johns Secret Password'
        ]);

        $this->seeStatusCode(201);

        $api_key = json_decode($this->response->content());
        return $api_key;
    }
}
