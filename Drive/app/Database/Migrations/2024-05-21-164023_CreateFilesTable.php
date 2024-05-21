<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateFilesTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'file_name' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
            ],
            'file_size' => [
                'type' => 'BIGINT',
                'unsigned' => true,
            ],
            'file_type' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
            ],
            'folder_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
            ],
            'user_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'deleted_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('folder_id', 'folders', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('user_id', 'users', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('files');
    }

    public function down()
    {
        $this->forge->dropTable('files');
    }
}
