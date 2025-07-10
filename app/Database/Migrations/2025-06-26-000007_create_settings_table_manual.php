<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateSettingsTableManual extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'context' => ['type' => 'varchar', 'constraint' => 255],
            'key'     => ['type' => 'varchar', 'constraint' => 255],
            'value'   => ['type' => 'text', 'null' => true],
        ]);

        $this->forge->addKey(['context', 'key'], true); // UNIQUE KEY
        $this->forge->createTable('settings');
    }

    public function down()
    {
        $this->forge->dropTable('settings');
    }
}
