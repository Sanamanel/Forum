<?php
$dsn = 'mysql:host=localhost;dbname=forum';
$user = 'root';
$pass = '';

try {
    $con = new PDO($dsn, $user, $pass);
    $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Fail Connecting" . $e;
}


include("header.php");