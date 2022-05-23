<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class FieldSpecifications extends Migration
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
            'field_id' => [
                'type' => 'int',
                'unsigned' => true,
                'constraint' => 11,
            ],
            'spec_id' => [
                'type' => 'int',
                'unsigned' => true,
            ],
            'value' => [
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
        $this->forge->addKey('field_id');
        $this->forge->addKey('spec_id');
        // $this->forge->addForeignKey('field_id', 'fields', 'id', 'CASCADE', 'CASCADE');
        // $this->forge->addForeignKey('spec_id', 'spesifications', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('field_specifications');
    }

    public function down()
    {
        $this->forge->dropTable('fied_spesifications', false, true);
    }
}
