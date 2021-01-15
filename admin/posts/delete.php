<?php

    require '../../config.php';

    $stmt = $pdo->prepare("
        DELETE FROM posts WHERE id = ?
    ");
    $stmt->execute([$_GET['id']]);

    header('Location: ../index.php');