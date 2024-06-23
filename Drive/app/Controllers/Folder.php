<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\FilesModel;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\FolderModel;

class Folder extends BaseController
{
    protected $folderModel;
    protected $fileModel;

    public function __construct()
    {
        $this->folderModel = new FolderModel();
        $this->fileModel = new FilesModel();
    }
    public function index()
    {
        //
    }

    public function addFolder()
    {
        helper('text');

        $foldername = $this->request->getVar('folder');
        $userId = $this->request->getVar('userId');
        $username = session()->get('name');

        // Path dasar untuk folder pengguna
        $baseFolderPath = FCPATH . 'files' . DIRECTORY_SEPARATOR . $username . DIRECTORY_SEPARATOR;
        $folderPath = $baseFolderPath . $foldername;

        // Tambahkan nomor di belakang nama folder jika sudah ada
        $counter = 2;
        while (is_dir($folderPath)) {
            $foldername = $this->request->getVar('folder') . '_' . $counter;
            $folderPath = $baseFolderPath . $foldername;
            $counter++;
        }

        // Simpan data folder ke database
        $this->folderModel->save([
            'folder_name' => $foldername,
            'user_id' => $userId,
            'slug' => random_string('alnum', 35),
            'folder_path' => 'files' . DIRECTORY_SEPARATOR . $username . DIRECTORY_SEPARATOR
        ]);

        // Buat folder di sistem file
        mkdir($folderPath, 0777, true);

        // Set flashdata dan redirect
        session()->setFlashdata('success_message', 'Folder added successfully!');
        return redirect()->to('/user');
    }
    public function addFolderInFolder($slug)
    {
        helper('text');

        $foldername = $this->request->getVar('folder');
        $userId = $this->request->getVar('userId');
        $username = session()->get('name');
        $folder = $this->folderModel->getFolderBySlug($slug);

        // Check if the folder exists
        if (!$folder) {
            session()->setFlashdata('error_message', 'Parent folder not found.');
            return redirect()->back();
        }

        // Path dasar untuk folder pengguna
        $baseFolderPath = FCPATH . $folder['folder_path'] . $folder['folder_name'] . DIRECTORY_SEPARATOR;
        $folderPath = $baseFolderPath . $foldername;

        // Tambahkan nomor di belakang nama folder jika sudah ada
        $counter = 2;
        while (is_dir($folderPath)) {
            $foldername = $this->request->getVar('folder') . '_' . $counter;
            $folderPath = $baseFolderPath . $foldername;
            $counter++;
        }

        // Simpan data folder ke database
        $this->folderModel->save([
            'folder_name' => $foldername,
            'user_id' => $userId,
            'slug' => random_string('alnum', 35),
            'folder_path' => $folder['folder_path'] . $folder['folder_name'] . DIRECTORY_SEPARATOR,
            'parent_id' => $folder['id']
        ]);

        // Buat folder di sistem file
        mkdir($folderPath, 0777, true);

        // Set flashdata dan redirect
        session()->setFlashdata('success_message', 'Folder added successfully!');
        return redirect()->back();
    }

    public function renameFolder()
    {
        $folderId = $this->request->getVar('id');
        $newFolderName = $this->request->getVar('folder_name');
        $username = session()->get('name');

        // Dapatkan folder lama dari database
        $folder = $this->folderModel->find($folderId);
        if (!$folder) {
            session()->setFlashdata('error_message', 'Folder not found!');
            return redirect()->back();
        }

        $oldFolderName = $folder['folder_name'];
        $baseFolderPath = FCPATH . $folder['folder_path'];
        $oldFolderPath = $baseFolderPath .  DIRECTORY_SEPARATOR   . $oldFolderName;
        $newFolderPath = $baseFolderPath . DIRECTORY_SEPARATOR . $newFolderName;

        // Tambahkan nomor di belakang nama folder jika sudah ada
        $counter = 2;
        while (is_dir($newFolderPath) && $newFolderName != $oldFolderName) {
            $newFolderName = $this->request->getVar('folder_name') . '_' . $counter;
            $newFolderPath = $baseFolderPath . $newFolderName;
            $counter++;
        }

        // Ubah nama folder di sistem file
        if (is_dir($oldFolderPath)) {
            rename($oldFolderPath, $newFolderPath);
        }

        // Simpan perubahan nama folder ke database
        $this->folderModel->save([
            'id' => $folderId,
            'folder_name' => $newFolderName,
        ]);

        session()->setFlashdata('success_message', 'Folder renamed successfully!');
        return redirect()->back();
    }

    public function moveToTrash()
    {
        $folderSlug = $this->request->getVar('folderSlug');
        $folder = $this->folderModel->getFolderBySlug($folderSlug);
        if ($folder) {
            $this->deleteFolderAndContents($folder['id']);
            session()->setFlashdata('success_message', 'Folder and its contents moved to trash');
        } else {
            session()->setFlashdata('error_message', 'Folder not found');
        }
        return redirect()->back();
    }

