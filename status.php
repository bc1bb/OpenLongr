<?php
header("Content-Type: application/json");
require "autoload.php";

$database = "OK";
$status = "OK";
// define them now so we dont have to define then later, they will be edited in case of error

$dsn = "mysql:host=" . env("mysql_address") . ";dbname=" . env("mysql_database") . ";port=".env("mysql_port").";charset=utf8mb4";
$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES => false,
];
try {
    $pdo = new PDO($dsn, env("mysql_username"), env("mysql_password"), $options); // if connection working
    $pdo->exec("use ". env("mysql_database"));
} catch (\PDOException $e) {
    $database = strtok($e, "\n"); // print only first line of error
}

try {
    $pdo->exec("describe LONGR"); // if table exist
} catch (\PDOException $e) {
    $database = strtok($e, "\n"); // print only first line of error
}


?>
{"status": "<?= $status ?>","database": "<?= $database ?>"}
