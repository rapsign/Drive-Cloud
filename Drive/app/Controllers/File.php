<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\FilesModel;
use CodeIgniter\HTTP\ResponseInterface;

class File extends BaseController
{

    protected $fileModel;

    public function __construct()
    {
        $this->fileModel = new FilesModel();
    }
    public function addFile()
    {
        $files = $this->request->getFiles();

        foreach ($files as $file) {
            // Dapatkan informasi pengguna
            $userId = session()->get('id');
            $username = session()->get('name');

            // Tentukan direktori untuk menyimpan file
            $userDir = FCPATH . '../files/' . $username;

            // Buat direktori jika belum ada
            if (!is_dir($userDir)) {
                mkdir($userDir, 0777, true);
            }

            // Dapatkan nama file asli
            $originalName = $file->getName();

            // Inisialisasi nama file baru
            $newName = $originalName;

            // Periksa apakah file dengan nama yang sama sudah ada
            $counter = 1;
            while (file_exists($userDir . '/' . $newName)) {
                $newName = pathinfo($originalName, PATHINFO_FILENAME) . '_' . $counter . '.' . pathinfo($originalName, PATHINFO_EXTENSION);
                $counter++;
            }

            // Pindahkan file ke direktori dengan nama baru
            $file->move($userDir, $newName);

            // Simpan informasi file ke database
            $this->fileModel->save([
                'user_id' => $userId,
                'file_name' => $newName,
                'file_size' => $file->getSize(),
                'file_type' => $file->getClientMimeType(),
            ]);
        }
    }
}
