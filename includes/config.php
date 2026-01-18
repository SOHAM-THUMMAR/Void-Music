<?php

$host = getenv("DB_HOST");
$username = getenv("DB_USER");
$password = getenv("DB_PASS");
$dbname = getenv("DB_NAME");
$port = getenv("DB_PORT");

$con = new mysqli($host, $username, $password, $dbname, $port);

if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
}

// optional charset for safety
$con->set_charset("utf8mb4");

?>
