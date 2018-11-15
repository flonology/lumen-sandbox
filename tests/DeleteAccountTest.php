<?php
use Laravel\Lumen\Testing\DatabaseTransactions;
use App\Models\User;
use App\Models\Cred;
use App\Models\Token;

class DeleteAccountTest extends TestCase
{
    use DatabaseTransactions;


    public function testUserCanDeleteAccount()
    {
        $user = User::where('name', 'John Doe')->first();

        $user_id = $user->id;
        $api_key = $this->login($user);

        $this->json('DELETE', '/user/account', [] /* data */, [
            'Authorization' => 'Bearer ' . $api_key
        ]);

        $this->assertNull(User::find($user_id));
        $this->assertNull(Cred::where('user_id', $user_id)->first());
        $this->assertNull(Token::where('user_id', $user_id)->first());
    }


    private function login(User $user): string
    {
        $this->json('POST', '/login', [
            'username' => $user->name,
            'password' => 'Johns Secret Password'
        ]);

        $this->seeStatusCode(201);
        return json_decode($this->response->content());
    }
}
