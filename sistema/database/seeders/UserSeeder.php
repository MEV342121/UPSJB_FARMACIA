<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;

/**
 * Todos los usuarios de prueba tienen la contraseña "password".
 */
class UserSeeder extends Seeder
{
    public function run(): void
    {
        $roles = Role::pluck('id', 'name');

        $users = [
            ['role' => 'Administrador', 'name' => 'Administrador', 'dni' => '12345678', 'phone' => '987654321', 'tuition' => null, 'email' => 'admin@sanjuan.com'],
            ['role' => 'Químico farmacéutico', 'name' => 'Rosa Quispe Huamán', 'dni' => '45678912', 'phone' => '912345678', 'tuition' => 'CQFP-04521', 'email' => 'rquispe@sanjuan.com'],
            ['role' => 'Cajero', 'name' => 'Carlos Mendoza Ríos', 'dni' => '70123456', 'phone' => '956123478', 'tuition' => null, 'email' => 'cmendoza@sanjuan.com'],
            ['role' => 'Cajero', 'name' => 'Lucía Torres Salazar', 'dni' => '72345618', 'phone' => '945612378', 'tuition' => null, 'email' => 'ltorres@sanjuan.com'],
        ];

        foreach ($users as $user) {
            User::create([
                'role_id' => $roles[$user['role']],
                'name' => $user['name'],
                'dni' => $user['dni'],
                'phone' => $user['phone'],
                'tuition' => $user['tuition'],
                'email' => $user['email'],
                'password' => 'password',
            ]);
        }
    }
}
