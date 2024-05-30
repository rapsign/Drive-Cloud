<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddFolderPath extends Migration
{
    public function up()
    {
        $this->forge->addColumn('folders', [
            'folder_path' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'after' => 'slug', // Letakkan kolom setelah kolom 'slug'
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('folders', 'folder_path');
    }
}
