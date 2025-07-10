<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatePacientesTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'nombre' => ['type' => 'VARCHAR', 'constraint' => 100],
            'apellido' => ['type' => 'VARCHAR', 'constraint' => 100],
            'fecha_nacimiento' => ['type' => 'DATE', 'null' => true],
            'genero' => [
                'type'       => 'ENUM',
                'constraint' => ['masculino', 'femenino', 'otro'],
                'default'    => 'masculino',
            ],
            'dni' => ['type' => 'VARCHAR', 'constraint' => 20, 'unique' => true],
            'telefono' => ['type' => 'VARCHAR', 'constraint' => 20],
            'email' => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],
            'alergias' => ['type' => 'TEXT', 'null' => true],
            'enfermedades_preexistentes' => ['type' => 'TEXT', 'null' => true],
            'fecha_registro' => ['type' => 'DATETIME'],
            'estado' => [
                'type'       => 'ENUM',
                'constraint' => ['activo', 'inactivo'],
                'default'    => 'activo',
            ],
        ]);

        $this->forge->addKey('id', true); // clave primaria
        $this->forge->createTable('pacientes');
    }

    public function down()
    {
        $this->forge->dropTable('pacientes');
    }
}
