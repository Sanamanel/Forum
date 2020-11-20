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
//connect.php
$server = 'debrouxoyiforum.mysql.db';
$username   = 'debrouxoyiforum';
$password   = 'ox2hjJet3NmLg7JtmZY';
$database   = 'debrouxoyiforum';
 
if(!mysql_connect($server, $username,  $password))
{
    exit('Error: could not establish database connection');
}
if(!mysql_select_db($database)
{
    exit('Error: could not select the database');
}
?>
    </body>
</html>