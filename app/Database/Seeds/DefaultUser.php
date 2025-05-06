<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class DefaultUser extends Seeder
{
    public function run()
    {
        $data = [
            [
                'username' => 'admin',
                'name' => 'Administrator UIGM',
                'password' => password_hash('admin123', PASSWORD_DEFAULT), // Contoh: enkripsi kata sandi
                'role_id' => 1,
                'created_at' => date('Y-m-d H:i:s'),
            ],
            // Tambahkan data lainnya sesuai kebutuhan
        ];

        // Masukkan data ke dalam tabel users
        $this->db->table('users')->insertBatch($data);
    }
}
