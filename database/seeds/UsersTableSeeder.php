<?php

use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        factory(User::class, 20)->create();

        $admin = User::create([
            'firstname' => 'Jesus',
            'secondname' => 'Alex',
            'lastname' => 'Eusse',
            'username' => 'Jneusse',
            'email' => 'jneusse@email.com',
            'email_verified_at' => now(),
            'password' => Hash::make('adminadmin'), // password
            'remember_token' => Str::random(10),
            'created_by' => 1,
            'updated_by' => 1
        ]);
    }
}
