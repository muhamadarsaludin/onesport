<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class ArenaFacilities extends Migration
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
            'facility_id' => [
                'type' => 'int',
                'constraint' => 11,
                'unsigned' => true,
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
        $this->forge->addKey('facility_id');
        // $this->forge->addForeignKey('arena_id', 'arena', 'id', 'CASCADE', 'CASCADE');
        // $this->forge->addForeignKey('facility_id', 'facilities', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('arena_facilities');
    }

    public function down()
    {
        $this->forge->dropTable('arena_facilities', false, true);
    }
}
