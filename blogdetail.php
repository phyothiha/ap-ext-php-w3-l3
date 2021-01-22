<?php 
    include 'bootstrap.php';

    if ($_GET) {
        $id = $_GET['id'];

        $stmt = $pdo->prepare("
            SELECT * FROM `posts` WHERE `id` = ?
        ");
        $stmt->execute([$id]);
        $post = $stmt->fetch();


        $comment_stmt = $pdo->prepare("
            SELECT `users`.`id`, `users`.`name` as 'author', comments.* FROM `comments` 
            LEFT JOIN `users`
            ON `users`.`id` = `comments`.`author_id`
            WHERE `post_id` = ?
            ORDER BY `comments`.`id` DESC
        ");
        $comment_stmt->execute([$id]);
        $post_comments = $comment_stmt->fetchAll();
    }

    if ($_POST) {
        $id = $_POST['id'];
        $comment = $_POST['comment'];

        $stmt = $pdo->prepare("
            INSERT INTO `comments`(`content`, `author_id`, `post_id`)
            VALUES (?, ?, ?)
        ");
        $result = $stmt->execute([$comment, $_SESSION['user_id'], $id]);

        if ($result) {
            header("Location: blogdetail.php?id=$id");
        }
    }
 ?>

<?php get_header( null, [
    'body_classes' => 'sidebar-mini'
]); ?>

<?php if (! empty($post)) : ?>
<div class="content">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card card-widget">
                    <div class="bg-transparent px-4 py-3 border-bottom d-flex align-items-center justify-content-between">
                        <div class="card-title text-center"><?php echo e( $post->title ); ?></div>
                        <div>
                            <a href="index.php" class="text-primary text-sm">Back to Posts Listing</a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="text-center">
                            <img class="img-fluid pad" src="<?php echo e( image_asset_url($post->image) ); ?>" alt="No Featured Image" width="500">
                        </div>
                        <div class="pt-3">
                            <p><?php echo e( $post->content ); ?></p>
                        </div>
                        <span class="float-right text-muted"><?php echo $comment_stmt->rowCount() . ' comment(s)' ?></span>
                    </div>
                    <div class="card-footer card-comments">
                        <h5 >Comments</h5>
                        <hr>
                        <?php if ($post_comments) : foreach ($post_comments as $comment) : ?>
                        <div class="card-comment">
                            <div class="comment-text ml-1">
                                <span class="username">
                                    <?php echo e( $comment->author ); ?>
                                    <span class="text-muted float-right"><?php echo date("h:i A", strtotime($comment->created_at)); ?></span>
                                </span>
                                <?php echo e( $comment->content ); ?>
                            </div>
                        </div>
                        <?php endforeach; endif; ?>
                        
                        <div class="card-footer">
                            <form action="" method="POST">
                                <?php csrf(); ?>

                                <input type="hidden" name="id" value="<?php echo $post->id; ?>">
                                <div class="img-push">
                                    <input type="text" name="comment" class="form-control form-control-sm" placeholder="Press enter to post comment">
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php else: ?>
    <?php not_found(); ?>
<?php endif; ?>

<?php get_footer(); ?>