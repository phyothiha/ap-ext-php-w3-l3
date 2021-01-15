<?php  
    session_start();
    require '../../config.php';

    if ( (empty($_SESSION['user_id']) && empty($_SESSION['logged_in'])) || $_SESSION['role'] != 1 ) {
        header('Location: /admin/login.php');
    }

    if ($_POST) {
        $title = $_POST['title'];
        $content = $_POST['content'];
        $author_id = $_SESSION['user_id'];

        if ($_FILES['image']['name']) {
            $image = $_FILES['image']['name'];

            $file =  '../../images/' . $image;
            $image_type = pathinfo($file, PATHINFO_EXTENSION);

            $image_ext_type = ['jpeg', 'jpg', 'png'];

            if (! in_array($image_type, $image_ext_type) ) {
                echo "<script>alert('Image must be jpeg, jpg or png');</script>";
            } else {
                move_uploaded_file($_FILES['image']['tmp_name'], $file);

                $stmt = $pdo->prepare("
                    INSERT INTO posts(title, content, image, author_id)
                    VALUES (?, ?, ?, ?)
                ");
                $result = $stmt->execute([$title, $content, $image, $author_id]);

                if ($result) {
                    echo "<script>alert('Successfully Added'); window.location.href='../index.php';</script>";
                }
            }
        }
        else {
            $stmt = $pdo->prepare("
                INSERT INTO posts(title, content, author_id)
                VALUES (?, ?, ?)
            ");
            $result = $stmt->execute([$title, $content, $author_id]);

            if ($result) {
                echo "<script>alert('Successfully Added'); window.location.href='../index.php';</script>";
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
                            <h3 class="card-title">Add New Blog Post</h3>
                        </div>
                        <form role="form" action="" method="POST" enctype="multipart/form-data">
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
                                    <label for="exampleInputFile">Featured Image</label>
                                    <div class="input-group">
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" id="exampleInputFile" name="image">
                                            <label class="custom-file-label" for="exampleInputFile">Upload Featured Image</label>
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