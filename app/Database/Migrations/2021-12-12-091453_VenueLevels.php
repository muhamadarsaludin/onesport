<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class VenueLevels extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'int',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'level_name' => [
                'type' => 'varchar',
                'constraint' => 128,
            ],
            'description' => [
                'type' => 'text',
                'null' => true
            ],
            'active' => [
                'type' => 'tinyint',
                'constraint' => 1,
                'default' => 1
            ],
            'created_at' => [
                'type' => 'datetime',
                'null' => true
            ],
            'updated_at' => [
                'type' => 'datetime',
                'null' => true
            ],
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->createTable('venue_levels');
    }

    public function down()
    {
        $this->forge->dropTable('venue_levels', false, true);
    }
}
