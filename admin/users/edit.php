<?php  
    session_start();
    require '../../config.php';

    if ( (empty($_SESSION['user_id']) && empty($_SESSION['logged_in'])) || $_SESSION['role'] != 1 ) {
        header('Location: /admin/login.php');
    }

    if ($_POST) {
        $id = $_POST['id'];
        $name = $_POST['name'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $role = empty($_POST['role']) ? 0 : 1;

        $stmt = $pdo->prepare("
            SELECT * FROM `users` WHERE `email` = ? AND `id` != ?
        ");
        $stmt->execute([$email, $id]);
        $user = $stmt->fetch();

        if ($user) {
            echo "<script>alert('Email is already exists.');</script>";
        } else {
            $stmt = $pdo->prepare("
                UPDATE users SET name = ?, email = ?, password = ?, role = ? WHERE id = ?
            ");
            $result = $stmt->execute([$name, $email, $password, $role, $id]);

            if ($result) {
                echo "<script>alert('Successfully Updated'); window.location.href='/admin/users/index.php';</script>";
            }
        }

    } 
        $id = $_GET['id'];

        $stmt = $pdo->prepare("
            SELECT * FROM users WHERE id = ?
        ");
        $stmt->execute([$id]);

        $user = $stmt->fetch();

        if (empty($user)) {
            die('Not Found');
        }

?>

<?php include '../../partials/header.php'; ?>

    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <!-- place_content -->
                <div class="col-md-12">
                    <div class="card">
                        <div class="bg-transparent px-3 py-3 border-bottom d-flex align-items-center justify-content-between">
                            <h3 class="card-title">Edit User</h3>
                            <div>
                                <a href="add.php" class="btn btn-sm btn-success">Add New</a>
                            </div>
                        </div>
                        <form role="form" action="" method="POST" enctype="multipart/form-data">
                            <input type="hidden" name="id" value="<?php echo $user->id; ?>">

                            <div class="card-body">
                                <div class="form-group">
                                    <label for="name">Name</label>
                                    <input type="text" name="name" class="form-control" id="name" value="<?php echo $user->name; ?>">
                                </div>
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input type="email" name="email" class="form-control" id="email" value="<?php echo $user->email; ?>">
                                </div>
                                <div class="form-group">
                                    <label for="password">Password</label>
                                    <input type="text" name="password" class="form-control" id="password" value="<?php echo $user->password; ?>">
                                </div>
                                <div class="form-group form-check">
                                    <input type="checkbox" class="form-check-input" id="role" name="role" <?php echo ($user->role) ? 'checked' : ''; ?>>
                                    <label class="form-check-label" for="role" value>Admin</label>
                                </div>
                            </div>
                            <!-- /.card-body -->
                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">Update</button>
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