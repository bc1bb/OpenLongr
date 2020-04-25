<?php

require "autoload.php";

add_header();

$dsn = "mysql:host=" . env("mysql_address") . ";dbname=" . env("mysql_database") . ";port=".env("mysql_port").";charset=utf8mb4";
$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES => false,
];
try {
    $pdo = new PDO($dsn, env("mysql_username"), env("mysql_password"), $options);
    $pdo->exec("use ". env("mysql_database"));
} catch (\PDOException $e) {
    die($e->getMessage()." ".(int)$e->getCode());
}

try {
    $req = $pdo->prepare("CREATE TABLE `LONGR` (
        `id` TEXT NOT NULL,
        `text` TEXT NOT NULL,
        `country` TEXT NOT NULL)");
    $req->execute();
    echo "You may safely delete this file.";
} catch (\PDOException $e) {
    if ($e->getCode() == 42) {
        echo "You may safely delete this file.";
    } else {
        echo $e->getMessage()." ".(int)$e->getCode();
    }
}

add_footer();