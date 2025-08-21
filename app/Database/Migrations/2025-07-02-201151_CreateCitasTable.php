<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateCitasTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'          => [
                'type'           => 'INT',
                'constraint'     => 9,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'paciente_id' => [
                'type'     => 'INT',
                'unsigned' => true,
            ],
            'odontologo_id' => [
                'type'     => 'INT',
                'unsigned' => true,
            ],
            'fecha' => ['type' => 'DATE'],
            'hora'  => ['type' => 'TIME'],
            'motivo' => ['type' => 'TEXT', 'null' => true],
            'estado' => [
                'type'       => 'ENUM',
                'constraint' => ['pendiente', 'confirmada', 'cancelada', 'realizada'],
                'default'    => 'pendiente',
            ],
            'diagnostico' => [
                'type' => 'TEXT',
                'null' => true,
                'after' => 'motivo'
            ],
            'observaciones' => [
                'type' => 'TEXT',
                'null' => true,
                'after' => 'diagnostico',
            ],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
            'updated_at' => ['type' => 'DATETIME', 'null' => true],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('paciente_id', 'pacientes', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('odontologo_id', 'odontologos', 'id', 'CASCADE', 'CASCADE');

        $this->forge->createTable('citas');
    }

    public function down()
    {
        $this->forge->dropTable('citas');
    }
}
