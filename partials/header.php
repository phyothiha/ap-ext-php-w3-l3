<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <title><?php echo isset($args["title"]) ? e($args["title"]) : "PHP Blog"; ?></title>
        <!-- Font Awesome Icons -->
        <link rel="stylesheet" href="/public/plugins/fontawesome-free/css/all.min.css">
        <!-- Ionicons -->
        <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
        <!-- icheck bootstrap -->
        <link rel="stylesheet" href="/public/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
        <!-- Theme style -->
        <link rel="stylesheet" href="/public/dist/css/adminlte.min.css">
        <!-- Google Font: Source Sans Pro -->
        <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
    </head>

    <body 
        class="hold-transition <?php echo isset($args["body_classes"]) ? e($args["body_classes"]) : ''; ?>" 
    >

    <?php if ( is_current_uri( '/' ) || is_current_uri( '/index' ) || is_current_uri( '/blogdetail' ) ) : ?>
        <?php get_header( 'blog' ); ?>
    <?php elseif ( is_current_uri( '/admin/posts/index' ) || is_current_uri( '/admin/posts/add' ) || is_current_uri( '/admin/posts/edit' ) || is_current_uri( '/admin/users/index' ) || is_current_uri( '/admin/users/add' ) || is_current_uri( '/admin/users/edit' ) ) : ?>
        <?php get_header( 'dashboard' ); ?>
    <?php endif; ?>