    private function deleteFolderAndContents($folderId)
    {
        // Get all subfolders of the folder
        $subFolders = $this->folderModel->withDeleted()->where('parent_id', $folderId)->findAll();
        foreach ($subFolders as $subFolder) {
            // Recursively delete subfolders and their contents
            $this->deleteFolderAndContents($subFolder['id']);
        }

        // Get all files in the folder
        $files = $this->fileModel->where('folder_id', $folderId)->findAll();

        // Delete all files in the folder
        foreach ($files as $file) {

            // Hapus file dari database
            $this->fileModel->delete($file['id']);
        }

        // Finally, delete the folder itself
        $this->folderModel->delete($folderId);
    }
    public function restoreFolder()
    {
        $folderId = $this->request->getVar('folderId');

        // Memulihkan folder utama
        $this->restoreFolderAndContents($folderId);

        session()->setFlashdata('success_message', 'Folder restored successfully!');
        return redirect()->to('/user/trash');
    }

    // Fungsi untuk memulihkan folder dan semua subfolder serta file-file terkait secara rekursif
    private function restoreFolderAndContents($folderId)
    {
        // Memulihkan folder
        $this->folderModel->save([
            'id' => $folderId,
            'deleted_at' => null,
        ]);

        // Memulihkan file-file terkait dengan folder
        $this->restoreFilesInFolder($folderId);

        // Memulihkan subfolder secara rekursif
        $subFolders = $this->folderModel->withDeleted()->where('parent_id', $folderId)->findAll();
        foreach ($subFolders as $subFolder) {
            $this->restoreFolderAndContents($subFolder['id']);
        }
    }

    // Fungsi untuk memulihkan file-file yang terkait dengan folder
    private function restoreFilesInFolder($folderId)
    {
        // Mengambil semua file yang terkait dengan folder
        $files = $this->fileModel->withDeleted()->where('folder_id', $folderId)->findAll();

        // Memulihkan setiap file
        foreach ($files as $file) {
            $this->fileModel->save([
                'id' => $file['id'],
                'deleted_at' => null,
            ]);
        }
    }


    public function deleteFolder()
    {
        $folderId = $this->request->getVar('folderId');
        $username = session()->get('name');
        $folder = $this->folderModel->onlyDeleted()->where('id', $folderId)->first();

        // Periksa apakah folder ada sebelum menghapusnya
        if ($folder) {
            $folderName = $this->request->getVar('folderName');
            $folderPath = $folder['folder_path'] . $folderName;

            // Hapus direktori dan isinya dari sistem file
            $this->deleteDirectory($folderPath);

            // Hapus folder dan subfolder dari database secara permanen
            $this->deleteFolderAndContentsPermanently($folderId);

            session()->setFlashdata('success_message', 'Folder deleted successfully!');
        } else {
            session()->setFlashdata('error_message', 'Folder not found!');
        }
        return redirect()->to('/user/trash');
    }

    // Fungsi untuk menghapus folder dan semua subfolder dari database secara permanen
    private function deleteFolderAndContentsPermanently($folderId)
    {
        // Get all subfolders of the folder
        $subFolders = $this->folderModel->withDeleted()->where('parent_id', $folderId)->findAll();
        foreach ($subFolders as $subFolder) {
            // Recursively delete subfolders
            $this->deleteFolderAndContentsPermanently($subFolder['id']);
        }

        // Finally, permanently delete the folder itself
        $this->folderModel->withDeleted()->where('id', $folderId)->purgeDeleted(); // true parameter untuk menghapus secara permanen
    }

    // Fungsi untuk menghapus direktori dan semua isinya
    private function deleteDirectory($dir)
    {
        if (!is_dir($dir)) {
            return;
        }

        $files = array_diff(scandir($dir), ['.', '..']);
        foreach ($files as $file) {
            (is_dir("$dir/$file")) ? $this->deleteDirectory("$dir/$file") : unlink("$dir/$file");
        }
        rmdir($dir);
    }

