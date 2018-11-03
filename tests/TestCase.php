<?php

abstract class TestCase extends Laravel\Lumen\Testing\TestCase
{
    /**
     * Creates the application.
     *
     * @return \Laravel\Lumen\Application
     */
    public function createApplication()
    {
        return require __DIR__.'/../bootstrap/app.php';
    }


    public function login()
    {
        $this->json('POST', '/login', [
            'username' => 'John Doe',
            'password' => 'Johns Secret Password'
        ]);

        $this->seeStatusCode(201);
        return json_decode($this->response->content());
    }
}
