<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class ArenaImages extends Migration
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
            'arena_id' => [
                'type' => 'int',
                'constraint' => 11,
                'unsigned' => true,
            ],
            'image' => [
                'type' => 'varchar',
                'constraint' => 128,
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
        $this->forge->addKey('arena_id');
        $this->forge->addForeignKey('arena_id', 'arena', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('arena_images');
    }

    public function down()
    {
        $this->forge->dropTable('arena_images', false, true);
    }
}
