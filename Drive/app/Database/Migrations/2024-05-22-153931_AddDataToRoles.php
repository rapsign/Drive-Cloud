<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddDataToRoles extends Migration
{
    public function up()
    {
        $data = [
            [
                'role' => 'Admin',
            ],
            [
                'role' => 'User',
            ],
        ];
        $this->db->table('roles')->insertBatch($data);
    }

    public function down()
    {
        $this->db->table('roles')->where('role', 'Admin')->delete();
        $this->db->table('roles')->where('role', 'User')->delete();
    }
}
