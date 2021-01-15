<?php
    session_start();
    require '../../config.php';

    if ( (empty($_SESSION['user_id']) && empty($_SESSION['logged_in'])) || $_SESSION['role'] != 1 ) {
        header('Location: /admin/login.php');
    }

    $stmt = $pdo->prepare("
        DELETE FROM users WHERE id = ?
    ");
    $stmt->execute([$_GET['id']]);

    header('Location: /admin/users/index.php');