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
$server = 'cl1-sql11';
$username   = 'p4670_5';
$password   = '80YRwB0gC9A';
$database   = 'p4670_5';
 
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