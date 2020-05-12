<?php

use App\Specialty;
use App\User;
use Illuminate\Database\Seeder;

class SpecialtiesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $specialties = [
            'Oftamologia',
            'Pediatria',
            'Neurologia'
        ];
        foreach ($specialties as $key => $specialtyName) {
            $specialty = Specialty::create([
                'name' => $specialtyName,
            ]);

            $specialty->users()->saveMany(
                factory(User::class, 3)->states('doctor')->make()
            );
        }

        //Medico 1
        User::find(3)->specialties()->save($specialty);

    }
}
