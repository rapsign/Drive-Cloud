<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Google Drive Clone</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="<?= base_url() ?>/assets/css/style.css">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/5.1.3/css/bootstrap.min.css" rel="stylesheet">
    <!-- SweetAlert2 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <link href="https://unpkg.com/dropzone@6.0.0-beta.1/dist/dropzone.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="https://unpkg.com/dropzone@5/dist/min/dropzone.min.css" type="text/css" />
    <link rel="stylesheet" href="https://viewerjs.org/ViewerJS/css/viewer.css">
    <link href="https://vjs.zencdn.net/7.20.3/video-js.css" rel="stylesheet" />
</head>

<body>
    <div id="loading-screen">
        <div class="spinner-border text-primary" role="status">
            <span class="sr-only">Loading...</span>
        </div>
    </div>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-primary">
        <a class="navbar-brand" href="<?= base_url('/user') ?>">
            <span class="d-none d-md-inline">Cloud Storage UIGM</span>
            <img src="<?= base_url() ?>/assets/img/logo.png" class="d-inline d-md-none" alt="Drive Logo" style="height: 3rem;">
        </a>

        <!-- Add the ml-auto class to push this element to the right -->
        <span class="d-none d-sm-inline ml-auto "><?= session('name') ?></span>

        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
    </nav>


    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <nav id="sidebarMenu" class="col-md-2 d-md-block sidebar">
                <div class="sidebar-sticky">
                    <ul class="nav flex-column">
                        <li class="nav-item disabled">
                            <a class="nav-link active" href="<?= base_url('user') ?>">
                                <?= session('name') ?>
                            </a>
                        </li>
                        <li class="nav-item">
                            <div class="dropdown nav-link">
                                <button class="btn btn-plus bg-primary dropdown-toggle dropdown-toggle-no-caret" id="dropdownMenuButton1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-plus"></i> New</button>
                                <div class="dropdown-menu dropdown-menu-right dropdown-menu-animated" aria-labelledby="dropdownMenuButton1">
                                    <a class="dropdown-item" href="<?= base_url('user/upload') ?>"><i class="fas fa-upload"></i> File Upload</a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item" type="button" data-toggle="modal" data-target="#staticBackdrop"><i class="fas fa-folder"></i> New Folder</a>
                                </div>
                            </div>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= base_url('user') ?>">
                                <i class="fas fa-home"></i> Home
                            </a>
                        </li>
                        <!-- <li class="nav-item">
                            <a class="nav-link" href="#">
                                <i class="fas fa-star"></i> Starred
                            </a>
                        </li> -->
                        <li class="nav-item">
                            <a class="nav-link" href="<?= base_url('user/trash') ?>">
                                <i class="fas fa-trash-alt"></i> Trash
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= base_url('logout') ?>">
                                <i class="fas fa-sign-out-alt"></i> logout
                            </a>
                        </li>
                        <li class="nav-item mt-3">
                            <div>
                                <span class="span-progress">Storage</span>
                                <div class="progress">
                                    <div id="progressBar" class="progress-bar" role="progressbar" style="width: 0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">0%</div>
                                </div>
                                <span class="span-progress"><?= formatBytes($size) ?> of 15GB used</span>
                            </div>

                        </li>
                    </ul>
                </div>
            </nav>

            <!-- Main Content -->
            <?= $this->renderSection('page-content'); ?>
        </div>
        <footer class="py-3 my-4">
            <ul class="nav justify-content-center border-bottom border-top p-3 mb-3">
                <li class=""><a href="<?= base_url('user') ?>" class="mx-2 text-dark">Home</a></li>
                <li class=""><a href="<?= base_url('/user/trash') ?>" class="mx-2 text-dark">Trash</a></li>
                <!-- <li class=""><a href="https://www.uigm.ac.id/" class="mx-2 text-dark">About</a></li> -->
            </ul>
            <p class="text-center text-body-secondary">&copy; 2024 created by RapSign. All rights reserved</p>
        </footer>
    </div>

    <?php
    $folder_slug = isset($folder_slug) ? $folder_slug : '';
    ?>
    <div class="modal fade " id="staticBackdrop" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">New Folder</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="<?= base_url('user/createFolder/' . ($folder_slug ? $folder_slug : '')) ?>" method="post">
                        <div class="form-group">
                            <input type="hidden" name="userId" value="<?= session()->get('id') ?>">
                            <input type="text" class="form-control" id="folder" name="folder" value="Untitled folder">
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Create</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="renameFolder" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Rename</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="<?= base_url('user/folder/rename') ?>" method="post">
                        <div class="form-group">
                            <input type="hidden" name="id" id="folder-id">
                            <input type="text" class="form-control" id="folder-name" name="folder_name" required>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Rename</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="renameFile" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Rename</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="<?= base_url('user/file/rename') ?>" method="post">
                        <div class="form-group">
                            <input type="hidden" name="id" id="file-id">
                            <input type="hidden" name="ext" id="file-ext">
                            <input type="text" class="form-control" id="file-name" name="file_name" required>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Rename</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="moveFile" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title" id="staticBackdropLabel">Move "<span id="file-name-display"></span>"</h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="moveFileForm" method="post" action="/moveFile">
                        <input type="hidden" id="file-id" name="file_id">
                        <input type="hidden" id="selected-folder" name="target_folder">
                        <input type="hidden" id="file-name" name="file_name">
                        <div class="form-group">
                            <ul class="list-group list-group-flush" id="folder-list">
                                <?php foreach ($allFolders as $folder) : ?>
                                    <li class="list-group-item" data-folder="<?= $folder['slug'] ?>">
                                        <i class="fas fa-folder fa-lg mr-2"></i>
                                        <span class="btn-text"><?= $folder['folder_name'] ?></span>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary" id="move-button" disabled form="moveFileForm">Move</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="moveFolder" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title" id="staticBackdropLabel">Move "<span id="folder-name-display"></span>"</h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="moveFolderForm" method="post" action="/moveFolder">
                        <input type="hidden" id="folder-id" name="folder_id">
                        <input type="hidden" id="selected" name="target_folder">
                        <input type="hidden" id="folder-name" name="folder_name">
                        <div class="form-group">
                            <ul class="list-group list-group-flush" id="folder-move-list">

                                <?php foreach ($allFolders as $folder) : ?>
                                    <li class="list-group-item" data-folder="<?= $folder['slug'] ?>">
                                        <i class="fas fa-folder fa-lg mr-2"></i>
                                        <span class="btn-text"><?= $folder['folder_name'] ?></span>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary" id="move-folder-button" disabled form="moveFolderForm">Move</button>
                </div>
            </div>
        </div>
    </div>






    <!-- Bootstrap JS and dependencies -->
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.1.3/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous"></script>
    <!-- Font Awesome for icons -->
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
    <!-- SweetAlert2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://unpkg.com/dropzone@6.0.0-beta.1/dist/dropzone-min.js"></script>
    <script src="https://unpkg.com/dropzone@5/dist/min/dropzone.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.6.347/pdf.min.js"></script>
    <script src="https://viewerjs.org/ViewerJS/js/viewer.js"></script>
    <script src="https://vjs.zencdn.net/7.20.3/video.min.js"></script>

    <script>
        document.onreadystatechange = function() {
            if (document.readyState !== "complete") {
                document.querySelector("#loading-screen").style.visibility = "visible";
            } else {
                setTimeout(function() {
                    document.querySelector("#loading-screen").style.display = "none";
                    document.querySelector("main").style.visibility = "visible";
                });
            }
        };
    </script>
    <script>
        $('#renameFolder').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget);
            var id = button.data('id');
            var name = button.data('name');

            var modal = $(this);
            modal.find('#folder-id').val(id);
            modal.find('#folder-name').val(name);
        });
    </script>
    <script>
        $('#renameFile').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget);
            var id = button.data('id');
            var name = button.data('name');
            var filenameWithoutExt = name.split('.').slice(0, -1).join('.');
            var filenameExt = name.split('.').pop();

            var modal = $(this);
            modal.find('#file-id').val(id);
            modal.find('#file-name').val(filenameWithoutExt);
            modal.find('#file-ext').val(filenameExt);
        });
    </script>
    <script>
        $('#moveFile').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget);
            var id = button.data('id');
            var name = button.data('name');

            var modal = $(this);
            modal.find('#file-id').val(id);
            modal.find('#file-name').val(name);
            modal.find('#file-name-display').text(name);
            modal.find('#selected-folder').val('');
            $('#move-button').prop('disabled', true);
            $('#folder-list .list-group-item').removeClass('active');
        });

        $('#folder-list').on('click', '.list-group-item', function() {
            $('#folder-list .list-group-item').removeClass('active');
            $(this).addClass('active');
            var selectedFolder = $(this).data('folder');
            $('#selected-folder').val(selectedFolder);
            $('#move-button').prop('disabled', false);
        });

        $('#moveFileForm').on('submit', function(event) {
            if ($('#selected-folder').val() === '') {
                event.preventDefault();
                alert('Please select a folder to move the file.');
            }
        });
    </script>
    <script>
        $(document).ready(function() {
            $('#moveFolder').on('show.bs.modal', function(event) {
                var button = $(event.relatedTarget);
                var id = button.data('id');
                var name = button.data('name');

                var modal = $(this);
                modal.find('#folder-id').val(id);
                modal.find('#folder-name').val(name);
                modal.find('#folder-name-display').text(name);
                modal.find('#selected').val('');
                $('#move-folder-button').prop('disabled', true);
                $('#folder-move-list .list-group-item').removeClass('active');
            });

            $('#folder-move-list').on('click', '.list-group-item', function() {
                $('#folder-move-list .list-group-item').removeClass('active');
                $(this).addClass('active');
                var selectedFolder = $(this).data('folder');
                $('#selected').val(selectedFolder);
                $('#move-folder-button').prop('disabled', false);
            });

            $('#moveFolderForm').on('submit', function(event) {
                if ($('#selected').val() === '') {
                    event.preventDefault();
                    alert('Please select a folder to move the folder.');
                }
            });
        });
    </script>
    <script>
        function Delete(event) {
            event.preventDefault();

            Swal.fire({
                title: 'Are you sure?',
                text: "This folder will be moved to the Trash",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Move to trash'
            }).then((result) => {
                if (result.isConfirmed) {
                    event.target.parentElement.submit();
                }
            });
        }
    </script>
    <script>
        function fileDelete(event) {
            event.preventDefault();

            Swal.fire({
                title: 'Are you sure?',
                text: "This file will be moved to the Trash",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Move to trash'
            }).then((result) => {
                if (result.isConfirmed) {
                    event.target.parentElement.submit();
                }
            });
        }
    </script>
    <script>
        function deleteTrash(event) {
            event.preventDefault();
            Swal.fire({
                title: 'Delete forever?',
                text: "All items in the trash will be deleted forever and you won't be able to restore it",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Delete forever'
            }).then((result) => {
                if (result.isConfirmed) {
                    event.target.parentElement.submit();
                }
            });
        }

        function deleteFile(event) {
            event.preventDefault();
            var fileName = event.target.parentElement.querySelector('[name="fileName"]').value;
            Swal.fire({
                title: 'Delete forever?',
                text: fileName + " will be deleted forever and you won't be able to restore it",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Delete forever'
            }).then((result) => {
                if (result.isConfirmed) {
                    event.target.parentElement.submit();
                }
            });
        }

        function deleteFolder(event) {
            event.preventDefault();
            var folderName = event.target.parentElement.querySelector('[name="folderName"]').value;
            Swal.fire({
                title: 'Delete forever?',
                text: folderName + " will be deleted forever and you won't be able to restore it",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'forever'
            }).then((result) => {
                if (result.isConfirmed) {
                    event.target.parentElement.submit();
                }
            });
        }
    </script>
    <script>
        $(document).ready(function() {
            <?php if (session()->getFlashdata('success_message')) : ?>
                Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: '<?= session()->getFlashdata('success_message') ?>',
                });
            <?php endif; ?>
        });
    </script>
    <script>
        $(document).ready(function() {
            <?php if (session()->getFlashdata('error_message')) : ?>
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: '<?= session()->getFlashdata('error_message') ?>',
                });
            <?php endif; ?>
        });
    </script>
    <script>
        var myDropzone = new Dropzone("#kt_dropzonejs_example_1", {
            url: "<?= base_url('user/addFiles') ?>",
            paramName: "file",
            maxFiles: 10,
            maxFilesize: null,
            init: function() {
                this.on("complete", function(file) {
                    if (this.getUploadingFiles().length === 0 && this.getQueuedFiles().length === 0) {
                        location.reload();
                    }
                });
            }
        });
    </script>
    <script>
        var urlSegments = window.location.pathname.split('/');
        var lastSegment = urlSegments[urlSegments.length - 1];
        var url = "<?= base_url('user/addFiles/') ?>" + lastSegment;
        var myDropzone = new Dropzone("#kt_dropzonejs_example_2", {
            url: url,
            paramName: "file",
            maxFiles: 10,
            init: function() {
                this.on("complete", function(file) {
                    if (this.getUploadingFiles().length === 0 && this.getQueuedFiles().length === 0) {
                        location.reload();
                    }
                });
            }
        });
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            document.querySelectorAll('.file-item').forEach(fileItem => {
                const fileNameElement = fileItem.querySelector('.file-name');
                const fileUrlElement = fileItem.querySelector('.file-url');
                const folderNameElement = fileItem.querySelector('.folder-name');
                const fileName = fileNameElement.textContent.trim();
                let folderName = null;
                if (folderNameElement) {
                    folderName = folderNameElement.textContent.trim();
                }
                const fileExtension = fileName.slice(fileName.lastIndexOf('.')).toLowerCase();
                const previewContainer = fileItem.querySelector('.file-preview');
                let fileUrl = '<?= base_url() ?>' + fileUrlElement.textContent.trim() + fileName;

                let iconClass = '';
                let iconColor = '';

                switch (fileExtension) {
                    case '.jpg':
                    case '.jpeg':
                    case '.png':
                    case '.gif':
                        iconClass = 'fas fa-file-image';
                        iconColor = 'red';
                        const img = document.createElement('img');
                        img.src = fileUrl;
                        img.classList.add('img');
                        previewContainer.appendChild(img);
                        break;
                    case '.pdf':
                        iconClass = 'fas fa-file-pdf';
                        iconColor = 'red';
                        const pdfIcon = document.createElement('i');
                        pdfIcon.className = iconClass;
                        pdfIcon.style.color = iconColor;
                        pdfIcon.style.fontSize = '120px';
                        previewContainer.appendChild(pdfIcon);
                        break;
                    case '.txt':
                        iconClass = 'fas fa-file-alt';
                        iconColor = 'blue';
                        fetch(fileUrl)
                            .then(response => {
                                if (!response.ok) {
                                    throw new Error('Network response was not ok');
                                }
                                return response.text();
                            })
                            .then(data => {
                                const textPreview = document.createElement('pre');
                                textPreview.textContent = data;
                                previewContainer.appendChild(textPreview);
                            })
                            .catch(error => {
                                console.error('Error fetching text file:', error);
                            });
                        break;
                    case '.doc':
                    case '.docx':
                        iconClass = 'fas fa-file-word';
                        iconColor = 'blue';
                        const wordIcon = document.createElement('i');
                        wordIcon.className = iconClass;
                        wordIcon.style.color = iconColor;
                        wordIcon.style.fontSize = '120px';
                        previewContainer.appendChild(wordIcon);
                        break;
                    case '.xls':
                    case '.xlsx':
                        iconClass = 'fas fa-file-excel';
                        iconColor = 'green';
                        const excelIcon = document.createElement('i');
                        excelIcon.className = iconClass;
                        excelIcon.style.color = iconColor;
                        excelIcon.style.fontSize = '120px';
                        previewContainer.appendChild(excelIcon);
                        break;
                    case '.ppt':
                    case '.pptx':
                        iconClass = 'fas fa-file-powerpoint';
                        iconColor = 'yellow';
                        const pptIcon = document.createElement('i');
                        pptIcon.className = iconClass;
                        pptIcon.style.color = iconColor;
                        pptIcon.style.fontSize = '120px';
                        previewContainer.appendChild(pptIcon);
                        break;
                    case '.zip':
                    case '.rar':
                        iconClass = 'fas fa-file-archive';
                        iconColor = 'orange';
                        const archiveIcon = document.createElement('i');
                        archiveIcon.className = iconClass;
                        archiveIcon.style.color = iconColor;
                        archiveIcon.style.fontSize = '120px';
                        previewContainer.appendChild(archiveIcon);
                        break;
                    case '.mp3':
                    case '.wav':
                        iconClass = 'fas fa-file-audio';
                        iconColor = 'red';
                        const audio = document.createElement('audio');
                        audio.controls = true;
                        audio.controlsList = 'nodownload noplaybackrate';
                        audio.src = fileUrl;
                        previewContainer.appendChild(audio);
                        break;
                    case '.mp4':
                    case '.avi':
                    case '.mkv':
                        iconClass = 'fas fa-file-video';
                        iconColor = 'red';
                        const video = document.createElement('video');
                        video.controls = true;
                        video.controlsList = 'nofullscreen nodownload noplaybackrate';
                        video.disablePictureInPicture = true;
                        video.src = fileUrl;
                        video.classList.add('img');
                        previewContainer.appendChild(video);
                        break;
                    default:
                        iconClass = 'fas fa-file';
                        iconColor = 'grey';
                        const defaultIcon = document.createElement('i');
                        defaultIcon.className = iconClass;
                        defaultIcon.style.color = iconColor;
                        defaultIcon.style.fontSize = '120px';
                        previewContainer.appendChild(defaultIcon);
                        break;
                }

                const iconElement = document.createElement('i');
                iconElement.className = iconClass;
                iconElement.style.color = iconColor;
                fileItem.querySelector('.file-icon').appendChild(iconElement);
            });
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            function adjustDropdownPosition() {
                document.querySelectorAll('.dropdown-submenu.dropright').forEach(function(element) {
                    var rect = element.getBoundingClientRect();
                    if (rect.right >= window.innerWidth) {
                        element.classList.remove('dropright');
                        element.classList.add('dropleft');
                    } else {
                        element.classList.remove('dropleft');
                        element.classList.add('dropright');
                    }
                });
            }
            adjustDropdownPosition();
            window.addEventListener('resize', adjustDropdownPosition);
            document.querySelectorAll('.dropdown-submenu .dropdown-toggle').forEach(function(element) {
                element.addEventListener('click', function(e) {
                    e.preventDefault();
                    e.stopPropagation();

                    var parent = e.target.closest('.dropdown-submenu');
                    parent.classList.toggle('show');
                    var subMenu = parent.querySelector('.dropdown-menu');
                    if (subMenu) {
                        subMenu.classList.toggle('show');
                    }
                });
            });
            document.addEventListener('click', function(e) {
                if (!e.target.closest('.dropdown-menu')) {
                    document.querySelectorAll('.dropdown-menu.show').forEach(function(menu) {
                        menu.classList.remove('show');
                    });
                    document.querySelectorAll('.dropdown-submenu.show').forEach(function(submenu) {
                        submenu.classList.remove('show');
                    });
                }
            });
            document.querySelectorAll('.dropdown').forEach(function(dropdown) {
                dropdown.addEventListener('hide.bs.dropdown', function() {
                    this.querySelectorAll('.dropdown-submenu .show').forEach(function(submenu) {
                        submenu.classList.remove('show');
                    });
                });
            });
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const addFileButton = document.getElementById('addFileButton');
            const addFileForm = document.getElementById('addFileForm');
            addFileButton.addEventListener('click', function() {
                addFileForm.style.display = addFileForm.style.display === 'none' ? 'block' : 'none';
            });
        });
    </script>
    <script>
        var progressBar = document.getElementById('progressBar');

        function setProgress(percent) {
            var roundedPercent = Math.round(percent);
            progressBar.style.width = roundedPercent + '%';
            progressBar.innerHTML = roundedPercent + '%';
        }
        var currentNumber = <?= $size ?>;
        var totalNumber = 16106127360;
        var percent = (currentNumber / totalNumber) * 100;
        setProgress(percent);
    </script>
</body>

</html>