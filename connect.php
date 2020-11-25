<?php
$dsn = 'mysql:host=remotemysql.com:3306;dbname=Q2qsa8HqT2';
$user = 'Q2qsa8HqT2';
$pass = 'vkN1eNSWhe';

try {
    $con = new PDO($dsn, $user, $pass);
    $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Fail Connecting" . $e;
}


include("header.php");