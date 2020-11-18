<?php
@mysql_connect("localhost","root","") or die("CONNEXION.PHP : Echec de connexion au serveur.");
@mysql_select_db("forum") or die("CONNEXION.PHP : Echec de sélection de la base.");
@mysql_query("SET NAMES 'utf8'") or die("CONNEXION.PHP : Problème de codage.");
?>