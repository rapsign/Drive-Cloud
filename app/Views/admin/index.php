<?= $this->extend('admin/templates/index'); ?>
<?= $this->section('page-content'); ?>
<div class="container main-content">
        <div class="pt-3 pb-2 mb-3 border-bottom">
            <h1 class="h2">Users</h1>
            <div class="btn-toolbar mb-2 mb-md-0">
                <button type="button" class="btn btn-sm btn-secondary" data-toggle="modal" data-target="#addUser">Add User</button>
                <button class="btn btn-success btn-sm" style="margin-left: 10px;" data-toggle="modal" data-target="#addUserExcel">Add User With Excel</button>
            </div>
        </div>

        <!-- User List Table -->
        <div class="table-responsive">
        <table id="myTable" class="table table-striped table-sm" style="width:100%">
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
                                <input type="hidden" name="name" value="<?= $user['name'] ?>">
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
    <?= $this->endSection(); ?>