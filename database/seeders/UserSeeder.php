<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

/**
 * UserSeeder
 *
 * Crea el usuario administrador por defecto.
 * Las credenciales se leen desde el .env para no quedar
 * expuestas en el código fuente.
 *
 * Variables requeridas en .env:
 *   ADMIN_NAME=Administrador
 *   ADMIN_EMAIL=admin@ejemplo.com
 *   ADMIN_PASSWORD=su_clave_segura
 *
 * Comportamiento:
 *   - Si el usuario ya existe (por email) → lo omite sin error
 *   - Si no existe → lo crea y le asigna el rol 'administrador'
 *   - Requiere que RoleSeeder se haya ejecutado antes
 */
class UserSeeder extends Seeder
{
    public function run(): void
    {
        $email = env('ADMIN_EMAIL', 'admin@example.com');
        $name  = env('ADMIN_NAME',  'Administrador');
        $pass  = env('ADMIN_PASSWORD', 'password');

        // Verificar si ya existe
        $existe = DB::table('users')->where('email', $email)->exists();

        if ($existe) {
            $this->command->info("UserSeeder omitido — el usuario '$email' ya existe.");
            return;
        }

        // Crear usuario
        $userId = DB::table('users')->insertGetId([
            'name'              => $name,
            'email'             => $email,
            'password'          => Hash::make($pass),
            'activo'            => true,
            'email_verified_at' => Carbon::now(),
            'created_at'        => Carbon::now(),
            'updated_at'        => Carbon::now(),
        ]);

        // Asignar rol administrador
        // Usa la tabla model_has_roles de Spatie directamente
        // para evitar dependencia del modelo User en el seeder
        $roleId = DB::table('roles')->where('name', 'administrador')->value('id');

        if ($roleId) {
            DB::table('model_has_roles')->insert([
                'role_id'    => $roleId,
                'model_type' => 'App\\Models\\User',
                'model_id'   => $userId,
            ]);
            $this->command->info("Usuario '$email' creado con rol 'administrador'.");
        } else {
            $this->command->warn("Usuario creado pero rol 'administrador' no encontrado.");
            $this->command->warn("Ejecute: php artisan tinker --execute=\"App\\Models\\User::first()?->assignRole('administrador');\"");
        }
    }
}
