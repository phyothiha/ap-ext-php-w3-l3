<?php  
    session_start();
    require '../../config.php';

    if ( (empty($_SESSION['user_id']) && empty($_SESSION['logged_in'])) || $_SESSION['role'] != 1 ) {
        header('Location: /admin/login.php');
    }

    if ($_POST) {
        $name = $_POST['name'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $role = empty($_POST['role']) ? 0 : 1;

        $check_user_stmt = $pdo->prepare("
            SELECT * FROM `users` WHERE `email` = ?
        ");
        $check_user_stmt->execute([$email]);
        $user_exists = $check_user_stmt->fetch();

        if ($user_exists) {
            echo "<script>alert('Email is already exists.');</script>";
        } else {
            $stmt = $pdo->prepare("
                INSERT INTO `users`(`name`, `email`, `password`, `role`)
                VALUES (?, ?, ?, ?)
            ");
            $result = $stmt->execute([$name, $email, $password, $role]);

            if ($result) {
                echo "<script>alert('Successfully Added.'); window.location.href='/admin/users/index.php';</script>";
            }
        }
    } 
?>

<?php include '../../partials/header.php'; ?>

    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <!-- place_content -->
                <div class="col-md-12">
                    <div class="card">
                        <div class="bg-transparent px-3 py-3 border-bottom">
                            <h3 class="card-name">Add New User</h3>
                        </div>
                        <form role="form" action="" method="POST">
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="name">Name</label>
                                    <input type="text" name="name" class="form-control" id="name">
                                </div>
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input type="email" name="email" class="form-control" id="email">
                                </div>
                                <div class="form-group">
                                    <label for="password">Password</label>
                                    <input type="text" name="password" class="form-control" id="password">
                                </div>
                                <div class="form-group form-check">
                                    <input type="checkbox" class="form-check-input" id="role" name="role">
                                    <label class="form-check-label" for="role" value>Admin</label>
                                </div>
                            </div>
                            <!-- /.card-body -->
                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">Submit</button>
                                <a href="index.php" class="btn btn-secondary">Back</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>

<?php include '../../partials/footer.php'; ?>