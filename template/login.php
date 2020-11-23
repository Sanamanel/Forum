<?php

session_start();
if (isset($_SESSION['name'])) {
    header('Location: home.php');
}
include "init.php";

// include "include/template/header.php";

if ($_SERVER['REQUEST_METHOD'] === "POST") {
    $user = $_POST['firstname'];
    $password = $_POST['email'];
    echo $password;
    
    /*$hashPassword = sha1($password);

    $stmt = $con->prepare("select name,pass from user where name = ? and pass = ? and isAdmin = 1");
    $stmt->execute(array($user, $hashPassword));
    $count = $stmt->rowCount();

    if ($count > 0) {
        $_SESSION['name'] = $user;
        header('Location: home.php');
        exit();
    }*/
}

?>





<form class="login" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
    <div class="container">
        <input type="text" placeholder="UserName" class="form-control mt-2" autocomplete="off" name="user">
        <input type="password" placeholder="Password" class="form-control mt-2" autocomplete="off" name="pass">

        <button class="btn btn-primary text-capitalize mt-4" type="submit">log in</button>
    </div>
</form>

<?php
include $tpl . "footer.php";
?>