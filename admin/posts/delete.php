<?php

    require '../../config.php';

    $stmt = $pdo->prepare('
        DELETE FROM posts WHERE id = :id
    ');

    $stmt->bindValue(':id', $_GET['id']);
    $stmt->execute();

    header('Location: ../index.php');