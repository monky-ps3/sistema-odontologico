<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

use function PHPSTORM_META\type;

class CrearTablaHorarios extends Migration
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
            'odontologo_id' => [
                'type' => 'int',
                'unsigned' => true,

            ],
            'dia_semana' => [
                'type' => 'ENUM',
                'constraint' => ['lunes', 'martes', 'miercoles', 'jueves', 'sabado', 'domingo']
            ],
            'hora_inicio' => [
                'type' => 'TIME',
            ],
            'hora_fin' => [
                'type' => 'TIME',
            ],
            'activo'       => [
                'type' => 'BOOLEAN',
                'default' => true
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
        $this->forge->addForeignKey('odontologo_id', 'odontologos', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('horarios');
    }

    public function down()
    {
        $this->forge->dropTable('horarios');
    }
}
