<?php

use App\User;
use Illuminate\Database\Seeder;

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
            $apiKey = str_random(100);
        } while (User::where('api_key', $apiKey)->first() instanceof User);

        User::updateOrCreate([
            'name' => 'admin',
            'email' => 'admin@mail.com'
        ], [
            'password' => bcrypt('123123')
        ]);
    }
}
