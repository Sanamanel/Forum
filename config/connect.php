<?php
    $mysqlServername = 'mysql:host='.getenv("SQLSERVER").';dbname='.getenv("DBNAME").';charset=utf8mb4';
    $mysqlUsername = getenv('DBUSER');
    $mysqlPassword = getenv('DBPASS');
    print_r($mysqlServername.' / '. $mysqlUsername.' / '. $mysqlPassword);
    //On établit la connexion

    try{
        $conn = new PDO($mysqlServername, $mysqlUsername, $mysqlPassword);
        $conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
    }
    catch(PDOException $e){
        echo "Error" . $e->getMessage();
    }

  
?>
