<?php
use Laravel\Lumen\Testing\DatabaseTransactions;
use App\Models\User;
use App\Models\Token;

class TokenTest extends TestCase
{
    use DatabaseTransactions;


    public function testCanGenerateToken()
    {
        $api_key = $this->loginAsJohnDoe();

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
        $token = $this->createUserToken($user, 'Some One Time Token');

        $this->get("/user/backup/{$token->token}");
        $this->seeStatusCode(200);
        $this->notSeeInDatabase('tokens', ['token' => $token->token]);
    }


    public function testRemovesAllTokensOfTheUserWhenSuccessful()
    {
        $user = User::where('name', 'John Doe')->first();

        $someToken = $this->createUserToken($user, 'Some One Time Token');
        $otherToken = $this->createUserToken($user, 'Some Other Token');

        $this->get("/user/backup/{$someToken->token}");
        $this->seeStatusCode(200);

        $this->notSeeInDatabase('tokens', ['token' => $someToken->token]);
        $this->notSeeInDatabase('tokens', ['token' => $otherToken->token]);
    }


    public function testGetUnauthorizedWithoutToken()
    {
        $this->get('/user/backup/someToken');
        $this->seeStatusCode(401);
    }


    private function createUserToken(User $user, string $token): Token
    {
        $token = new Token(['token' => $token]);
        $token->user()->associate($user);
        $token->save();

        return $token;
    }
}
