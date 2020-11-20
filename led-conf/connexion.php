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
            $servername = 'remotemysql.com:3306';
            $username = 'Q2qsa8HqT2 ';
            $password = 'vkN1eNSWhe';
            
            //On essaie de se connecter
            try{
                $conn = new PDO("mysql:host=$servername;dbname=Q2qsa8HqT2 ", $username, $password);
                //On définit le mode d'erreur de PDO sur Exception
                $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                echo 'Connexion réussie';
            }
            
            /*On capture les exceptions si une exception est lancée et on affiche
             *les informations relatives à celle-ci*/
            catch(PDOException $e){
              echo "Erreur : " . $e->getMessage();
            }
        ?>

    </body>
</html>