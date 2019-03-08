<?php

use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $gender = ['m','f','o'];
        User::create([
            'first_name' => Str::random(10),
            'last_name' => Str::random(10),
            'email' => Str::random(10).'@gmail.com',
            'user_mobile' => Str::random(10),
            'password' => bcrypt('secret'),
            'gender' => $gender[array_rand($gender)],
        ]);
    }
}
