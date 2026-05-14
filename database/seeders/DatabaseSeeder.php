<?php

namespace Database\Seeders;

use App\Models\Curso;
use App\Models\Materia;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Roles
        $adminRole      = Role::firstOrCreate(['name' => 'admin',      'guard_name' => 'web']);
        $profesorRole   = Role::firstOrCreate(['name' => 'profesor',   'guard_name' => 'web']);
        $estudianteRole = Role::firstOrCreate(['name' => 'estudiante', 'guard_name' => 'web']);

        // Permisos básicos
        $permisos = [
            'usuarios.ver', 'usuarios.crear', 'usuarios.editar', 'usuarios.eliminar',
            'cursos.ver', 'cursos.crear', 'cursos.editar', 'cursos.eliminar',
            'perfil.editar',
        ];

        foreach ($permisos as $permiso) {
            Permission::firstOrCreate(['name' => $permiso, 'guard_name' => 'web']);
        }

        // Asignar permisos a roles
        $adminRole->syncPermissions($permisos);
        $profesorRole->syncPermissions(['usuarios.ver', 'perfil.editar', 'cursos.ver']);
        $estudianteRole->syncPermissions(['perfil.editar']);

        // Cursos de ejemplo
        $cursos = ['1er Grado', '2do Grado', '3er Grado', '4to Grado', '5to Grado', '6to Grado'];
        foreach ($cursos as $nombre) {
            Curso::firstOrCreate(['nombre' => $nombre], ['descripcion' => null, 'activo' => true]);
        }

        // Materias de ejemplo
        $materias = [
            'Matemáticas', 'Español', 'Ciencias Naturales', 'Historia',
            'Geografía', 'Ética y Valores', 'Educación Física', 'Arte',
            'Inglés', 'Física', 'Química',
        ];
        foreach ($materias as $nombre) {
            Materia::firstOrCreate(['nombre' => $nombre]);
        }

        // Usuario administrador
        $admin = User::firstOrCreate(
            ['email' => 'admin@school.com'],
            [
                'name'     => 'Administrador',
                'password' => Hash::make('Admin@1234'),
            ]
        );
        $admin->syncRoles($adminRole);
    }
}
