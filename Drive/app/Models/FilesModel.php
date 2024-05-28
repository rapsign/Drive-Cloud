<?php

namespace App\Models;

use CodeIgniter\Model;

class FilesModel extends Model
{
    protected $table            = 'files';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = true;
    protected $protectFields    = true;
    protected $allowedFields    = ['file_name', 'file_size', 'file_type', 'folder_id', 'user_id', 'file_path', 'deleted_at'];

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
            ->like('file_name', $keyword)
            ->findAll();
    }
    public function getAllFilesWithFolderName()
    {
        return $this->select('files.id, files.file_name, files.file_size, files.file_type, folders.folder_name as folder_name, files.user_id, files.deleted_at, files.created_at, files.updated_at')
            ->join('folders', 'folders.id = files.folder_id');
    }

    public function getFileById($id)
    {
        return $this->onlyDeleted()->where('id', $id)->first();
    }
}
