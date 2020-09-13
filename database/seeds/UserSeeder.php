<?php

use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        do {
            $apiKey = Str::random();
        } while (User::where('api_key', $apiKey)->first() instanceof User);

        User::updateOrCreate([
            'name' => 'admin',
            'email' => 'admin@mail.com'
        ], [
            'password' => bcrypt('123123'),
            'api_key' => $apiKey
        ]);
    }
}
