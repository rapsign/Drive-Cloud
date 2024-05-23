<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - User List</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.7/css/dataTables.dataTables.css" />
    <!-- SweetAlert2 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <style>
        /* Embedded CSS styles */
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f8f9fa;
        }

        .main-content {
            margin-top: 60px;
            /* Adjust according to your navbar height */
        }

        .navbar-brand,
        .navbar-nav .nav-link {
            color: white !important;
            /* White color */
        }

        .table {
            width: 100%;
            margin-bottom: 1rem;
            color: #212529;
            border-collapse: collapse;
            padding: 0px;
        }

        .table th,
        .table td {
            padding: .75rem;
            vertical-align: top;
            border-top: 1px solid #dee2e6;
        }

        .table thead th {
            vertical-align: bottom;
            border-bottom: 2px solid #dee2e6;
        }

        .table tbody+tbody {
            border-top: 2px solid #dee2e6;
        }

        .table-sm th,
        .table-sm td {
            padding: .7rem;
        }

        .table-bordered {
            border: 1px solid #dee2e6;
        }

        .table-bordered th,
        .table-bordered td {
            border: 1px solid #dee2e6;
        }

        .table-bordered thead th,
        .table-bordered thead td {
            border-bottom-width: 2px;
        }

        .table-striped tbody tr:nth-of-type(odd) {
            background-color: rgba(0, 0, 0, .05);
        }

        .table-hover tbody tr:hover {
            background-color: rgba(0, 0, 0, .075);
        }
    </style>
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar navbar-light bg-primary">
        <div class="container">
            <a class="navbar-brand">Cloud Storage</a>
            <a href="#" type="button" class="btn text-white my-2 my-sm-0"><i class="fas fa-sign-out-alt"></i></a>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="container main-content">
        <div class="pt-3 pb-2 mb-3 border-bottom">
            <h1 class="h2">Users</h1>
            <div class="btn-toolbar mb-2 mb-md-0">
                <button type="button" class="btn btn-sm btn-secondary" data-toggle="modal" data-target="#addUser">Add User</button>
                <button class="btn btn-success btn-sm" style="margin-left: 10px;" data-toggle="modal" data-target="#addUserExcel">Add User With Excel</button>
            </div>
        </div>

        <!-- User List Table -->
        <table id="myTable" class="table table-striped table-sm " style="width:100%">
            <thead>
                <tr>
                    <th class="text-center">NO</th>
                    <th class="text-center">Username</th>
                    <th class="text-center">Name</th>
                    <th class="text-center">Role</th>
                    <th class="text-center">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php $i = 1; ?>
                <?php foreach ($users as $user) : ?>
                    <tr>
                        <td class="text-center"><?= $i++ ?></td>
                        <td class="text-center"><?= $user['username'] ?></td>
                        <td class="text-center"><?= $user['name'] ?></td>
                        <td class="text-center"><?= $user['role_name'] ?></td>
                        <td class="text-center">
                            <button class="btn btn-sm btn-primary" data-toggle="modal" data-target="#editModal" onclick="openEditModal(<?= $user['id'] ?>)"><i class="fas fa-cog"></i></button>
                            <form id="deleteUserForm" action="<?= base_url('admin/deleteUser') ?>" method="post" class="d-inline">
                                <input type="hidden" name="userId" value="<?= $user['id'] ?>">
                                <button type="button" class="btn btn-sm btn-danger" onclick="confirmDelete(event)"><i class="fas fa-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
            <tfoot>
                <tr>
                    <th class="text-center">NO</th>
                    <th class="text-center">Username</th>
                    <th class="text-center">Name</th>
                    <th class="text-center">Role</th>
                    <th class="text-center">Action</th>
                </tr>
            </tfoot>
        </table>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="addUser" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Register</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="<?= base_url('admin/register'); ?>" method="post">
                        <?= csrf_field() ?>
                        <div class="form-group">
                            <label for="username">Username</label>
                            <input type="text" class="form-control <?= session('errors.username') ? 'is-invalid' : '' ?>" id="username" name="username" value="<?= old('username'); ?>">
                            <?php if (session('errors.username')) : ?>
                                <div class="invalid-feedback">
                                    <?= session('errors.username') ?>
                                </div>
                            <?php endif; ?>
                        </div>
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" class="form-control <?= session('errors.name') ? 'is-invalid' : '' ?>" id="name" name="name" value="<?= old('name'); ?>">
                            <?php if (session('errors.name')) : ?>
                                <div class="invalid-feedback">
                                    <?= session('errors.name') ?>
                                </div>
                            <?php endif; ?>
                        </div>
                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" class="form-control <?= session('errors.password') ? 'is-invalid' : '' ?>" id="password" name="password">
                            <?php if (session('errors.password')) : ?>
                                <div class="invalid-feedback">
                                    <?= session('errors.password') ?>
                                </div>
                            <?php endif; ?>
                        </div>
                        <div class="form-group">
                            <label for="password_confirm">Confirm Password</label>
                            <input type="password" class="form-control <?= session('errors.password_confirm') ? 'is-invalid' : '' ?>" id="password_confirm" name="password_confirm">
                            <?php if (session('errors.password_confirm')) : ?>
                                <div class="invalid-feedback">
                                    <?= session('errors.password_confirm') ?>
                                </div>
                            <?php endif; ?>
                        </div>
                        <button type="submit" class="btn btn-primary">Register</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModal" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModal">Change Role</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="changeRoleForm" action="<?= base_url('admin/changeRole'); ?>" method="post">
                        <?= csrf_field() ?>
                        <input type="hidden" id="user_id" name="user_id" value="">
                        <div class="form-group">
                            <select id="role" name="role_id" class="form-control">
                                <option selected>Choose...</option>
                                <option value="1">Admin</option>
                                <option value="2">User</option>
                            </select>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" onclick="submitChangeRoleForm()">Save changes</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="addUserExcel" tabindex="-1" aria-labelledby="addUserExcel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addUserExcel">Add User</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="<?= base_url('admin/addUsersFromExcel') ?>" method="post" enctype="multipart/form-data">
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="exampleFormControlFile1" class="mb-3">Upload Excel File (.Xls Only)</label>
                            <input type="file" class="form-control-file" id="exampleFormControlFile1" name="excelFile" accept=".xlsx, .xls">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </form>

            </div>
        </div>
    </div>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.min.js" integrity="sha384-+sLIOodYLS7CIrQpBjl+C7nPvqq+FbNUBDunl/OZv93DB7Ln/533i8e/mZXLi/P+" crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/2.0.7/js/dataTables.js"></script>
    <!-- SweetAlert2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Script to open the modal if there are validation errors -->
    <script type="text/javascript">
        $(document).ready(function() {
            <?php if (session('showModal')) : ?>
                $('#registerModal').modal('show');
            <?php endif; ?>

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
            $('#myTable').DataTable();
        });
    </script>
    <script type="text/javascript">
        $(document).ready(function() {
            <?php if (session('showModalAdd')) : ?>
                $('#addUser').modal('show');
            <?php endif; ?>
        });
    </script>
    <script type="text/javascript">
        function submitChangeRoleForm() {
            document.getElementById('changeRoleForm').submit();
        }

        $(document).ready(function() {
            <?php if (session()->getFlashdata('success_message')) : ?>
                Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: '<?= session()->getFlashdata('success_message') ?>',
                });
            <?php endif; ?>

            <?php if (session('showModalRole')) : ?>
                $('#editModal').modal('show');
            <?php endif; ?>
        });

        // Example function to set user_id and open modal, call this function with appropriate user_id when needed
        function openEditModal(userId) {
            document.getElementById('user_id').value = userId;
            $('#editModal').modal('show');
        }
    </script>
    <script>
        function confirmDelete(event) {
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
        <?php if (session()->has('errors')) : ?>
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: '<?php echo implode('<br>', session('errors')) ?>',
            });
        <?php endif ?>
    </script>



</body>

</html>