    public function moveFolder()
    {
        $folderId = $this->request->getPost('folder_id');
        $targetFolderSlug = $this->request->getPost('target_folder');
        $folder = $this->folderModel->find($folderId);
        $folderName = $this->request->getPost('folder_name');
        $username = session()->get('name');
        $targetFolder = $this->folderModel->getFolderBySlug($targetFolderSlug);

        if (!$folder || !$targetFolder) {
            session()->setFlashdata('error_message', 'Invalid folder or target folder!');
            return redirect()->back();
        }

        // Construct full paths to source and target folders
        $folderDir = $folder['folder_path'] . DIRECTORY_SEPARATOR . $folder['folder_name'];
        $targetDir = $targetFolder['folder_path'] . $targetFolder['folder_name'] . DIRECTORY_SEPARATOR;

        $newFolderName = $folderName;
        $i = 1;
        while (is_dir($targetDir . $newFolderName)) {
            $newFolderName = $folderName . '_' . $i;
            $i++;
        }

        // Move folder and its contents to target directory with new folder name
        if ($this->moveDirectory($folderDir, $targetDir . $newFolderName)) {
            // Update file paths in the database for all files within the moved folder
            $this->updateFilePaths($folderId, $targetFolder['id'], $targetDir . $newFolderName);

            // Update folder information in the database
            $this->folderModel->update($folderId, [
                'folder_name' => $newFolderName,
                'parent_id' => $targetFolder['id'],
                'folder_path' => $targetFolder['folder_path'] . $targetFolder['folder_name'] . DIRECTORY_SEPARATOR
            ]);

            session()->setFlashdata('success_message', 'Folder moved successfully!');
        } else {
            session()->setFlashdata('error_message', 'Failed to move folder!');
        }

        return redirect()->back();
    }

    private function moveDirectory($src, $dst)
    {
        if (!is_dir($src)) {
            return false;
        }

        @mkdir($dst); // Use @ to suppress warnings if directory already exists
        $dir = opendir($src);
        if (!$dir) {
            return false;
        }

        while (false !== ($file = readdir($dir))) {
            if ($file != '.' && $file != '..') {
                $srcFile = $src . DIRECTORY_SEPARATOR . $file;
                $dstFile = $dst . DIRECTORY_SEPARATOR . $file;
                if (is_dir($srcFile)) {
                    if (!$this->moveDirectory($srcFile, $dstFile)) {
                        closedir($dir);
                        return false;
                    }
                } else {
                    if (!rename($srcFile, $dstFile)) {
                        closedir($dir);
                        return false;
                    }
                }
            }
        }

        closedir($dir);
        @rmdir($src); // Use @ to suppress warnings if directory is not empty

        return true;
    }

    private function updateFilePaths($oldFolderId, $newFolderId, $newFolderPath)
    {
        $files = $this->fileModel->where('folder_id', $oldFolderId)->findAll();
        foreach ($files as $file) {
            $filePath = str_replace($file['file_path'], $newFolderPath, $file['file_path']);
            $this->fileModel->update($file['id'], [
                'file_path' => $filePath . DIRECTORY_SEPARATOR,
            ]);
        }

        // Recursively update subfolders' files paths
        $subfolders = $this->folderModel->where('parent_id', $oldFolderId)->findAll();
        foreach ($subfolders as $subfolder) {
            $oldSubfolderPath = $subfolder['folder_path'] . $subfolder['folder_name'];
            $newSubfolderPath = $newFolderPath . DIRECTORY_SEPARATOR . $subfolder['folder_name'];
            $this->updateFilePaths($subfolder['id'], $newFolderId, $newSubfolderPath);
        }
    }

    public function download()
    {
        $folderId = $this->request->getPost('folderId');

        // Fetch folder details
        $folder = $this->folderModel->find($folderId);

        if (!$folder) {
            return redirect()->back()->with('error_message', 'Folder not found.');
        }

        $folderPath = FCPATH . $folder['folder_path'] . $folder['folder_name']; // Adjust the path as needed

        if (!is_dir($folderPath)) {
            return redirect()->back()->with('error_message', 'Folder not found on the server.');
        }

        // Create a zip archive of the folder
        $zip = new \ZipArchive();
        $zipFileName = $folder['folder_name'] . '.zip';
        $zipFilePath = FCPATH . $folder['folder_path'] . $zipFileName;

        if ($zip->open($zipFilePath, \ZipArchive::CREATE | \ZipArchive::OVERWRITE) !== true) {
            return redirect()->back()->with('error_message', 'Could not create zip file.');
        }

        $this->addFolderToZip($folderPath, $zip, strlen(FCPATH . $folder['folder_path']));
        $zip->close();

        $response = $this->response->download($zipFilePath, null)->setFileName($zipFileName);

        // Clean up the zip file after sending the response
        register_shutdown_function(function () use ($zipFilePath) {
            if (file_exists($zipFilePath)) {
                unlink($zipFilePath);
            }
        });

        return $response;
    }
    private function addFolderToZip($folderPath, &$zip, $baseLength)
    {
        $files = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($folderPath), \RecursiveIteratorIterator::LEAVES_ONLY);

        $hasFiles = false;
        foreach ($files as $name => $file) {
            // Skip directories (they would be added automatically)
            if (!$file->isDir()) {
                $hasFiles = true;
                // Get the relative path
                $filePath = $file->getRealPath();
                $relativePath = substr($filePath, $baseLength);

                // Add the file to the zip archive
                $zip->addFile($filePath, $relativePath);
            }
        }

        // If no files were added, create an empty directory in the zip
        if (!$hasFiles) {
            $zip->addEmptyDir(substr($folderPath, $baseLength));
        }
    }
}
