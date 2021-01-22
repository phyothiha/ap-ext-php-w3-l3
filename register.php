<?php 
    require 'bootstrap.php';
    require 'src/Validate.php';

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $validate->field([
            'name' => ['required', 'min:5', 'max:20', 'unique:users,name'],
            'email' => ['required', 'email:com,net', 'unique:users,email'],
            'password' => ['required', 'min:8'],
        ]);

        if (empty($_SESSION['errorMessageBag'])) {
            $name = $_POST['name'];
            $email = $_POST['email'];
            $password = $_POST['password'];

            // encrypt password
            $password = password_hash($password, PASSWORD_DEFAULT);

            $stmt = $pdo->prepare("
                INSERT INTO `users`(`name`, `email`, `password`)
                VALUES (?, ?, ?)
            ");
            $result = $stmt->execute([$name, $email, $password]);

            if ($result) {
                echo "<script>alert('Successfully Register. You can now login.'); window.location.href='/login.php';</script>";
            } else {
                echo "<script>alert('Error');  window.location.href='/login.php';</script>";
            }
        }
    }
 ?>

<?php get_header( null, [
    'body_classes' => 'login-page'
]); ?>

    <div class="login-box">
        <div class="login-logo">
            <a href="#"><b>Blog</b></a>
        </div>
        <div class="card">
            <div class="card-body login-card-body">
                <p class="login-box-msg">User Registration</p>
                <form action="" method="post">
                    <?php csrf(); ?>
                    
                    <div class="mb-3">
                        <div class="input-group">
                            <input type="text" name="name" class="form-control <?php echo error('name') ? 'is-invalid' : ''; ?>" placeholder="Name"  value="<?php echo e( old('name') ); ?>">
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-user"></span>
                                </div>
                            </div>
                        </div>

                        <?php if ( error('name') ): ?>
                            <div class="invalid-feedback d-block"><?php echo e( error('name') ) ; ?></div>
                        <?php endif ?>
                    </div>

                    <div class="mb-3">
                        <div class="input-group">
                            <input type="email" name="email" class="form-control <?php echo error('email') ? 'is-invalid' : ''; ?>" placeholder="Email"  value="<?php echo e( old('email') ); ?>">
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-envelope"></span>
                                </div>
                            </div>
                        </div>

                        <?php if ( error('email') ): ?>
                            <div class="invalid-feedback d-block"><?php echo e( error('email') ) ; ?></div>
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

                        <?php if ( error('password') ): ?>
                            <div class="invalid-feedback d-block"><?php echo e( error('password') ); ?></div>
                        <?php endif ?>
                    </div>

                    <div class="row">
                        <button type="submit" class="btn btn-primary btn-block">Register</button>
                        <a type="button" href="login.php" class="btn btn-light btn-block">Sign In</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

<?php get_footer(); ?>