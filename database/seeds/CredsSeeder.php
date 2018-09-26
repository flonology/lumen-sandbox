<?php
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Cred;

class CredsSeeder extends Seeder
{
    public function run()
    {
        $user = User::where('name', 'John Doe')->first();

        $cred = new Cred([
            'cred_item' => $this->getExampleItem()
        ]);

        $cred->user()->associate($user);
        $cred->save();
    }

    /**
     * Password: Johns Encryption Phrase
     */
    private function getExampleItem()
    {
return <<<EXAMPLE
{
    "iv":"hs5g796kL+ru7JhQf7tcJg==",
    "v":1,
    "iter":10000,
    "ks":256,
    "ts":64,
    "mode":"ccm",
    "adata":"",
    "cipher":"aes",
    "salt":"6LSshmVqEjo=",
    "ct":"9yI5LOb3XqBtRE8aJSiHp2X2fMfKtifEZRp+5XtOPwRPpPOYWlESwGI+PEjQgDSWWIib1aKbmCvPITKzPOKez3bmk+O4onxaNLir9B0nvoLwdf4D7mBZy7YGmJTbQAO9Q1j8agvR/5wx3JfaDTX1g9qKofvYrgkzVjNMnCOiGJ7h14v+Lb5jpbs+1GIScYo6d09cJsNytdP0dKjQgiJVUqH88lR+Bvw113vnMXL87vc9L1GWwPGIzmg6CLDKk370mdjU3cOIYbT07dBh7e2tFsuaHOVytsK5TSr/jI3pxTEA"
}
EXAMPLE;
    }
}
