<?php

ini_set('display_errors', '1');
error_reporting(E_ALL);

$db_server   = "localhost";
$db_database = "webshop";
$db_username = "root";
$db_password = "";

try {
    $db = new PDO("mysql:host=$db_server;dbname=$db_database;charset=utf8mb4", $db_username, $db_password);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

}
catch(PDOException $e) {
    echo $e-> getMessage();
}

?>