<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        $roles = [
            ['name' => 'Administrador', 'description' => 'Acceso total al sistema'],
            ['name' => 'Químico farmacéutico', 'description' => 'Registra ventas y controla el stock'],
            ['name' => 'Cajero', 'description' => 'Registra ventas'],
        ];

        foreach ($roles as $role) {
            Role::create($role);
        }
    }
}
