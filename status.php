<?php
header("Content-Type: application/json");
require "autoload.php";

$status = "OK";
// define it now so we dont have to define it later, it'll be edited in case of error

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
    $status = strtok($e, "\n"); // print only first line of error
}

try {
    $pdo->exec("describe LONGR"); // if table exist
} catch (\PDOException $e) {
    $status = strtok($e, "\n"); // print only first line of error
}

?>
{"status": "<?= $status ?>"}
