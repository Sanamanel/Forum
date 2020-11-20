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
            $servername = 'cl1-sql11';
            $username = 'p4670_5';
            $password = '80YRwB0gC9A';
            
            //On essaie de se connecter
            try{
                $conn = new PDO("mysql:host=$servername;dbname=p4670_5", $username, $password);
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