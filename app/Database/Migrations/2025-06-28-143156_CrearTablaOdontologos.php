<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CrearTablaOdontologos extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'user_id' => [
                'type'     => 'INT',
                'unsigned' => true,
            ],
            'nombre' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
            ],
            'apellido' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
            ],
            'cedula' => [
                'type'       => 'VARCHAR',
                'constraint' => 20,
            ],
            'especialidad' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
            ],
            'telefono' => [
                'type'       => 'VARCHAR',
                'constraint' => 20,
                'null'       => true,
            ],
            'direccion' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
            ],
            'genero' => [
                'type'       => 'ENUM',
                'constraint' => ['masculino', 'femenino', 'otros'],
                'default'    => 'masculino',
            ],
            'fecha_nacimiento' => [
                'type' => 'DATE',
                'null' => true,
            ],
            'activo' => [
                'type'    => 'BOOLEAN',
                'default' => true,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('user_id', 'users', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('odontologos');
    }

    public function down()
    {
        $this->forge->dropTable('odontologos');
    }
}
