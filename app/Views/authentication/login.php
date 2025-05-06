<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <!-- SweetAlert2 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            background-color: #f8f9fa;
        }

        .swal2-popup {
            width: 300px !important;
        }

        .swal2-container {
            display: flex;
            align-items: flex-end;
            justify-content: flex-end;
            padding: 1.25rem;
        }

        .login-container {
            width: 100%;
            max-width: 400px;
            padding: 15px;
            background-color: #ffffff;
            border: 1px solid #dee2e6;
            border-radius: 12px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);

        }
    </style>
</head>

<body>
    <div class="login-container">
        <div class="text-center my-5">
            <img src="<?= base_url() ?>/assets/img/logo.png" class="d-inline" alt="Drive Logo" width="200">
            <h3 class="font-weight-bold mt-3 font-italic text-danger"> CLOUD <span class="font-italic text-dark"> STORAGE</span></h3>
        </div>
        <form action="<?= base_url('login') ?>" method="post">
            <?= csrf_field() ?>
            <div class="form-group">
                <label for="username">username</label>
                <input type="text" class="form-control <?= session('errors.username') ? 'is-invalid' : '' ?> <?= session()->get('error') ? 'is-invalid' : '' ?>" id="username" aria-describedby="usernameHelp" value="<?= old('username') ?>" placeholder="Enter Username" name="username" autocomplete="off" autocorrect="off">
                <?php if (session('errors.username')) : ?>
                    <div class="invalid-feedback">
                        <?= session('errors.username') ?>
                    </div>
                <?php endif; ?>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" class="form-control <?= session('errors.password') ? 'is-invalid' : '' ?> <?= session()->get('error') ? 'is-invalid' : '' ?>" id="password" placeholder="Password" name="password" autocomplete="off" autocorrect="off">
                <?php if (session('errors.password')) : ?>
                    <div class="invalid-feedback">
                        <?= session('errors.password') ?>
                    </div>
                <?php endif; ?>
            </div>
            <button type="submit" class="btn btn-danger btn-block mb-3">Login</button>
        </form>
    </div>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <!-- SweetAlert2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(document).ready(function() {
            <?php if (session()->get('error')) : ?>
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: '<?= session()->get('error') ?>',
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                    didOpen: (toast) => {
                        toast.addEventListener('mouseenter', Swal.stopTimer);
                        toast.addEventListener('mouseleave', Swal.resumeTimer);
                    }
                });
            <?php endif ?>
        });
    </script>
    <script>
        $(document).ready(function() {
            <?php if (session()->get('error')) : ?>
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: '<?= session()->get('error') ?>',
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                    didOpen: (toast) => {
                        toast.addEventListener('mouseenter', Swal.stopTimer);
                        toast.addEventListener('mouseleave', Swal.resumeTimer);
                    }
                });
            <?php endif ?>
        });
    </script>
</body>

</html>