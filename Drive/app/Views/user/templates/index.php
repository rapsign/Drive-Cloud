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
</head>

<body>
    <div id="loading-screen">
        <div class="spinner-border text-primary" role="status">
            <span class="sr-only">Loading...</span>
        </div>
    </div>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light">
        <a class="navbar-brand" href="<?= base_url() ?>">
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
                    </ul>
                </div>
            </nav>

            <!-- Main Content -->
            <?= $this->renderSection('page-content'); ?>
        </div>
    </div>
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
                    <form action="<?= base_url('user/createFolder') ?>" method="post">
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
                    <button type="submit" class="btn btn-primary">Create</button>
                    </form>
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
        function Delete(event) {
            event.preventDefault(); // Menghentikan pengiriman formulir secara langsung

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
                    event.target.parentElement.submit(); // Teruskan penghapusan
                }
            });
        }
    </script>
    <script>
        function DeleteFolder(event) {
            event.preventDefault(); // Menghentikan pengiriman formulir secara langsung

            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    event.target.parentElement.submit(); // Teruskan penghapusan
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
        var myDropzone = new Dropzone("#kt_dropzonejs_example_1", {
            url: "<?= base_url('user/addFiles') ?>", // Set the url for your upload script location
            paramName: "file", // The name that will be used to transfer the file
            maxFiles: 10,
        });
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            document.querySelectorAll('.file-item').forEach(fileItem => {
                const fileNameElement = fileItem.querySelector('.file-name');
                const fileName = fileNameElement.textContent.trim();
                const fileExtension = fileName.slice(fileName.lastIndexOf('.')).toLowerCase();
                const iconContainer = fileItem.querySelector('.file-icon');

                let iconClass = '';
                let iconColor = '';

                switch (fileExtension) {
                    case '.jpg':
                    case '.jpeg':
                    case '.png':
                    case '.gif':
                        iconClass = 'fas fa-file-image';
                        iconColor = 'red';
                        break;
                    case '.pdf':
                        iconClass = 'fas fa-file-pdf';
                        iconColor = 'red';
                        break;
                    case '.txt':
                        iconClass = 'fas fa-file-alt';
                        iconColor = 'blue';
                        break;
                    case '.doc':
                    case '.docx':
                        iconClass = 'fas fa-file-word';
                        iconColor = 'blue';
                        break;
                    case '.xls':
                    case '.xlsx':
                        iconClass = 'fas fa-file-excel';
                        iconColor = 'green';
                        break;
                    case '.ppt':
                    case '.pptx':
                        iconClass = 'fas fa-file-powerpoint';
                        iconColor = 'orange';
                        break;
                    case '.zip':
                    case '.rar':
                        iconClass = 'fas fa-file-archive';
                        iconColor = 'grey';
                        break;
                    case '.mp3':
                    case '.wav':
                        iconClass = 'fas fa-file-audio';
                        iconColor = 'red';
                        break;
                    case '.mp4':
                    case '.avi':
                    case '.mkv':
                        iconClass = 'fas fa-file-video';
                        iconColor = 'red';
                        break;
                    default:
                        iconClass = 'fas fa-file';
                        iconColor = 'grey';
                }

                const iconElement = document.createElement('i');
                iconElement.className = iconClass;
                iconElement.style.color = iconColor;
                iconContainer.appendChild(iconElement);
            });
        });
    </script>
</body>

</html>