<?php  
    session_start();
    require '../../autoload.php';
    require 'logic/store.php';

    $stmt = $pdo->prepare("
        SELECT * FROM `posts` WHERE `id` = ?
    ");
    $stmt->execute([$_GET['id']]);

    $post = $stmt->fetch();
?>

<?php include '../../partials/header.php'; ?>
    
    <?php if (! empty($post)): ?>
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <!-- place_content -->
                <div class="col-md-12">
                    <div class="card">
                        <div class="bg-transparent px-3 py-3 border-bottom d-flex align-items-center justify-content-between">
                            <h3 class="card-title">Edit Blog Post</h3>
                            <div>
                                <a href="add.php" class="btn btn-sm btn-success">Add New</a>
                            </div>
                        </div>
                        <form role="form" action="" method="POST" enctype="multipart/form-data">
                            <?php method('PUT'); ?>
                            <?php csrf(); ?>
                            <input type="hidden" name="id" value="<?php echo $post->id; ?>">

                            <div class="card-body">
                                <div class="form-group">
                                    <label for="title">Title</label>
                                    <input type="text" name="title" class="form-control <?php echo isset($_SESSION['errorMessageBag']['title']) ? 'is-invalid' : ''; ?>" id="title" value="<?php old_input_value('title', $post->title); ?>">
                                    
                                    <?php if ( isset($_SESSION['errorMessageBag']['title']) ): ?>
                                        <div class="invalid-feedback"><?php echo $_SESSION['errorMessageBag']['title']; ?></div>
                                    <?php endif ?>
                                </div>
                                <div class="form-group">
                                    <label for="content">Content</label>
                                    <textarea class="form-control <?php echo isset($_SESSION['errorMessageBag']['content']) ? 'is-invalid' : ''; ?>" id="content" name="content" rows="6"><?php old_input_value('content', $post->content); ?></textarea>

                                    <?php if ( isset($_SESSION['errorMessageBag']['content']) ): ?>
                                        <div class="invalid-feedback"><?php echo $_SESSION['errorMessageBag']['content']; ?></div>
                                    <?php endif ?>
                                </div>
                                <div class="form-group">
                                    <label for="featured_image">Featured Image</label>
                                    <div class="input-group">
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input <?php echo isset($_SESSION['errorMessageBag']['featured_image']) ? 'is-invalid' : ''; ?>" id="featured_image" name="featured_image">
                                            <label class="custom-file-label" for="featured_image">Upload Featured Image</label>
                                        </div>
                                        <div class="input-group-append">
                                            <span class="input-group-text" id="">Upload</span>
                                        </div>
                                    </div>
                                    <?php if ( isset($_SESSION['errorMessageBag']['featured_image']) ): ?>
                                        <div class="invalid-feedback d-block"><?php echo $_SESSION['errorMessageBag']['featured_image']; ?></div>
                                    <?php endif ?>

                                    <?php if ($post->image) : ?>
                                    <div>
                                        <img src="<?php echo '../../images/' . $post->image; ?>" width="150" class="mt-2 mb-1">
                                        <p><?php echo $post->image; ?></p>
                                    </div>
                                    <?php endif; ?>
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