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
            'role' => 'admin'
        ]);
        User::create([
            'name' => 'paciente 1',
            'email' => 'patient@prueba.es',
            'password' => bcrypt('prueba'),

            'role' => 'patient'
        ]);
        User::create([
            'name' => 'medico 1',
            'email' => 'doctor@prueba.es',
            'password' => bcrypt('prueba'),
            'role' => 'doctor'
        ]);
        factory(User::class, 50)->states('patient')->create();
    }
}
