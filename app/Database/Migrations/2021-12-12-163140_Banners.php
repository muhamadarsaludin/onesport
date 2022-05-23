<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Banners extends Migration
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
            'user_id' => [
                'type' => 'int',
                'unsigned' => true,
                'constraint' => 11,
            ],
            'venue_id' => [
                'type' => 'int',
                'unsigned' => true,
                'constraint' => 11,
                'null' => true,
            ],
            'title' => [
                'type' => 'varchar',
                'constraint' => 128,
                'null' => true,
            ],
            'image' => [
                'type' => 'varchar',
                'constraint' => 128,
            ],
            'link' => [
                'type' => 'varchar',
                'constraint' => 255,
                'null' => true,
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
        $this->forge->addKey('user_id');
        $this->forge->addKey('venue_id');
        $this->forge->createTable('banners');
    }

    public function down()
    {
        $this->forge->dropTable('banners', false, true);
    }
}
