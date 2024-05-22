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
                    <tr>
                        <td><i class="fas fa-folder file-icon-i"></i> Folder 1</td>
                        <td>2024-05-01</td>
                        <td>-</td>
                        <td>
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
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <i class="fas fa-folder file-icon-i"></i> Folder 2
                        </td>
                        <td>2024-05-02</td>
                        <td>-</td>
                        <td><i class="fas fa-ellipsis-v"></i></td>
                    </tr>
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
    </div>

    <!-- Tampilan ikon -->
    <hr>
    <div class="icon-view fade-in" style="display: none;">
        <h6>Folders</h6>
        <div class="btn-group">
            <a href="<?= base_url('user/recent') ?>" class="btn btn-secondary">
                <i class="fas fa-folder fa-lg mr-2"></i> <!-- Icon with additional classes -->
                <span class="btn-text">Folder 1 with a very long name</span>
            </a>
            <button type="button" class="btn btn-secondary dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-expanded="false" style="width: 10px;">
                <span class="visually-hidden"><i class="fas fa-ellipsis-v"></i></span>
            </button>
            <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="#">Action</a></li>
                <li><a class="dropdown-item" href="#">Another action</a></li>
                <li><a class="dropdown-item" href="#">Something else here</a></li>
                <li>
                    <hr class="dropdown-divider">
                </li>
                <li><a class="dropdown-item" href="#">Separated link</a></li>
            </ul>
        </div>
        <div class="btn-group">
            <a href="<?= base_url('user/recent') ?>" class="btn btn-secondary">
                <i class="fas fa-folder fa-lg mr-2"></i> <!-- Icon with additional classes -->
                <span class="btn-text">Folder 1 with a very long name</span>
            </a>
            <button type="button" class="btn btn-secondary dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-expanded="false" style="width: 10px;">
                <span class="visually-hidden"><i class="fas fa-ellipsis-v"></i></span>
            </button>
            <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="#">Action</a></li>
                <li><a class="dropdown-item" href="#">Another action</a></li>
                <li><a class="dropdown-item" href="#">Something else here</a></li>
                <li>
                    <hr class="dropdown-divider">
                </li>
                <li><a class="dropdown-item" href="#">Separated link</a></li>
            </ul>
        </div>
        <div class="btn-group">
            <a href="<?= base_url('user/recent') ?>" class="btn btn-secondary">
                <i class="fas fa-folder fa-lg mr-2"></i> <!-- Icon with additional classes -->
                <span class="btn-text">Folder 1 with a very long name</span>
            </a>
            <button type="button" class="btn btn-secondary dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-expanded="false" style="width: 10px;">
                <span class="visually-hidden"><i class="fas fa-ellipsis-v"></i></span>
            </button>
            <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="#">Action</a></li>
                <li><a class="dropdown-item" href="#">Another action</a></li>
                <li><a class="dropdown-item" href="#">Something else here</a></li>
                <li>
                    <hr class="dropdown-divider">
                </li>
                <li><a class="dropdown-item" href="#">Separated link</a></li>
            </ul>
        </div>
        <div class="btn-group">
            <a href="<?= base_url('user/recent') ?>" class="btn btn-secondary">
                <i class="fas fa-folder fa-lg mr-2"></i> <!-- Icon with additional classes -->
                <span class="btn-text">Folder 1 with a very long name</span>
            </a>
            <button type="button" class="btn btn-secondary dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-expanded="false" style="width: 10px;">
                <span class="visually-hidden"><i class="fas fa-ellipsis-v"></i></span>
            </button>
            <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="#">Action</a></li>
                <li><a class="dropdown-item" href="#">Another action</a></li>
                <li><a class="dropdown-item" href="#">Something else here</a></li>
                <li>
                    <hr class="dropdown-divider">
                </li>
                <li><a class="dropdown-item" href="#">Separated link</a></li>
            </ul>
        </div>
        <div class="btn-group">
            <a href="<?= base_url('user/recent') ?>" class="btn btn-secondary">
                <i class="fas fa-folder fa-lg mr-2"></i> <!-- Icon with additional classes -->
                <span class="btn-text">Folder 1 with a very long name</span>
            </a>
            <button type="button" class="btn btn-secondary dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-expanded="false" style="width: 10px;">
                <span class="visually-hidden"><i class="fas fa-ellipsis-v"></i></span>
            </button>
            <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="#">Action</a></li>
                <li><a class="dropdown-item" href="#">Another action</a></li>
                <li><a class="dropdown-item" href="#">Something else here</a></li>
                <li>
                    <hr class="dropdown-divider">
                </li>
                <li><a class="dropdown-item" href="#">Separated link</a></li>
            </ul>
        </div>
        <div class="btn-group">
            <a href="<?= base_url('user/recent') ?>" class="btn btn-secondary">
                <i class="fas fa-folder fa-lg mr-2"></i> <!-- Icon with additional classes -->
                <span class="btn-text">Folder 1 with a very long name</span>
            </a>
            <button type="button" class="btn btn-secondary dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-expanded="false" style="width: 10px;">
                <span class="visually-hidden"><i class="fas fa-ellipsis-v"></i></span>
            </button>
            <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="#">Action</a></li>
                <li><a class="dropdown-item" href="#">Another action</a></li>
                <li><a class="dropdown-item" href="#">Something else here</a></li>
                <li>
                    <hr class="dropdown-divider">
                </li>
                <li><a class="dropdown-item" href="#">Separated link</a></li>
            </ul>
        </div>

        <hr>
        <h6>Files</h6>
        <div class="row">
            <div class="col-md-3 col-6 file-item">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <span class="file-name">Folder 1</span>
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
                        <div class="file-icon mb-3">
                            <i class="fas fa-folder"></i>
                        </div>
                    </div>
                    <div class="card-footer text-muted text-center">
                        April 21, 2024
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-6 file-item">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <span class="file-name">Folder 2</span>
                        <i class="fas fa-ellipsis-v"></i>
                    </div>
                    <div class="card-body text-center">
                        <div class="file-icon mb-3">
                            <i class="fas fa-folder"></i>
                        </div>
                    </div>
                    <div class="card-footer text-muted text-center">
                        April 21, 2024
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-6 file-item">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <span class="file-name">Document 1</span>
                        <i class="fas fa-ellipsis-v"></i>
                    </div>
                    <div class="card-body text-center" style="height: 200px;">
                        <div class="file-preview" style="width: 100%; height: 100%;">
                            <!-- Preview will be loaded here -->
                        </div>
                    </div>
                    <div class="card-footer text-muted text-center">
                        April 21, 2024
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-6 file-item">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <span class="file-name">Document 2</span>
                        <i class="fas fa-ellipsis-v"></i>
                    </div>
                    <div class="card-body text-center">
                        <div class="file-icon mb-3">
                            <i class="fas fa-file-alt"></i>
                        </div>
                    </div>
                    <div class="card-footer text-muted text-center">
                        April 21, 2024
                    </div>
                </div>
            </div>
        </div>
    </div>



</main>

<?= $this->endSection(); ?>