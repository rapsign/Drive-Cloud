<?= $this->extend('user/templates/index'); ?>
<?= $this->section('page-content'); ?>

<!-- Main Content -->
<main role="main" class="col-md-10 ml-sm-auto col-lg-10 px-md-4 content ">
    <div class="search-form">
        <form class="form-inline">
            <input class="form-control mr-sm-2 rounded-pill" type="search" placeholder="Search in Drive" aria-label="Search">
            <button class="btn btn-primary rounded-pill" type="submit"><i class="fas fa-search"></i></button>
        </form>
    </div>

    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3">
        <h1 class="h2">My Drive</h1>
        <div class="btn-group mb-3" role="group">
            <button type="button" class="btn btn-primary list-view-toggle"><i class="fas fa-list"></i></button>
            <button type="button" class="btn btn-primary icon-view-toggle"><i class="fas fa-th-large"></i> </button>
        </div>
    </div>

    <!-- Daftar Konten -->
    <!-- Tampilan List -->

    <div class="row list-view fade-in">
        <!-- Tampilan daftar -->
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
                                        <li><a class="dropdown-item" type="button" data-toggle="modal" data-target="#renameFolder" data-id="<?= $folder['id'] ?>" data-name="<?= $folder['folder_name'] ?>"><i class="fas fa-edit mr-3"></i> Rename</a></li>
                                        <hr class="dropdown-divider">
                                        <li>
                                            <form action="<?= base_url('user/folder/moveToTrash') ?>" method="post" class="d-inline">
                                                <input type="hidden" name="folderSlug" value="<?= $folder['slug'] ?>">
                                                <button type="button" class="dropdown-item" onclick="Delete(event)"><i class="fas fa-trash mr-3"></i> Move To Trash</button>
                                            </form>
                                        </li>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    <?php foreach ($files as $file) : ?>
                        <tr>
                            <td><i class="fas fa-file file-icon-i"></i> <?= $file['file_name'] ?></td>
                            <td class="small"><?= date('F d, Y', strtotime($file['created_at'])) ?></td>
                            <td>-</td>
                            <td>
                                <div class="dropdown">
                                    <i class="fas fa-ellipsis-v dropdown-toggle dropdown-toggle-no-caret" id="dropdownMenuButton1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></i>
                                    <div class="dropdown-menu dropdown-menu-right dropdown-menu-animated" aria-labelledby="dropdownMenuButton1">
                                        <li><a class="dropdown-item" type="button" data-toggle="modal" data-target="#renameFolder" data-id="<?= $file['id'] ?>" data-name="<?= $file['file_name'] ?>"><i class="fas fa-edit mr-3"></i> Rename</a></li>
                                        <hr class="dropdown-divider">
                                        <li>
                                            <form action="<?= base_url('user/folder/moveToTrash') ?>" method="post" class="d-inline">
                                                <input type="hidden" name="folderSlug" value="<?= $file['id'] ?>">
                                                <button type="button" class="dropdown-item" onclick="Delete(event)"><i class="fas fa-trash mr-3"></i> Move To Trash</button>
                                            </form>
                                        </li>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Tampilan ikon -->
    <hr>
    <div class="icon-view fade-in" style="display: none;">
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
                    <li><button class="dropdown-item" type="button" data-toggle="modal" data-target="#renameFolder" data-id="<?= $folder['id'] ?>" data-name="<?= $folder['folder_name'] ?>"><i class="fas fa-edit mr-3"></i> Rename</button></li>
                    <hr class="dropdown-divider">
                    <li>
                        <form action="<?= base_url('user/folder/moveToTrash') ?>" method="post" class="d-inline">
                            <input type="hidden" name="folderSlug" value="<?= $folder['slug'] ?>">
                            <button type="button" class="dropdown-item" onclick="Delete(event)"><i class="fas fa-trash mr-3"></i> Move To Trash</button>
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
                            <span class="file-name" onclick="loadFilePreview('<?= base_url('../file/') . session()->get('name') . '/' . $file['file_name'] ?>')"><?= $file['file_name'] ?></span>
                            <div class="dropdown">
                                <i class="fas fa-ellipsis-v dropdown-toggle dropdown-toggle-no-caret" id="dropdownMenuButton1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></i>
                                <div class="dropdown-menu dropdown-menu-right dropdown-menu-animated" aria-labelledby="dropdownMenuButton1">
                                    <a class="dropdown-item" href="#">Action 1</a>
                                    <div class="dropdown-divider"></div> <!-- Divider line -->
                                    <a class="dropdown-item" href="#">Action 2</a>
                                    <div class="dropdown-divider"></div> <!-- Divider line -->
                                    <a class="dropdown-item" href="#">Action 3</a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body text-center">
                            <div class="card-body text-center" style="height: 200px;">
                                <div class="file-preview" style="width: 100%; height: 100%;">

                                </div>
                            </div>
                        </div>
                        <div class="card-footer text-muted text-center small">
                            <?= date('F d, Y', strtotime($file['created_at'])) ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>



</main>

<?= $this->endSection(); ?>