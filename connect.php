<?php
            $servername = 'remotemysql.com:3306;dbname=Q2qsa8HqT2';
            $username = 'Q2qsa8HqT2';
            $password = 'vkN1eNSWhe';

            //On établit la connexion
            $conn = new mysqli($servername, $username, $password);

            //On vérifie la connexion
            if($conn->connect_error){
                die('Erreur : ' .$conn->connect_error);
            }
            echo 'Connexion réussie';
?>