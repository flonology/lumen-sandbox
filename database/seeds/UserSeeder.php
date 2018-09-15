<?php
use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run()
    {
        $user = new User(['name' => 'John Doe']);
        $user->password = app('hash')->make('Johns Secret Password');
        $user->api_key = str_random(63);
        $user->save();

        $user = new User(['name' => 'Jane Doe']);
        $user->password = app('hash')->make('Janes Secret Password');
        $user->api_key = str_random(63);
        $user->save();
    }
}
