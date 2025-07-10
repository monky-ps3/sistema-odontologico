<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use CodeIgniter\Shield\Entities\User;
use CodeIgniter\Shield\Models\UserModel;
use CodeIgniter\Shield\Models\GroupModel;

class UsuarioSeeder extends Seeder
{
    public function run()
    {
        $groupModel = new GroupModel();
        $userModel  = new UserModel();

        // Crear grupos si no existen
        $grupos = [
            'admin' => 'Administrador del sistema',
            'asistente' => 'Asistente dental',
            'odontologo' => 'Odontólogo del sistema',
        ];

        foreach ($grupos as $name => $description) {
            if (! $groupModel->findByName($name)) {
                $groupModel->addGroup($name, $description);
            }
        }

        // Crear usuarios y asignar grupo
        $usuarios = [
            [
                'username' => 'admin',
                'email'    => 'admin@admin.com',
                'password' => '12345678',
                'grupo'    => 'admin',
            ],
            [
                'username' => 'asistente',
                'email'    => 'asistente@admin.com',
                'password' => '12345678',
                'grupo'    => 'asistente',
            ],
            [
                'username' => 'odontologo',
                'email'    => 'odontologo@admin.com',
                'password' => '12345678',
                'grupo'    => 'odontologo',
            ],
        ];

        foreach ($usuarios as $u) {
            // Verificar si ya existe por email
            if (! $userModel->where('secret', $u['email'])->first()) {
                $user = new User([
                    'username' => $u['username'],
                    'email'    => $u['email'],
                    'password' => $u['password'],
                ]);

                $userModel->save($user);

                // Obtener usuario recién creado
                $user = $userModel->findById($userModel->getInsertID());

                // Asignar grupo
                $user->addGroup($u['grupo']);
            }
        }
    }
}
