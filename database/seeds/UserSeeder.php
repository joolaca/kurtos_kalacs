<?php

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
        \App\User::create([
            'user_name' => 'laca',
            'email' => 'laca',
            'password' => Hash::make('laca123')
        ]);
        \App\User::create([
            'user_name' => 'kkalacs',
            'email' => 'kkalacs',
            'password' => Hash::make('kkalacs123')
        ]);
        \App\User::create([
            'user_name' => 'root',
            'email' => 'root',
            'password' => Hash::make('root')
        ]);
    }
}
