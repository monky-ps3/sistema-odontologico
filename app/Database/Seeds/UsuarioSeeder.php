<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use CodeIgniter\Shield\Entities\User;
use CodeIgniter\Shield\Models\UserModel;

class UsuarioSeeder extends Seeder
{
    public function run()
    {
        $db = \Config\Database::connect();
        $userModel = new UserModel();

        // 1. Insertar grupos si no existen
        $groups = [
            ['name' => 'admin', 'description' => 'Administrador'],
            ['name' => 'odontologo', 'description' => 'Odontólogo'],
            ['name' => 'recepcionista', 'description' => 'Recepcionista']
        ];

        foreach ($groups as $group) {
            if (!$db->table('auth_groups')->where('name', $group['name'])->countAllResults()) {
                $db->table('auth_groups')->insert($group);
            }
        }

        // 2. Crear usuarios
        $users = [
            [
                'username' => 'admin',
                'email'    => 'admin@clinica.com',
                'password' => 'Admin1234',
                'group'    => 'admin'
            ],
            [
                'username' => 'dr_perez',
                'email'    => 'perez@clinica.com',
                'password' => 'Odonto123',
                'group'    => 'odontologo'
            ]
        ];

        foreach ($users as $userData) {
            // Verificar si el usuario ya existe por username
            if (!$userModel->where('username', $userData['username'])->first()) {
                $user = new User([
                    'username' => $userData['username'],
                    'password' => $userData['password']
                ]);
                $userModel->save($user);

                $userId = $userModel->getInsertID();

                // Verificar si la identidad ya existe antes de insertar
                if (!$db->table('auth_identities')
                    ->where('user_id', $userId)
                    ->where('type', 'email_password')
                    ->countAllResults()) {
                    
                    $db->table('auth_identities')->insert([
                        'user_id' => $userId,
                        'type'    => 'email_password',
                        'secret'  => $userData['email'],
                        'secret2' => password_hash($userData['password'], PASSWORD_DEFAULT),
                        'created_at' => date('Y-m-d H:i:s')
                    ]);
                }

                // Asignar grupo si no está asignado
                if (!$db->table('auth_groups_users')
                    ->where('user_id', $userId)
                    ->where('group', $userData['group'])
                    ->countAllResults()) {
                    
                    $db->table('auth_groups_users')->insert([
                        'user_id'    => $userId,
                        'group'      => $userData['group'],
                        'created_at' => date('Y-m-d H:i:s')
                    ]);
                }
            }
        }

        echo "✅ Seeder ejecutado correctamente. Usuarios:\n";
        echo "- admin@clinica.com (Admin1234)\n";
        echo "- perez@clinica.com (Odonto123)\n";
    }
}