<?php  
    session_start();
    require '../config.php';

    if ( empty($_SESSION['user_id'] && $_SESSION['logged_in']) ) {
        header('Location: login.php');
    }
?>

<?php include dirname(__DIR__) . '/partials/header.php'; ?>

    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <!-- place_content -->
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Blog Listing</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <a href="posts/add.php" class="btn btn-success mb-3">New Blog Post</a>

                            <?php 
                                $stmt = $pdo->query('
                                    SELECT * FROM posts ORDER BY id DESC
                                ');

                                $posts = $stmt->fetchAll();
                             ?>

                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th style="width: 10px">#</th>
                                        <th>Title</th>
                                        <th>Content</th>
                                        <th style="width: 40px">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>

                                <?php 
                                if ($posts) :
                                    foreach ($posts as $index => $post) :
                                 ?>

                                    <tr>
                                        <td><?php echo ++$index; ?></td>
                                        <td><?php echo $post->title; ?></td>
                                        <td>
                                            <?php echo substr($post->content, 0, 50); ?>
                                        </td>
                                        <td>
                                            <div class="btn-group">
                                                <a href="posts/edit.php?id=<?php echo $post->id; ?>" class="btn btn-sm btn-warning mr-2">Edit</a>
                                                <a onclick="return confirm('Are you sure you want to delete this item');" href="posts/delete.php?id=<?php echo $post->id; ?>" class="btn btn-sm btn-danger">Del</a>
                                            </div>
                                        </td>
                                    </tr>

                                <?php endforeach; endif; ?>

                                </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->
                    </div>
                </div>
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>

<?php include dirname(__DIR__) . '/partials/footer.php'; ?>