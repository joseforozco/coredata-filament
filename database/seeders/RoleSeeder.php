<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        // Roles base
        $roles = ['administrador', 'auxiliar', 'contador', 'vendedor'];
        foreach ($roles as $role) {
            Role::firstOrCreate(['name' => $role]);
        }

        // Permisos base
        $permisos = [
            'acceder dashboard',
            'ver usuarios', 'crear usuarios', 'editar usuarios', 'eliminar usuarios',
        ];
        foreach ($permisos as $permiso) {
            Permission::firstOrCreate(['name' => $permiso]);
        }

        // Administrador tiene todos los permisos
        Role::findByName('administrador')->givePermissionTo($permisos);

        // Auxiliar y Contador solo acceden al dashboard
        Role::findByName('auxiliar')->givePermissionTo('acceder dashboard');
        Role::findByName('contador')->givePermissionTo('acceder dashboard');
    }
}