<?php  
    require '../../bootstrap.php';
    require 'logic/store.php';
    
    // pagination start
    if (isset($_GET['page'])) {
        $page = $_GET['page'];
    } else {
        $page = 1;
        unset($_COOKIE['search']);
        setcookie('search', null, 0, "/admin");
    }

    $per_page = 10;
    $offset = ($page - 1) * $per_page;
    // pagination end
   
    if (isset($_GET['search']) || isset($_COOKIE['search'])) {
        $search_query = $_GET['search'] ?? $_COOKIE['search'];

        setcookie('search', $search_query, 0, "/admin");

        // count query start
        $stmt = $pdo->prepare("
            SELECT COUNT(*) as 'total' from `posts` WHERE `title` LIKE :search_query ORDER BY `id` DESC
        ");
        $stmt->bindValue(':search_query', "%{$search_query}%");
        $stmt->execute();
        $aggregate = $stmt->fetch();
        $total = ceil($aggregate->total / $per_page);
        // count query end

        // query data start
        $stmt = $pdo->prepare("
            SELECT * FROM `posts` WHERE `title` LIKE :search_query ORDER BY `id` DESC LIMIT :offset, :per_page
        ");
        $stmt->bindValue(':search_query', "%{$search_query}%");
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->bindValue(':per_page', $per_page, PDO::PARAM_INT);
        $stmt->execute();
        $posts = $stmt->fetchAll();
        // query data end
    } else {
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
    }
?>

<?php get_header( null, [
    'body_classes' => 'sidebar-mini'
]); ?>

    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <!-- place_content -->
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Posts Listing</h3>
                        </div>
                        
                        <div class="card-body">
                            <a href="add.php" class="btn btn-success mb-3">New Blog Post</a>

                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th style="width: 10px">#</th>
                                        <th>Title</th>
                                        <th>Content</th>
                                        <th width="150px">Featured Image</th>
                                        <th style="width: 40px">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>

                                <?php if ($posts) : foreach ($posts as $index => $post) : ?>
                                    <tr>
                                        <td><?php echo $index + 1 + $offset; ?></td>
                                        <td><?php echo e($post->title); ?></td>
                                        <td>
                                            <?php echo e(substr($post->content, 0, 50)); ?>
                                        </td>
                                        <td>
                                            <img src="<?php echo e( image_asset_url($post->image) ); ?>" alt="No Featured Image" width="150">
                                        </td>
                                        <td>
                                            <div class="btn-group">
                                                <a href="../../blogdetail.php?id=<?php echo $post->id; ?>" class="btn rounded-0 btn-sm btn-outline-primary mr-2"><i class="fa fa-eye"></i></a>
                                                <a href="edit.php?id=<?php echo $post->id; ?>" class="btn rounded-0 btn-sm btn-outline-info mr-2"><i class="fa fa-edit"></i></a>
                                                <form role="form" action="" method="POST">
                                                    <?php method('DELETE'); ?>
                                                    <?php csrf(); ?>
                                                    <input type="hidden" name="id" value="<?php echo $post->id; ?>">
                                                    <button onclick="return confirm('Are you sure you want to delete this item');" type="submit" class="btn rounded-0 btn-sm btn-outline-danger"><i class="fa fa-trash"></i></button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; endif; ?>

                                </tbody>
                            </table>
                        </div>
                        
                        <div class="card-footer clearfix">
                            <ul class="pagination pagination-sm m-0 float-right">
                                <li class="page-item 
                                    <?php if ($page <= 1) { echo 'disabled'; } ?>
                                ">
                                    <a class="page-link" href="?page=1">First</a>
                                </li>
                                <li class="page-item 
                                    <?php if ($page <= 1) { echo 'disabled'; } ?>
                                ">
                                    <a 
                                        class="page-link" 
                                        href="<?php echo ($page <= 1) ? '#' : '?page=' . ($page - 1); ?>"
                                    >Previous</a>
                                </li>
                                <li class="page-item">
                                    <a class="page-link" href="#"><?php echo $page; ?></a>
                                </li>
                                <li class="page-item 
                                    <?php if ($page >= $total) { echo 'disabled'; }  ?>
                                ">
                                    <a 
                                        class="page-link"
                                        href="<?php echo ($page >= $total) ? '#' : '?page=' . ($page + 1); ?>"
                                    >Next</a>
                                </li>
                                <li class="page-item 
                                    <?php if ($page >= $total) { echo 'disabled'; }  ?>
                                ">
                                    <a class="page-link" href="?page=<?php echo $total; ?>">Last</a>
                                </li>
                            </ul>
                      </div>
                      
                    </div>
                </div>
            </div>
            
        </div>
    </div>

<?php get_footer(); ?>