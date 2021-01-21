<?php  
    session_start();
    require '../../autoload.php';
    require 'logic/store.php';

    $stmt = $pdo->prepare("
        SELECT * FROM `users` WHERE `id` = ?
    ");
    $stmt->execute([$_GET['id']]);

    $user = $stmt->fetch();
?>

<?php include '../../partials/header.php'; ?>
    
    <?php if (! empty($user)) : ?>
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
                            <?php method('PUT'); ?>
                            <?php csrf(); ?>
                            <input type="hidden" name="id" value="<?php echo $user->id; ?>">

                            <div class="card-body">
                                <div class="form-group">
                                    <label for="name">Name</label>
                                    <input type="text" name="name" class="form-control <?php echo isset($_SESSION['errorMessageBag']['name']) ? 'is-invalid' : ''; ?>" id="name" value="<?php old_input_value('name', $user->name); ?>">

                                    <?php if ( isset($_SESSION['errorMessageBag']['name']) ): ?>
                                        <div class="invalid-feedback"><?php echo $_SESSION['errorMessageBag']['name']; ?></div>
                                    <?php endif ?>
                                </div>
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input type="email" name="email" class="form-control <?php echo isset($_SESSION['errorMessageBag']['email']) ? 'is-invalid' : ''; ?>" id="email" value="<?php old_input_value('email', $user->email); ?>">

                                    <?php if ( isset($_SESSION['errorMessageBag']['email']) ): ?>
                                        <div class="invalid-feedback"><?php echo $_SESSION['errorMessageBag']['email']; ?></div>
                                    <?php endif ?>
                                </div>
                                <div class="form-group">
                                    <label for="password">Password <small class="text-success ml-1">* This user already has a password</small></label>
                                    <input type="password" name="password" class="form-control <?php echo isset($_SESSION['errorMessageBag']['password']) ? 'is-invalid' : ''; ?>" id="password">

                                    <?php if ( isset($_SESSION['errorMessageBag']['password']) ): ?>
                                        <div class="invalid-feedback"><?php echo $_SESSION['errorMessageBag']['password']; ?></div>
                                    <?php endif ?>
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
    <?php else: ?>
        <?php not_found_template(); ?>
    <?php endif; ?>

<?php include '../../partials/footer.php'; ?>