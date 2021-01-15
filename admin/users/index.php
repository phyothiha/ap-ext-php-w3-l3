<?php  
    session_start();
    require '../../config.php';

    if ( (empty($_SESSION['user_id']) && empty($_SESSION['logged_in'])) || $_SESSION['role'] != 1 ) {
        header('Location: /admin/login.php');
    }

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
   
    if (isset($_POST['search']) || isset($_COOKIE['search'])) {
        $search_query = $_POST['search'] ?? $_COOKIE['search'];

        setcookie('search', $search_query, 0, "/admin");
        
        // count query start
        $stmt = $pdo->prepare("
            SELECT COUNT(*) as 'total' from `users` WHERE `name` LIKE :search_query ORDER BY `id` DESC
        ");
        $stmt->bindValue(':search_query', "%{$search_query}%");
        $stmt->execute();
        $aggregate = $stmt->fetch();
        $total = ceil($aggregate->total / $per_page);
        // count query end

        // query data start
        $stmt = $pdo->prepare("
            SELECT * FROM `users` WHERE `name` LIKE :search_query ORDER BY `id` DESC LIMIT :offset, :per_page
        ");
        $stmt->bindValue(':search_query', "%{$search_query}%");
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->bindValue(':per_page', $per_page, PDO::PARAM_INT);
        $stmt->execute();
        $users = $stmt->fetchAll();
        // query data end
    } else {
        // count query start
        $stmt = $pdo->query("
            SELECT COUNT(*) as 'total' from `users` 
        ");
        $aggregate = $stmt->fetch();
        $total = ceil($aggregate->total / $per_page);
        // count query end

        // query data start
        $stmt = $pdo->prepare("
            SELECT * FROM `users` ORDER BY `id` DESC LIMIT :offset, :per_page
        ");
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);       /** note: PDO::PARAM_INT */
        $stmt->bindValue(':per_page', $per_page, PDO::PARAM_INT);
        $stmt->execute();
        $users = $stmt->fetchAll();
        // query data end
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
                            <h3 class="card-title">Users Listing</h3>
                        </div>
                        
                        <div class="card-body">
                            <a href="add.php" class="btn btn-success mb-3">New User</a>

                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th style="width: 10px">#</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th width="150px">Role</th>
                                        <th style="width: 40px">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>

                                <?php if ($users) : foreach ($users as $index => $user) : ?>
                                    <tr>
                                        <td><?php echo $index + 1 + $offset; ?></td>
                                        <td><?php echo $user->name; ?></td>
                                        <td>
                                            <?php echo $user->email; ?>
                                        </td>
                                        <td>
                                            <?php echo ($user->role) ? 'Admin' : 'User'; ?>
                                        </td>
                                        <td>
                                            <div class="btn-group">
                                                <a href="edit.php?id=<?php echo $user->id; ?>" class="btn rounded-0 btn-sm btn-outline-info mr-2"><i class="fa fa-edit"></i></a>
                                                <a onclick="return confirm('Are you sure you want to delete this item');" href="delete.php?id=<?php echo $user->id; ?>" class="btn rounded-0 btn-sm btn-outline-danger"><i class="fa fa-trash"></i></a>
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

<?php include '../../partials/footer.php'; ?>