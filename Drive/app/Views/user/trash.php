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
        <div class="btn-group mb-3" role="group">
            <button type="button" class="btn btn-primary list-view-toggle"><i class="fas fa-list"></i></button>
            <button type="button" class="btn btn-primary icon-view-toggle"><i class="fas fa-th-large"></i> </button>
        </div>
    </div>
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2">
        <div class="trash">
            <h6 class="mr-3 ml-3 mt-2">You can empty the trash by clicking the empty trash</h6>
            <button type="button" class="btn btn-trash">Empty trash</button>
        </div>


    </div>

    <!-- Daftar Konten -->
    <div class="row list-view">
        <!-- Tampilan daftar -->
        <div class="col-md-12">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th scope="col">Name</th>
                        <th scope="col">Trashed Date</th>
                        <th scope="col">File Size</th>
                        <th scope="col"><i class="fas fa-ellipsis-v"></i></th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            <i class="fas fa-folder file-icon-i"></i> Folder 1
                        </td>
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
    <div class="row icon-view" style="display: none;">

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
</main>
<?= $this->endSection(); ?>