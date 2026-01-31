<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;

class RolesAndUsersSeeder extends Seeder
{
    public function run(): void
    {
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $receptionRole = Role::firstOrCreate(['name' => 'receptionist']);
        $dentistRole = Role::firstOrCreate(['name' => 'dentist']);
        $patientRole = Role::firstOrCreate(['name' => 'patient']);

        $admin = User::firstOrCreate(
            ['email' => 'admin@clinic.test'],
            ['name' => 'Admin', 'password' => Hash::make('Password123!')]
        );
        $admin->syncRoles([$adminRole]);

        $reception = User::firstOrCreate(
            ['email' => 'reception@clinic.test'],
            ['name' => 'Reception', 'password' => Hash::make('Password123!')]
        );
        $reception->syncRoles([$receptionRole]);

        $dentist1 = User::firstOrCreate(
            ['email' => 'dentist1@clinic.test'],
            ['name' => 'Dentist One', 'password' => Hash::make('Password123!')]
        );
        $dentist1->syncRoles([$dentistRole]);

        $patient = User::firstOrCreate(
            ['email' => 'patient@clinic.test'],
            ['name' => 'Patient', 'password' => Hash::make('Password123!')]
        );
        $patient->syncRoles([$patientRole]);
    }
}
