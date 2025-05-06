<?= $this->extend('admin/templates/index'); ?>
<?= $this->section('page-content'); ?>

<div class="container main-content">
    <div class="pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Log</h1>
    </div>

    <!-- Responsive Table Wrapper -->
    <div class="table-responsive">
        <!-- User List Table -->
        <table id="myTable" class="table table-striped table-sm" style="width:100%">
            <thead>
                <tr>
                    <th class="text-center">NO</th>
                    <th class="text-center">Type</th>
                    <th class="text-center">Name</th>
                    <th class="text-center">User</th>
                    <th class="text-center">Created At</th>
                    <th class="text-center">Updated At</th>
                    <th class="text-center">Deleted At</th>
                </tr>
            </thead>
            <tbody>
                <!-- Display file logs -->
                <?php foreach($fileLogs as $index => $fileLog): ?>
                    <tr>
                        <td class="text-center fs-6"><?= $index + 1 ?></td>
                        <td class="text-center ">File</td>
                        <td class="text-center "><?= $fileLog['file_name'] ?></td>
                        <td class="text-center "><?= $fileLog['name'] ?></td>
                        <td class="text-center "><?= $fileLog['created_at'] ?></td>
                        <td class="text-center "><?= $fileLog['updated_at'] ? $fileLog['updated_at'] : '-' ?></td> 
                        <td class="text-center "><?= $fileLog['deleted_at'] ?></td>
                    </tr>
                <?php endforeach; ?>

                <!-- Display folder logs -->
                <?php foreach($folderLogs as $index => $folderLog): ?>
                    <tr>
                        <td class="text-center "><?= $index + 1 + count($fileLogs) ?></td>
                        <td class="text-center ">Folder</td>
                        <td class="text-center "><?= $folderLog['folder_name'] ?></td>
                        <td class="text-center "><?= $folderLog['name'] ?></td>
                        <td class="text-center "><?= $folderLog['created_at'] ?></td>
                        <td class="text-center "><?= $folderLog['updated_at'] ? $folderLog['updated_at'] : '-' ?></td> 
                        <td class="text-center "><?= $folderLog['deleted_at'] ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
            <tfoot>
                <tr>
                    <th class="text-center ">NO</th>
                    <th class="text-center ">Type</th>
                    <th class="text-center ">Name</th>
                    <th class="text-center ">User</th>
                    <th class="text-center ">Created At</th>
                    <th class="text-center ">Updated At</th>
                </tr>
            </tfoot>
        </table>
    </div>
</div>

<?= $this->endSection(); ?>

