<?php
            $servername = 'remotemysql.com:3306;dbname=Q2qsa8HqT2';
            $username = 'Q2qsa8HqT2';
            $password = 'vkN1eNSWhe';

            //On établit la connexion
            try{
                $conn = new PDO($servername, $username, $password);
                $conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
            }
            catch(PDOEXCEPTION $e){
                echo "Erro" . $e;
            }
            
?>