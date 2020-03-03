<?php

use Illuminate\Database\Seeder;
use App\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
        'name' => 'Ramon gonzalez',
        'email' => 'ramon@prueba.es',
        'password' => bcrypt('prueba'),
        'dni' => '75432158',
        'address' => '',
        'phone' => '',
        'role' => 'admin'
        ]);
        factory(User::class, 50)->create();
    }
}
