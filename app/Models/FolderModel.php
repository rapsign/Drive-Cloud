<?php

namespace App\Models;

use CodeIgniter\Model;

class FolderModel extends Model
{
    protected $table            = 'folders';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = true;
    protected $protectFields    = true;
    protected $allowedFields    = ['folder_name', 'user_id', 'slug', 'deleted_at', 'folder_path', 'parent_id'];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected array $casts = [];
    protected array $castHandlers = [];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];

    public function search($keyword, $user_id)
    {
        return $this->where('user_id', $user_id)
            ->like('folder_name', $keyword)
            ->findAll();
    }
    public function getFolderBySlug($slug)
    {
        $folder = $this->where('slug', $slug)->first();
        return $folder;
    }
    public function getFoldersToDelete($folderId)
    {
        $foldersToDelete = [];

        // Get the folder
        $folder = $this->find($folderId);
        if ($folder) {
            $foldersToDelete[] = $folder;

            // Get the subfolders recursively
            $subfolders = $this->where('parent_id', $folderId)->findAll();
            foreach ($subfolders as $subfolder) {
                $foldersToDelete = array_merge($foldersToDelete, $this->getFoldersToDelete($subfolder['id']));
            }
        }

        return $foldersToDelete;
    }
}
