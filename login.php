<?php 
    session_start();
    require 'autoload.php';

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $validate->field([
            'email' => ['required', 'email:com,net', 'exists:users,email'],
            'password' => ['bail', 'required', 'exists:users,password'],
        ]);

        if (empty($_SESSION['errorMessageBag'])) {
            $email = $_POST['email'];
            $password = $_POST['password'];
            $role = 0;

            $stmt = $pdo->prepare("
                SELECT * FROM `users` WHERE `email` = ? AND `password` = ? AND `role` = ?
            ");
            $stmt->execute([$email, $password, $role]);
            $user = $stmt->fetch();

            $_SESSION['user_id'] = $user->id;
            $_SESSION['username'] = $user->name;
            $_SESSION['logged_in'] = time();
            $_SESSION['role'] = $role;

            header('Location: index.php');
        }
    }
 ?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <title>Blog</title>
        <!-- Font Awesome Icons -->
        <link rel="stylesheet" href="/plugins/fontawesome-free/css/all.min.css">
        <!-- icheck bootstrap -->
        <link rel="stylesheet" href="/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
        <!-- Theme style -->
        <link rel="stylesheet" href="/dist/css/adminlte.min.css">
        <!-- Google Font: Source Sans Pro -->
        <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
    </head>
    <body class="hold-transition login-page">
        <div class="login-box">
            <div class="login-logo">
                <a href="#"><b>Blog</b></a>
            </div>
            <div class="card">
                <div class="card-body login-card-body">
                    <p class="login-box-msg">Sign in to start your session</p>
                    <form action="" method="post">
                        <div class="mb-3">
                            <div class="input-group">
                                <input type="email" name="email" class="form-control <?php echo isset($_SESSION['errorMessageBag']['email']) ? 'is-invalid' : ''; ?>" placeholder="Email"  value="<?php old_input_value('email'); ?>">
                                <div class="input-group-append">
                                    <div class="input-group-text">
                                        <span class="fas fa-envelope"></span>
                                    </div>
                                </div>
                            </div>

                            <?php if ( isset($_SESSION['errorMessageBag']['email']) ): ?>
                                <div class="invalid-feedback d-block"><?php echo $_SESSION['errorMessageBag']['email']; ?></div>
                            <?php endif ?>
                        </div>
                        <div class="mb-3">
                            <div class="input-group">
                                <input type="password" name="password" class="form-control <?php echo isset($_SESSION['errorMessageBag']['password']) ? 'is-invalid' : ''; ?>" placeholder="Password">
                                <div class="input-group-append">
                                    <div class="input-group-text">
                                        <span class="fas fa-lock"></span>
                                    </div>
                                </div>
                            </div>

                            <?php if ( isset($_SESSION['errorMessageBag']['password']) ): ?>
                                <div class="invalid-feedback d-block"><?php echo $_SESSION['errorMessageBag']['password']; ?></div>
                            <?php endif ?>
                        </div>
                        <div class="row">
                            <button type="submit" class="btn btn-primary btn-block">Sign In</button>
                            <a type="button" href="register.php" class="btn btn-light btn-block">Register</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>


        <!-- REQUIRED SCRIPTS -->
        <!-- jQuery -->
        <script src="/plugins/jquery/jquery.min.js"></script>
        <!-- Bootstrap 4 -->
        <script src="/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
        <!-- AdminLTE App -->
        <script src="/dist/js/adminlte.min.js"></script>
    </body>
</html>