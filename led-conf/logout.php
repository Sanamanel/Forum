<?php
session_start();
session_unset();
session_destroy();
unset($_SESSION["var"]); // On efface la variable var
header("location: index.php" ) ; // On renvoie ensuite sur la page d'accueil
exit();
?>



    
