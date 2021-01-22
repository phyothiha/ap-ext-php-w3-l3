<?php if ( is_current_uri( '/' ) || is_current_uri( '/index' ) || is_current_uri( '/blogdetail' ) ) : ?>
    <?php get_footer( 'blog' ); ?>
<?php elseif ( is_current_uri( '/admin/posts/index' ) || is_current_uri( '/admin/posts/add' ) || is_current_uri( '/admin/posts/edit' ) || is_current_uri( '/admin/users/index' ) || is_current_uri( '/admin/users/add' ) || is_current_uri( '/admin/users/edit' ) ) : ?>
    <?php get_footer( 'dashboard' ); ?>
<?php else: ?>
        <!-- REQUIRED SCRIPTS -->
        <!-- jQuery -->
        <script src="/public/plugins/jquery/jquery.min.js"></script>
        <!-- Bootstrap 4 -->
        <script src="/public/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
        <!-- AdminLTE App -->
        <script src="/public/dist/js/adminlte.min.js"></script>
    </body>
</html>
<?php endif; ?>