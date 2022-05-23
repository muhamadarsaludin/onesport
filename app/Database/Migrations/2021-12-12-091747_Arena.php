<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Arena extends Migration
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
            'venue_id' => [
                'type' => 'int',
                'constraint' => 11,
                'unsigned' => true,
            ],
            'sport_id' => [
                'type' => 'int',
                'constraint' => 11,
                'unsigned' => true,
            ],
            'slug' => [
                'type' => 'varchar',
                'constraint' => 150,
            ],
            'arena_image' => [
                'type' => 'varchar',
                'constraint' => 128,
            ],
            'rating' => [
                'type' => 'float',
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
        $this->forge->addKey('venue_id');
        $this->forge->addKey('sport_id');
        // $this->forge->addForeignKey('venue_id', 'venue', 'id', 'NO ACTION', 'CASCADE');
        // $this->forge->addForeignKey('sport_id', 'sports', 'id', 'NO ACTION', 'CASCADE');
        $this->forge->createTable('arena');
    }

    public function down()
    {
        $this->forge->dropTable('arena', false, true);
    }
}
