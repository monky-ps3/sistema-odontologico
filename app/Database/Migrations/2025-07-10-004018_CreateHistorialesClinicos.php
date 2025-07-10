<?php
namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateHistorialClinico extends Migration
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
            'cita_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'receta_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => true,
            ],
            'diagnostico' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'tratamiento' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'observaciones' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'created_at' => [
                'type'    => 'DATETIME',
                'null'    => true,
            ],
            'updated_at' => [
                'type'    => 'DATETIME',
                'null'    => true,
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('cita_id', 'citas', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('receta_id', 'recetas', 'id', 'SET NULL', 'CASCADE');
        $this->forge->createTable('historial_clinico');
    }

    public function down()
    {
        $this->forge->dropTable('historial_clinico');
    }
}
