<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Fields extends Migration
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
            'slug' => [
                'type' => 'varchar',
                'constraint' => 150,
            ],
            'field_name' => [
                'type' => 'varchar',
                'constraint' => 128,
            ],
            'field_image' => [
                'type' => 'varchar',
                'constraint' => 128,
            ],
            'rating' => [
                'type' => 'float',
                'null' => true
            ],
            'amount_order' => [
                'type' => 'int',
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
        $this->forge->addKey('arena_id');
        $this->forge->addForeignKey('arena_id', 'arena', 'id', 'NO ACTION', 'CASCADE');
        $this->forge->createTable('fields');
    }

    public function down()
    {
        $this->forge->dropTable('fields', false, true);
    }
}
