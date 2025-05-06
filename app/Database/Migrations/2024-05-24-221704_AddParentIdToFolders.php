<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddParentIdToFolders extends Migration
{
    public function up()
    {
        $this->forge->addColumn('folders', [
            'parent_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'null' => true,
                'after' => 'slug', // Letakkan kolom setelah kolom 'slug'
            ],
        ]);

        $this->forge->addForeignKey('parent_id', 'folders', 'id', 'CASCADE', 'CASCADE');
    }

    public function down()
    {
        $this->forge->dropForeignKey('folders', 'folders_parent_id_foreign');
        $this->forge->dropColumn('folders', 'parent_id');
    }
}
