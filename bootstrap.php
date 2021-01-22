<?php

session_start();

require 'config.php';
require 'helpers.php';
require 'view-template-helpers.php';

$REQUEST_URI = str_replace('.php', '', $_SERVER["REQUEST_URI"]);

if ( empty($_SESSION['_token']) ) {
    generate_token();
}

if ( $_SERVER['REQUEST_METHOD'] == 'POST' ) {
    
    if (! hash_equals( $_SESSION['_token'], $_POST['_token']) ) {
        get_template_part( 'partials/errors/419' );
        die();
    } else {
        generate_token();
    }
} 

if ( isset($_SESSION['user_id']) && ( $REQUEST_URI == '/login' || $REQUEST_URI == '/register' || $REQUEST_URI == '/admin/login' ) ) {
    header('Location: /');
    exit;
}

if( preg_match('/admin/i', $REQUEST_URI) && isset($_SESSION['user_id']) && $_SESSION['role'] != 1 ) {
    header('Location: /');
    exit;
}