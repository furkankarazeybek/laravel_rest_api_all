<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('TRUNCATE TABLE users');

        DB::table('users')->insert([
           'name' => 'admin',
           'email' => 'admin@laravelapi.test',
           'email_verified_at' => now(),
           'created_at' => now(),
           'updated_at' => now(),
           'password' => bcrypt(123),
           'first_name' => "Furkan",
           'last_name' => "Soyad",
           'remember_token' => Str::random(10),
           'api_token' => Str::random(60)
        ]);
        
    }
}
