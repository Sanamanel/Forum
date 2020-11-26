<?php
    $mysqlServername = 'mysql:host=remotemysql.com:3306;dbname=Q2qsa8HqT2';
    $mysqlUsername = 'Q2qsa8HqT2';
    $mysqlPassword = 'vkN1eNSWhe';

    //On établit la connexion

    try{
        $conn = new PDO($mysqlServername, $mysqlUsername, $mysqlPassword);
        $conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
    }
    catch(PDOException $e){
        echo "Error" . $e->getMessage();
    }

  
?>
