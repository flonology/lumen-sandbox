<?php
use Laravel\Lumen\Testing\DatabaseTransactions;


class CreateCredTest extends TestCase
{
    use DatabaseTransactions;


    public function testCanCreateCredItem()
    {
        $api_key = $this->login();

        $this->json('POST', '/user/creds', [
            'cred_item' => $this->getCredItem()
        ], [
            'Authorization' => 'Bearer ' . $api_key
        ]);

        $this->seeStatusCode(201);
        $created_id = json_decode($this->response->content())->data->id;

        $this->seeInDatabase('creds', [
            'id' => $created_id,
            'cred_item' => $this->getCredItem()
        ]);
    }


    private function login(): string
    {
        $this->json('POST', '/login', [
            'username' => 'John Doe',
            'password' => 'Johns Secret Password'
        ]);

        $this->seeStatusCode(201);
        return json_decode($this->response->content());
    }


    private function getCredItem()
    {
        return json_encode([
            'iv' =>'cFHQMtsVull6vfwaExveRw==',
            'v' => 1,
            'iter' => 10000,
            'ks' => 256,
            'ts' => 64,
            'mode' => 'ccm',
            'adata' => '',
            'cipher' => 'aes',
            'salt' => '6LSshmVqEjo=',
            'ct' => 'nPgz7TM+Q/pTAugJ+p65YWi9wQ8rdf8Z89YZaQv8gWCQ1TYKP8vQJ+pdN3lBpxCloMO27syncMbcF8Qe9LTGbuWNIhdm0ffZRI3YsdV9AIcdxUFqk3T4+y0r/O95UW1CVeV5UP79GVFHbXnlnPuKN9qedL0/vpeqta0ywuE6W6sdAl3x7W7J577BMkO094H1JX5rm24BmcU8BGqJq198q5Q8r/klHtQYsHaACguNIM8i40SMrWA7QXXirypmyTZMLPpqYqY8q1lryra1qqJGuVX0wpuAOiKQf5iEYnpH1PzUQilLw4Ba3MvRjVT7J/UCiQrwY4Wei3n+A5R+n1L6FUm4aDmdFNeB8QbgLqrK7Qlu+yncjUDiAY2/TDVsGD+jtflvoUV5GouzMOltiY6+VjyPKNM5eAM47A=='
        ]);
    }
}
