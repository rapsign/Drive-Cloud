<?= $this->extend('user/templates/index'); ?>
<?= $this->section('page-content'); ?>
<!-- Main Content -->
<main role="main" class="col-md-10 ml-sm-auto col-lg-10 px-md-4 content">
    <div class="search-form">
        <form class="form-inline">
            <input class="form-control mr-sm-2 rounded-pill" type="search" placeholder="Search in Drive" aria-label="Search">
            <button class="btn btn-primary rounded-pill" type="submit"><i class="fas fa-search"></i></button>
        </form>
    </div>

    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2">
        <h1 class="h2">Trash</h1>
        <!-- <div class="btn-group mb-3" role="group">
            <button type="button" class="btn btn-primary list-view-toggle"><i class="fas fa-list"></i></button>
            <button type="button" class="btn btn-primary icon-view-toggle"><i class="fas fa-th-large"></i> </button>
        </div> -->
    </div>

    <?php if (empty($folders) && empty($files)) : ?>
        <div class="d-flex justify-content-center align-items-center" style="height: 700px;">
            <div>
                <h3 class="text-center">Nothing in trash</h3>
                <p>Items in trash will be deleted forever</p>
            </div>
        </div>
    <?php else : ?>

        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2">
            <div class="trash">
                <h6 class="mr-3 ml-3 mt-2">You can empty the trash by clicking the empty trash</h6>
                <form action="<?= base_url('user/trash/emptyTrash') ?>" method="get" class="d-inline">
                    <button type="button" class="btn btn-trash" onclick="deleteTrash(event)">Empty trash</button>
                </form>
            </div>


        </div>

        <!-- <div class="row list-view fade-in">
    <div class="col-md-12">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th scope="col">Name</th>
                    <th scope="col">Date</th>
                    <th scope="col">File Size</th>
                    <th scope="col"><i class="fas fa-ellipsis-v"></i></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($folders as $folder) : ?>
                    <tr>
                        <td><i class="fas fa-folder file-icon-i"></i> <?= $folder['folder_name'] ?></td>
                        <td class="small"><?= date('F d, Y', strtotime($folder['created_at'])) ?></td>
                        <td>-</td>
                        <td>
                            <div class="dropdown">
                                <i class="fas fa-ellipsis-v dropdown-toggle dropdown-toggle-no-caret" id="dropdownMenuButton1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></i>
                                <div class="dropdown-menu dropdown-menu-right dropdown-menu-animated" aria-labelledby="dropdownMenuButton1">
                                    <li>
                                        <form action="<?= base_url('user/folder/restoreFolder') ?>" method="post" style="display: inline;">
                                            <input type="hidden" name="folderId" value="<?php echo esc($folder['id']); ?>">
                                            <button type="submit" class="dropdown-item"><i class="fas fa-undo mr-3"></i> Restore</button>
                                        </form>
                                    </li>
                                    <hr class="dropdown-divider">
                                    <li>
                                        <form action="<?= base_url('user/folder/deleteFolder') ?>" method="post" class="d-inline">
                                            <input type="hidden" name="folderId" value="<?= $folder['id'] ?>">
                                            <input type="hidden" name="folderName" value="<?= $folder['folder_name'] ?>">
                                            <button type="button" class="dropdown-item" onclick="DeleteFolder(event)"><i class="fas fa-trash mr-3"></i> Delete forever</button>
                                        </form>
                                    </li>
                                </div>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
                <tr>
                    <td>
                        <i class="fas fa-file file-icon-i"></i> Document 1
                    </td>
                    <td>2024-05-03</td>
                    <td>1.2 MB</td>
                    <td><i class="fas fa-ellipsis-v"></i></td>
                </tr>
                <tr>
                    <td>
                        <i class="fas fa-file file-icon-i"></i> Document 2
                    </td>
                    <td>2024-05-04</td>
                    <td>3.4 MB</td>
                    <td><i class="fas fa-ellipsis-v"></i></td>
                </tr>
            </tbody>
        </table>
    </div>
    </div> -->

        <!-- Tampilan ikon -->
        <hr>
        <div class="icon-view fade-in">
            <h6>Folders</h6>
            <?php foreach ($folders as $folder) : ?>
                <div class="btn-group">
                    <a href="<?= base_url('user/recent') ?>" class="btn btn-secondary">
                        <i class="fas fa-folder fa-lg mr-2"></i> <!-- Icon with additional classes -->
                        <span class="btn-text"><?= $folder['folder_name'] ?></span>
                    </a>
                    <button type="button" class="btn btn-secondary dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-expanded="false" style="width: 10px;">
                        <span class="visually-hidden"><i class="fas fa-ellipsis-v"></i></span>
                    </button>
                    <ul class="dropdown-menu">
                        <li>
                            <form action="<?= base_url('user/folder/restoreFolder') ?>" method="post" style="display: inline;">
                                <input type="hidden" name="folderId" value="<?php echo esc($folder['id']); ?>">
                                <button type="submit" class="dropdown-item"><i class="fas fa-undo mr-3"></i> Restore</button>
                            </form>
                        </li>
                        <hr class="dropdown-divider">
                        <li>
                            <form action="<?= base_url('user/folder/deleteFolder') ?>" method="post" class="d-inline">
                                <input type="hidden" name="folderId" value="<?= $folder['id'] ?>">
                                <input type="hidden" name="folderName" value="<?= $folder['folder_name'] ?>">
                                <button type="button" class="dropdown-item" onclick="deleteFolder(event)"><i class="fas fa-trash mr-3"></i> Delete forever</button>
                            </form>
                        </li>
                    </ul>
                </div>
            <?php endforeach; ?>
            <hr>
            <h6>Files</h6>
            <div class="row">
                <?php foreach ($files as $file) : ?>
                    <div class="col-md-3 col-6 file-item">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <div class="d-flex align-items-center">
                                    <span class="file-icon"></span>
                                    <span class="file-name small"><?= $file['file_name'] ?></span>
                                </div>
                                <div class="dropdown">
                                    <i class="fas fa-ellipsis-v dropdown-toggle dropdown-toggle-no-caret" id="dropdownMenuButton1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></i>
                                    <div class="dropdown-menu dropdown-menu-right dropdown-menu-animated" aria-labelledby="dropdownMenuButton1">
                                        <li>
                                            <form action="<?= base_url('user/file/restoreFile') ?>" method="post" style="display: inline;">
                                                <input type="hidden" name="fileId" value="<?= ($file['id']); ?>">
                                                <button type="submit" class="dropdown-item"><i class="fas fa-undo mr-3"></i> Restore</button>
                                            </form>
                                        </li>
                                        <hr class="dropdown-divider">
                                        <li>
                                            <form action="<?= base_url('user/file/deleteFile') ?>" method="post" class="d-inline">
                                                <input type="hidden" name="fileId" value="<?= $file['id'] ?>">
                                                <input type="hidden" name="fileName" value="<?= $file['file_name'] ?>">
                                                <button type="button" class="dropdown-item" onclick="deleteFile(event)"><i class="fas fa-trash mr-3"></i> Delete forever</button>
                                            </form>
                                        </li>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body text-center">
                                <div class="file-preview" style="width: 100%; height: 220px;"></div>
                            </div>
                            <div class="card-footer text-muted text-center small">
                                Trashed date <?= date('F d, Y', strtotime($file['deleted_at'])) ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
            </div>
        </div>

</main>
<?= $this->endSection(); ?>