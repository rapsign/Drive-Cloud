<?= $this->extend('user/templates/index'); ?>
<?= $this->section('page-content'); ?>

<!-- Main Content -->
<main role="main" class="col-md-10 ml-sm-auto col-lg-10 px-md-4 content ">
    <div class="search-form">
        <form class="form-inline" method="get" action="<?= base_url('search') ?>">
            <input class="form-control mr-sm-2 rounded-pill" type="search" name="q" placeholder="Search in Drive" aria-label="Search" value="<?= esc($keyword) ?>">
            <button class="btn btn-danger bg-danger rounded-pill" type="submit"><i class="fas fa-search"></i></button>
        </form>
    </div>

    <?php if ($keyword) : ?>
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3">
            <h1 class="h2">Search Results for "<?= esc($keyword) ?>"</h1>
        </div>
        <hr>
    <?php else : ?>

        <hr>
    <?php endif; ?>

    <!-- Daftar Konten -->
    <!-- Tampilan List -->

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
                            <td><i class="fas fa-file file-icon-i"></i><?= $file['file_name'] ?> <span class="file-icon"></span></td>
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
    </div> -->

    <!--begin::Form-->
    <form class="form" action="#" style="display: none;" id="addFileForm" method="post">
        <!--begin::Input group-->
        <div class="fv-row">
            <!--begin::Dropzone-->
            <div class="dropzone" id="kt_dropzonejs_example_2" style="border: 3px dashed #007bff;">
                <!--begin::Message-->
                <div class="dz-message needsclick">
                    <i class="ki-duotone ki-file-up fs-3x text-primary"><span class="path1"></span><span class="path2"></span></i>

                    <!--begin::Info-->
                    <div class="ms-4">
                        <h3 class="fs-5 fw-bold text-gray-900 mb-3">Drop files here or click to upload.</h3>
                        <span class="fs-7 fw-semibold text-gray-500">Upload up to 10 files</span>
                    </div>
                    <!--end::Info-->
                </div>
            </div>
            <!--end::Dropzone-->
        </div>
        <!--end::Input group-->
    </form>
    <!--end::Form-->
    <!-- Tampilan ikon -->
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 mt-3">
        <h1 class="h2">My Drive > <?= $folder_name ?></h1>
        <button class="btn btn-primary" id="addFileButton">+</button>
    </div>
    <h6>Folders</h6>
    <?php foreach ($folders as $folder) : ?>
        <div class="btn-group">
            <a href="<?= base_url('user/folder/') . $folder['slug'] ?>" class="btn btn-secondary">
                <i class="fas fa-folder fa-lg mr-2"></i> <!-- Icon with additional classes -->
                <span class="btn-text"><?= $folder['folder_name'] ?></span>
            </a>
            <button type="button" class="btn btn-secondary dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-expanded="false" style="width: 10px;">
                <span class="visually-hidden"><i class="fas fa-ellipsis-v"></i></span>
            </button>
            <ul class="dropdown-menu">
                <li>
                    <a class="dropdown-item" type="button" data-toggle="modal" data-target="#renameFolder" data-id="<?= $folder['id'] ?>" data-name="<?= $folder['folder_name'] ?>">
                        <i class="fas fa-edit mr-3"></i> Rename
                    </a>
                </li>
                <hr class="dropdown-divider">
                <li><button class="dropdown-item" type="button" data-toggle="modal" data-target="#moveFolder" data-id="<?= $folder['id'] ?>" data-name="<?= $folder['folder_name'] ?>"><i class="fas fa-folder-open mr-3"></i> Move</button></li>
                <hr class="dropdown-divider">

                <li>
                    <form action="<?= base_url('user/folder/moveToTrash') ?>" method="post" class="d-inline">
                        <input type="hidden" name="folderSlug" value="<?= $folder['slug'] ?>">
                        <a type="button" class="dropdown-item" onclick="Delete(event)">
                            <i class="fas fa-trash mr-3"></i> Move To Trash
                        </a>
                    </form>
                </li>
                <hr class="dropdown-divider">
                <li>
                    <form action="<?= base_url('user/folder/download') ?>" method="post" class="d-inline">
                        <input type="hidden" name="folderId" value="<?= $folder['id'] ?>">
                        <button type="submit" class="dropdown-item">
                            <i class="fas fa-download mr-3"></i> Download
                        </button>
                    </form>
                </li>
            </ul>
        </div>
    <?php endforeach; ?>
    <hr>
    <h6 class="mt-5">Files</h6>
    <div class="row">
        <?php foreach ($files as $file) : ?>
            <div class="col-md-3 col-6 file-item">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <div class="d-flex align-items-center">
                            <span class="file-icon"></span>
                            <span class="file-name small"><?= $file['file_name'] ?></span>
                            <span class="file-url" hidden><?= $file['file_path'] ?></span>
                        </div>
                        <div class="dropdown">
                            <i class="fas fa-ellipsis-v dropdown-toggle dropdown-toggle-no-caret" id="dropdownMenuButton1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></i>
                            <div class="dropdown-menu dropdown-menu-right dropdown-menu-animated" aria-labelledby="dropdownMenuButton1">
                                <!-- Dropdown with nested dropdown -->
                                <li class="dropdown-submenu dropright" style="margin: 0 5px 0 5px ;">
                                    <a class="dropdown-item dropdown-toggle dropdown-toggle-no-caret" type="button">
                                        <i class="fas fa-info mr-3"></i> Info
                                    </a>
                                    <ul class="dropdown-menu" style="margin-left: 5px;">
                                        <li>
                                            <span class="dropdown-item small">File Name</span>
                                            <span class="dropdown-item "><?= $file['file_name'] ?></span>
                                        </li>
                                        <hr class=" dropdown-divider">
                                        <li>
                                            <span class="dropdown-item small">File Size</span>
                                            <span class="dropdown-item "><?= formatBytes($file['file_size']) ?></span>
                                        </li>
                                        <hr class="dropdown-divider">
                                        <li>
                                            <span class="dropdown-item small">File Type</span>
                                            <span class="dropdown-item "><?= shortFileType($file['file_type']) ?></span>
                                        </li>
                                        <hr class="dropdown-divider">
                                        <li>
                                            <span class="dropdown-item small">Folder</span>
                                            <span class="dropdown-item folder-name"><?= $file['folder_name'] ?></span>
                                        </li>
                                        <hr class="dropdown-divider">
                                        <li>
                                            <span class="dropdown-item small">Uploaded</span>
                                            <span class="dropdown-item "><?= date('F d, Y', strtotime($file['created_at'])) ?></span>
                                        </li>
                                    </ul>
                                </li>
                                <hr class="dropdown-divider">
                                <!-- Tambah item dropdown untuk download -->
                                <li><a class="dropdown-item" href="<?= base_url('download' . '/' . $file['file_name']) ?>"><i class="fas fa-download mr-3"></i> Download</a></li>
                                <hr class="dropdown-divider">
                                <li><button class="dropdown-item" type="button" data-toggle="modal" data-target="#moveFile" data-id="<?= $file['id'] ?>" data-name="<?= $file['file_name'] ?>"><i class="fas fa-folder-open mr-3"></i> Move</button></li>
                                <hr class="dropdown-divider">

                                <li><button class="dropdown-item" type="button" data-toggle="modal" data-target="#renameFile" data-id="<?= $file['id'] ?>" data-name="<?= $file['file_name'] ?>"><i class="fas fa-edit mr-3"></i> Rename</button></li>
                                <hr class="dropdown-divider">
                                <li>
                                    <form action="<?= base_url('user/file/moveToTrash') ?>" method="post" class="d-inline">
                                        <input type="hidden" name="fileId" value="<?= $file['id'] ?>">
                                        <button type="button" class="dropdown-item" onclick="fileDelete(event)"><i class="fas fa-trash mr-3"></i> Move To Trash</button>
                                    </form>
                                </li>
                            </div>
                        </div>
                    </div>
                    <div class="card-body text-center">
                        <div class="file-preview" style="width: 100%; height: 220px;"></div>
                    </div>
                    <div class="card-footer text-muted text-center small">
                        Added on <?= date('F d, Y', strtotime($file['created_at'])) ?>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
    </div>
</main>

<?= $this->endSection(); ?>