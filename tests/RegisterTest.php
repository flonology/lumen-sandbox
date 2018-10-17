<?php
use Laravel\Lumen\Testing\DatabaseTransactions;


class RegisterTest extends TestCase
{
    use DatabaseTransactions;


    public function testCanRegisterNewUser()
    {
        $this->post('/register', [
            'username' => 'New User',
            'password' => 'My Nice Password'
        ]);

        $this->seeStatusCode(201);
        $this->seeInDatabase('users', [ 'name' => 'New User']);
    }


    public function testCannotRegisterSameUserTwice()
    {
        $this->post('/register', [
            'username' => 'New User',
            'password' => 'My Nice Password'
        ]);

        $this->seeStatusCode(201);

        $this->post('/register', [
            'username' => 'New User',
            'password' => 'My Nice Password'
        ]);

        $this->seeStatusCode(409);
    }


    public function testMustProvideUsernameAndPassword()
    {
        $this->post('/register', [
            'foo' => 'bar',
            'bar' => 'baz'
        ]);

        $this->seeStatusCode(422);
        $this->seeJsonStructure([
            'username',
            'password'
        ]);
    }
}
