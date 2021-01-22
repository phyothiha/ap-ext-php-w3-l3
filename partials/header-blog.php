<div class="wrapper">
    <nav class="main-header navbar navbar-expand ml-0">                
        <div class="container">
            <!-- Right navbar links -->
            <?php if ( $_SESSION['role'] == 1 ) : ?>
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <a href="/admin/posts/index.php">
                        Dashboard 
                    </a>
              </li>
            </ul>
            <?php endif; ?>
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="btn btn-danger" href="/logout.php" role="button">
                        Logout <i class="fas fa-sign-out-alt ml-1"></i>
                    </a>
              </li>
            </ul>
        </div>
    </nav>
    <div class="content-wrapper m-0">
        <section class="content-header py-4 text-center">
            <div class="container-fluid">
                <div class="col-sm-12">
                    <h1>Blog Site</h1>
                </div>
            </div>
        </section>