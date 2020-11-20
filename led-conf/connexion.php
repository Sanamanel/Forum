<!DOCTYPE html>
<html>
    <head>
        <title>Connexion bdd</title>
        <meta charset="utf-8">
        <link rel="stylesheet" href="./assets/css/style.css">
    </head>
    <body>
        <h1>Bases de données MySQL</h1>  
        <?php
         $dbhost = 'remotemysql.com:3036';
         $dbuser = 'Q2qsa8HqT2';
         $dbpass = 'vkN1eNSWhe';
         $conn = mysqli_connect($dbhost, $dbuser, $dbpass);
         
         if(! $conn ) {
            die('Could not connect: ' . mysqli_error());
         }
         echo 'Connected successfully<br />';
         $sql = 'CREATE DATABASE TUTORIALS';
         $retval = mysqli_query( $sql, $conn );
         
         if(! $retval ) {
            die('Could not create database: ' . mysqli_error());
         }
         echo "Database TUTORIALS created successfully\n";
         mysqli_close($conn);
      ?>

    </body>
</html>
