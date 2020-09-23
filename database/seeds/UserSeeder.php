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
        $password = Str::random();

        echo "Login: admin" . PHP_EOL;
        echo "Password: $password" . PHP_EOL;

        User::updateOrCreate([
            'name' => 'admin',
            'email' => 'admin@mail.com',
        ], [
            'password' => bcrypt($password),
        ]);
    }
}
