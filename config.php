<?php 

define('USER', 'root');
define('PASS', '');
define('HOST', 'localhost');
define('DBNAME', 'php');

$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ
];

$pdo = new PDO(
    'mysql:host=' . HOST . ';dbname=' . DBNAME, USER, PASS, $options
);