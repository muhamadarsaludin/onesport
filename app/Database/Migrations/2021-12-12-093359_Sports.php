<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Sports extends Migration
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
            'slug' => [
                'type' => 'varchar',
                'constraint' => 150,
            ],
            'sport_name' => [
                'type' => 'varchar',
                'constraint' => 128,
            ],
            'sport_icon' => [
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
        $this->forge->createTable('sports');
    }

    public function down()
    {
        $this->forge->dropTable('sports', false, true);
    }
}
