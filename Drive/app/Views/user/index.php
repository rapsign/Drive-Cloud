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
            background-color: #ffffff;
            border: 1px solid #dee2e6;
            border-radius: 5px;
            padding: 20px;
            margin-bottom: 15px;
            text-align: center;
        }

        .file-item:hover {
            background-color: #f1f3f4;
        }

        .file-icon {
            font-size: 48px;
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
    </style>
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light">
        <a class="navbar-brand" href="#">Drive</a>
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
                    <div class="col-md-12 file-item">
                        Folder 1
                    </div>
                    <div class="col-md-12 file-item">
                        Folder 2
                    </div>
                    <div class="col-md-12 file-item">
                        Document 1
                    </div>
                    <div class="col-md-12 file-item">
                        Document 2
                    </div>
                </div>

                <!-- Tampilan ikon -->
                <div class="row icon-view" style="display: none;">
                    <div class="col-md-3 col-6 file-item">
                        <div class="file-icon">
                            <i class="fas fa-folder"></i>
                        </div>
                        <div class="file-name">Folder 1</div>
                    </div>
                    <div class="col-md-3 col-6 file-item">
                        <div class="file-icon">
                            <i class="fas fa-folder"></i>
                        </div>
                        <div class="file-name">Folder 2</div>
                    </div>
                    <div class="col-md-3 col-6 file-item">
                        <div class="file-icon">
                            <i class="fas fa-file-alt"></i>
                        </div>
                        <div class="file-name">Document 1</div>
                    </div>
                    <div class="col-md-3 col-6 file-item">
                        <div class="file-icon">
                            <i class="fas fa-file-alt"></i>
                        </div>
                        <div class="file-name">Document 2</div>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
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
</body>

</html>