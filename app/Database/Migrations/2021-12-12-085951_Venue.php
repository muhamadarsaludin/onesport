<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Venue extends Migration
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
                'constraint' => 11,
                'unsigned' => true,
            ],
            'venue_name' => [
                'type' => 'varchar',
                'constraint' => 128,
            ],
            'slug' => [
                'type' => 'varchar',
                'constraint' => 150,
            ],
            'logo' => [
                'type' => 'varchar',
                'constraint' => 128,
            ],
            'level_id' => [
                'type' => 'int',
                'constraint' => 11,
                'unsigned' => true,
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
            'city' => [
                'type' => 'varchar',
                'constraint' => 128,
                'null' => true
            ],
            'province' => [
                'type' => 'varchar',
                'constraint' => 128,
                'null' => true,
            ],
            'postal_code' => [
                'type' => 'varchar',
                'constraint' => 128,
                'null' => true,
            ],
            'address' => [
                'type' => 'text',
                'null' => true,
            ],
            'latitude' => [
                'type' => 'varchar',
                'constraint' => 128,
                'null' => true,
            ],
            'longitude' => [
                'type' => 'varchar',
                'constraint' => 128,
                'null' => true,
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
        $this->forge->addKey('level_id');
        // $this->forge->addForeignKey('level_id', 'venue_levels', 'id', 'CASCADE', 'NO ACTION');
        // $this->forge->addForeignKey('user_id', 'users', 'id', 'CASCADE', 'NO ACTION');
        $this->forge->createTable('venue');
    }

    public function down()
    {
        $this->forge->dropTable('venue', false, true);
    }
}
