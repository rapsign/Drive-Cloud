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
</head>

<body>
    <div id="loading-screen">
        <div class="spinner-border text-primary" role="status">
            <span class="sr-only">Loading...</span>
        </div>
    </div>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light">
        <a class="navbar-brand" href="<?php base_url() ?>">
            <span class="d-none d-md-inline">Cloud Storage</span>
            <img src="<?= base_url() ?>/assets/img/logo-white.png" class="d-inline d-md-none" alt="Drive Logo" height="30">
        </a>
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
                            <a class="nav-link active" href="<?= base_url() ?>">
                                Cloud Storage
                            </a>
                        </li>
                        <li class="nav-item">
                            <div class="dropdown nav-link">
                                <button class="btn btn-plus dropdown-toggle dropdown-toggle-no-caret" id="dropdownMenuButton1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-plus"></i> New</button>
                                <div class="dropdown-menu dropdown-menu-right dropdown-menu-animated" aria-labelledby="dropdownMenuButton1">
                                    <a class="dropdown-item" href="<?= base_url('user/upload') ?>"><i class="fas fa-upload"></i> File Upload</a>
                                    <div class="dropdown-divider"></div> <!-- Divider line -->
                                    <a class="dropdown-item" type="button" data-toggle="modal" data-target="#staticBackdrop"><i class="fas fa-folder"></i> New Folder</a>
                                </div>
                            </div>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= base_url('user') ?>">
                                <i class="fas fa-home"></i> Home
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= base_url('user/recent') ?>">
                                <i class="fas fa-history"></i> Recent
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
                            <a class="nav-link" href="#">
                                <i class="fas fa-sign-out-alt"></i> logout
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>

            <!-- Main Content -->
            <?= $this->renderSection('page-content'); ?>
        </div>
    </div>
    <div class="modal fade modal-dialog modal-dialog-centered" id="staticBackdrop" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">New Folder</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="form-group">
                            <input type="text" class="form-control" id="folder" name="folder" value="Untitled folder">
                        </div>

                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary">Create</button>
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

    <script>
        // JavaScript untuk mengganti tampilan
        $(document).ready(function() {
            $('.list-view-toggle').click(function() {
                $('.list-view').show();
                $('.icon-view').hide();
            });

            $('.icon-view-toggle').click(function() {
                $('.list-view').hide();
                $('.icon-view').show();
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            $('.dropdown-toggle').dropdown();
        });
    </script>

    <script>
        // Assuming 'fileURL' is the URL of the file
        function loadFilePreview(fileURL) {
            var fileExtension = fileURL.split('.').pop().toLowerCase();
            var previewContainer = document.querySelector('.file-preview');

            if (fileExtension === 'pdf') {
                // If it's a PDF file, load a PDF viewer with dimensions matching the card body
                previewContainer.innerHTML = '<iframe src="' + fileURL + '" width="100%" height="100%"></iframe>';
            } else if (['png', 'jpg', 'jpeg', 'gif', 'bmp'].includes(fileExtension)) {
                // If it's an image file, load the image directly
                previewContainer.innerHTML = '<img src="' + fileURL + '" alt="File Preview" style="max-width: 100%; max-height: 100%;">';
            } else {
                // For other file types, you might not have a direct preview
                previewContainer.innerHTML = '<p>No preview available for this file type.</p>';
            }
        }

        // Example usage
        loadFilePreview('example.png');
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let clickCount = 0;
            const folderButton = document.getElementById('folderButton');
            const dropdownMenuButton = document.getElementById('dropdownMenuButton1');
            const dropdownMenu = document.querySelector('.dropdown-menu');

            folderButton.addEventListener('click', function(event) {
                clickCount++;
                setTimeout(function() {
                    if (clickCount === 1) {
                        // Single click: Show dropdown
                        dropdownMenu.classList.toggle('show');
                    } else if (clickCount === 2) {
                        // Double click: Navigate to new page
                        window.location.href = '<?= base_url('user/recent') ?>';
                    }
                    clickCount = 0;
                }, 300);
            });

            // Prevent dropdown from closing when clicking inside it
            dropdownMenu.addEventListener('click', function(event) {
                event.stopPropagation();
            });

            // Close dropdown when clicking outside
            document.addEventListener('click', function(event) {
                if (!folderButton.contains(event.target)) {
                    dropdownMenu.classList.remove('show');
                }
            });

            // Ensure dropdown toggles only when clicking the ellipsis
            dropdownMenuButton.addEventListener('click', function(event) {
                event.stopPropagation();
                dropdownMenu.classList.toggle('show');
            });
        });
    </script>
    <script>
        document.onreadystatechange = function() {
            if (document.readyState !== "complete") {
                document.querySelector("body").style.visibility = "hidden";
                document.querySelector("#loading-screen").style.visibility = "visible";
            } else {
                // Menunda penyembunyian loading screen selama 2 detik
                setTimeout(function() {
                    document.querySelector("#loading-screen").style.display = "none";
                    document.querySelector("body").style.visibility = "visible";
                }); // Ubah angka 2000 menjadi jumlah milidetik yang Anda inginkan
            }
        };
    </script>
    <script>
        var selectedFiles = [];

        $(document).ready(function() {
            var $dragDropArea = $('#drag-drop-area');

            $dragDropArea.on('dragover', function(e) {
                e.preventDefault();
                e.stopPropagation();
                $dragDropArea.addClass('dragging');
            });

            $dragDropArea.on('dragleave', function(e) {
                e.preventDefault();
                e.stopPropagation();
                $dragDropArea.removeClass('dragging');
            });

            $dragDropArea.on('drop', function(e) {
                e.preventDefault();
                e.stopPropagation();
                $dragDropArea.removeClass('dragging');
                selectedFiles = e.originalEvent.dataTransfer.files;
                displayPreview(selectedFiles);
            });

            $('#fileInput').on('change', function(e) {
                selectedFiles = e.target.files;
                displayPreview(selectedFiles);
            });

            function displayPreview(files) {
                $dragDropArea.empty(); // Kosongkan area drag-drop

                var $previewArea = $('<div class="preview-area"></div>');
                for (var i = 0; i < files.length; i++) {
                    var file = files[i];
                    var reader = new FileReader();
                    reader.onload = (function(theFile) {
                        return function(e) {
                            var fileType = theFile.type.split('/')[0];
                            if (fileType === 'image') {
                                $previewArea.append('<img src="' + e.target.result + '" alt="' + theFile.name + '">');
                            } else {
                                $previewArea.append('<div class="file-name">' + theFile.name + '</div>');
                            }
                        };
                    })(file);
                    reader.readAsDataURL(file);
                }
                $dragDropArea.append($previewArea);
                $dragDropArea.append('<button id="uploadButton" type="button" class="btn btn-success mt-3 upload-button">Upload Files</button>');
                $dragDropArea.append('<button id="cancelButton" type="button" class="btn btn-danger mt-3 cancel-button">Cancel</button>');

                $('#uploadButton').on('click', function() {
                    if (selectedFiles.length > 0) {
                        uploadFiles(selectedFiles);
                    } else {
                        alert('Please select files first.');
                    }
                });

                $('#cancelButton').on('click', function() {
                    location.reload(); // Menyegarkan halaman saat tombol batal diklik
                });
            }

            function uploadFiles(files) {
                for (var i = 0; i < files.length; i++) {
                    var file = files[i];
                    var fileInfo = `
                                    File Name: ${file.name}
                                    File Size: ${file.size} bytes
                                    File Type: ${file.type}
                                    `;
                    console.log(fileInfo);

                }
            }
        });
    </script>

</body>

</html>