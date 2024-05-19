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
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f8f9fa;
        }

        .navbar {
            background-color: #4285f4;
            color: white;
            position: relative;
            z-index: 1100;
            /* Ensure navbar is on top */
        }

        .navbar-brand,
        .nav-link {
            color: white !important;
        }

        /* CSS untuk tampilan daftar */
        .list-view .file-item {
            display: block;
        }

        /* CSS untuk tampilan ikon */
        .icon-view .file-item {
            display: inline-block;
        }


        .sidebar {
            background-color: #ffffff;
            border-right: 1px solid #dee2e6;
            padding: 20px 0;
            position: fixed;
            top: 0;
            left: 0;
            bottom: 0;
            z-index: 1000;
            overflow-y: auto;
            width: 250px;
            /* lebar sidebar */
        }

        .sidebar .nav-link {
            color: black !important;
        }

        .sidebar .nav-link i {
            margin-right: 10px;
        }

        .content {
            padding: 20px;
            margin-left: 250px;
            /* Adjust based on your sidebar width */
        }

        .file-item {
            margin-bottom: 15px;
        }

        .file-icon {
            font-size: 48px;
            margin-bottom: 10px;

        }

        .file-icon-i {

            margin-right: 20px;
        }



        .file-preview {
            width: 100%;
            height: 200px;
            /* Set a fixed height for the preview container */
            overflow: hidden;
            /* Hide any content that overflows the container */
        }

        .file-preview iframe {
            width: 100%;
            height: 100%;
            /* Ensure the iframe fills the preview container */
            border: none;
            /* Remove any border around the iframe */
        }

        .file-name {
            font-weight: 600;
            margin-bottom: 5px;
        }

        .card-header {
            background-color: #f8f9fa;
            border-bottom: 1px solid #dee2e6;
        }

        .card-footer {
            background-color: #f8f9fa;
            border-top: 1px solid #dee2e6;
        }

        .card {
            border: 1px solid #dee2e6;
            border-radius: 5px;
        }

        .card-body {
            padding: 20px;
        }

        .search-form {
            margin-bottom: 20px;
        }

        .search-form input[type="search"] {
            border-radius: 30px;
            /* More rounded corners */
            padding: 25px 20px;
            /* Adjust padding as needed */
            border: none;
            box-shadow: none;
            /* Remove default input styles */
            width: 85%;
            /* Full width input */
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }

        .search-form button[type="submit"] {
            border-radius: 30px;
            /* More rounded corners */
            padding: 10px 20px;
            /* Adjust padding as needed */
            margin-left: 10px;
            /* Add some space between input and button */
            background-color: #4285f4;
            color: white;
            border: none;
        }

        @media (max-width: 768px) {
            .sidebar {
                position: relative;
                width: 100%;
                /* Lebar maksimum saat mode mobile */
            }

            .content {
                margin-left: 0;
                /* Hapus margin pada mode mobile */
            }

            .navbar-brand a {
                display: none;
            }

            .navbar-brand img {
                display: inline;
                height: 80px;

            }
        }

        .nav-item.disabled .nav-link {
            pointer-events: none;
            /* Menonaktifkan klik pada tautan */
            cursor: default;
            /* Mengubah kursor menjadi default */
        }

        .nav-item.disabled .nav-link.active {
            pointer-events: none;
            /* Menonaktifkan klik pada tautan aktif */
        }

        .nav-item.disabled .nav-link {
            text-align: center;
            /* Mengatur teks menjadi tengah */
        }

        /* Menjadikan warna latar belakang form sedikit abu-abu */
        .search-form input[type="search"] {
            background-color: #e9ecef;
            /* Warna abu-abu */
        }

        /* Mengubah warna latar belakang form menjadi putih saat di klik */
        .search-form input[type="search"]:focus {
            background-color: #ffffff;
            /* Warna putih */
        }

        .dropdown-toggle.dropdown-toggle-no-caret::after {
            display: none;
            /* Hide the caret */
        }
    </style>
</head>

<body>
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
                            <a class="nav-link active" href="#">
                                Cloud Storage
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                <i class="fas fa-desktop"></i> Computers
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                <i class="fas fa-share-alt"></i> Shared with me
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                <i class="fas fa-history"></i> Recent
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                <i class="fas fa-star"></i> Starred
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                <i class="fas fa-trash-alt"></i> Trash
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>

            <!-- Main Content -->
            <main role="main" class="col-md-10 ml-sm-auto col-lg-10 px-md-4 content">
                <div class="search-form">
                    <form class="form-inline">
                        <input class="form-control mr-sm-2 rounded-pill" type="search" placeholder="Search in Drive" aria-label="Search">
                        <button class="btn btn-primary rounded-pill" type="submit"><i class="fas fa-search"></i></button>
                    </form>
                </div>

                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2">My Drive</h1>
                    <div class="btn-group mb-3" role="group">
                        <button type="button" class="btn btn-primary list-view-toggle"><i class="fas fa-list"></i></button>
                        <button type="button" class="btn btn-primary icon-view-toggle"><i class="fas fa-th-large"></i> </button>
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
                                    <th scope="col">Date</th>
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
        </div>
    </div>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
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
</body>

</html>