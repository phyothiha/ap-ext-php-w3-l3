<?php  
    session_start();

    require '../../config.php';

    if ( empty($_SESSION['user_id'] && $_SESSION['logged_in']) ) {
        header('Location: login.php');
    }

    if ($_POST) {
        if ($_FILES['image']['name']) {
            $file =  '../../images/' . $_FILES['image']['name'];
            $image_type = pathinfo($file, PATHINFO_EXTENSION);

            $image_ext_type = ['jpeg', 'jpg', 'png'];

            if (! in_array($image_type, $image_ext_type) ) {
                echo "<script>alert('Image must be jpeg, jpg or png');</script>";
            } else {
                move_uploaded_file($_FILES['image']['tmp_name'], $file);

                // The query will run if uploaded file exists
                $stmt = $pdo->prepare('
                    INSERT INTO posts(title, content, image, author_id)
                    VALUES (:title, :content, :image, :author_id)
                ');

                $stmt->bindValue(':title', $_POST['title']);
                $stmt->bindValue(':content', $_POST['content']);
                $stmt->bindValue(':image', $_FILES['image']['name']);
                $stmt->bindValue(':author_id', $_SESSION['user_id']);
                $result = $stmt->execute();

                if ($result) {
                    echo "<script>alert('Successfully added.')</script>";
                }
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
                        <div class="card-header">
                            <h3 class="card-title">Add New Blog Post</h3>
                        </div>
                        <form role="form" action="add.php" method="POST" enctype="multipart/form-data">
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="title">Title</label>
                                    <input type="text" name="title" class="form-control" id="title" >
                                </div>
                                <div class="form-group">
                                    <label for="content">Content</label>
                                    <textarea class="form-control" id="content" name="content" rows="6" ></textarea>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputFile">File input</label>
                                    <div class="input-group">
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" id="exampleInputFile" name="image">
                                            <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                                        </div>
                                        <div class="input-group-append">
                                            <span class="input-group-text" id="">Upload</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- /.card-body -->
                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">Submit</button>
                                <a href="../index.php" class="btn btn-secondary">Back</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>

<?php include '../../partials/footer.php'; ?>