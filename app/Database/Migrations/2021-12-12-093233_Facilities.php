<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Facilities extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'int',
                'unsigned' => true,
                'constraint' => 11,
                'auto_increment' => true,
            ],
            'facility_name' => [
                'type' => 'varchar',
                'constraint' => 128,
            ],
            'icon' => [
                'type' => 'varchar',
                'constraint' => 128,
                'null' => true
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
        $this->forge->createTable('facilities');
    }

    public function down()
    {
        $this->forge->dropTable('facilities', false, true);
    }
}
