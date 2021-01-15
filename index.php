<?php 
    session_start();
    require 'config.php';

    if ( 
        empty($_SESSION['user_id']) && empty($_SESSION['logged_in']) 
    ) {
        header('Location: login.php');
    }

    // pagination start
    if (isset($_GET['page'])) {
        $page = $_GET['page'];
    } else {
        $page = 1;
    }

    $per_page = 6;
    $offset = ($page - 1) * $per_page;
    // pagination end

    // count query start
    $stmt = $pdo->query("
        SELECT COUNT(*) as 'total' from `posts` 
    ");
    $aggregate = $stmt->fetch();
    $total = ceil($aggregate->total / $per_page);
    // count query end

    // query data start
    $stmt = $pdo->prepare("
        SELECT * FROM `posts` ORDER BY `id` DESC LIMIT :offset, :per_page
    ");
    $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);       /** note: PDO::PARAM_INT */
    $stmt->bindValue(':per_page', $per_page, PDO::PARAM_INT);
    $stmt->execute();
    $posts = $stmt->fetchAll();
    // query data end
 ?>

<?php include 'partials/blog_header.php'; ?>

<div class="content">
    <div class="container">
        <div class="row">

            <?php if ($posts) : foreach ($posts as $post) : ?>
            <div class="col-md-4">
                <div class="card card-widget">
                    <div class="bg-transparent px-4 py-3 border-bottom d-flex align-items-center justify-content-between">
                        <div class="card-title text-center"><?php echo $post->title; ?></div>
                    </div>
                    <div class="card-body" style="min-height: 260px;">
                        <img class="img-fluid pad" src="images/<?php echo $post->image; ?>" alt="There is no featured photo.">
                    </div>
                    <div class="card-footer">
                        <a href="blogdetail.php?id=<?php echo $post->id; ?>" class="btn btn-sm btn-primary float-right">Read More</a>
                    </div>
                </div>
            </div>
            <?php endforeach; endif; ?>
        </div>

        <div class="row py-4">
            <div class="col-12">
                <ul class="pagination pagination-sm m-0 d-flex justify-content-center">
                    <li class="page-item 
                        <?php if ($page <= 1) { echo 'disabled'; } ?>
                    ">
                        <a class="page-link px-4 py-2" href="?page=1">First</a>
                    </li>
                    <li class="page-item 
                        <?php if ($page <= 1) { echo 'disabled'; } ?>
                    ">
                        <a 
                            class="page-link px-4 py-2" 
                            href="<?php echo ($page <= 1) ? '#' : '?page=' . ($page - 1); ?>"
                        >Previous</a>
                    </li>
                    <li class="page-item">
                        <a class="page-link px-4 py-2" href="#"><?php echo $page; ?></a>
                    </li>
                    <li class="page-item 
                        <?php if ($page >= $total) { echo 'disabled'; }  ?>
                    ">
                        <a 
                            class="page-link px-4 py-2"
                            href="<?php echo ($page >= $total) ? '#' : '?page=' . ($page + 1); ?>"
                        >Next</a>
                    </li>
                    <li class="page-item 
                        <?php if ($page >= $total) { echo 'disabled'; }  ?>
                    ">
                        <a class="page-link px-4 py-2" href="?page=<?php echo $total; ?>">Last</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>


</div>

<?php include 'partials/blog_footer.php'; ?>