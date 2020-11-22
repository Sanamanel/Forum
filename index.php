<!--
=========================================================
Material Kit - v2.0.7
=========================================================

Product Page: https://www.creative-tim.com/product/material-kit
Copyright 2020 Creative Tim (https://www.creative-tim.com/)

Coded by Creative Tim

=========================================================

The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software. -->
<?php /*session_start();
require_once("connexion.php"); 
   if (isset($_POST["todo"])) {
		$lelogin= addslashes($_POST["login"]);
		$mdp= addslashes($_POST["mdp"]);
		
		//je vais vérifier si un admin correspond a ce login et ce mot de passe
		$sql = "SELECT * FROM t_users 
				WHERE user_login ='".$lelogin."'
				AND user_mdp ='".$mdp."' ";
		$rs = mysql_query($sql);
		$combienquiena = mysql_num_rows($rs);
		
		if ($combienquiena == 1) { // C'est qui en a un
			//Alors je crée la variable de session "log"
			$r = mysql_fetch_array($rs);
			$_SESSION["log"]=$r;
			//Et je redirige l'administrateur vers l'espace d'administration
			header("location:gestion_articles.php");
		}
		mysql_free_result($rs);
   }
*/
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <link
      rel="apple-touch-icon"
      sizes="76x76"
      href="./assets/img/apple-icon.png"
    />
    <link rel="icon" type="image/png" href="./assets/img/favicon.png" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <title>Led Zeppellin</title>
    <meta
      content="width=device-width, initial-scale=1.0, shrink-to-fit=no"
      name="viewport"
    />
    <!--     Fonts and icons     -->
    <link
      rel="stylesheet"
      type="text/css"
      href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Roboto+Slab:400,700|Material+Icons"
    />
    <link
      rel="stylesheet"
      href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css"
    />
    <link
      rel="stylesheet"
      href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
    />
    <!-- CSS Files -->
    <link href="./assets/css/material-kit.css?v=2.0.7" rel="stylesheet" />
    <link href="./assets/css/log.css" rel="stylesheet" />
  </head>

  <body class="login-page sidebar-collapse">
   
    <div
      class="header-filter clear-filter purple-filter"
      style="
        background-image: url('./assets/img/bg3.jpg');
        background-size: cover;
        background-position: top center;
       
      "
    >
      <div class="container">
        <div class="row">
          <div class="col-md-6 mx-auto p-0">
            <div class="card">
              <div class="login-box">
                <div class="login-snip">
                  <input
                    id="tab-1"
                    type="radio"
                    name="tab"
                    class="sign-in"
                    checked
                  /><label for="tab-1" class="tab">Login</label>
                  <input
                    id="tab-2"
                    type="radio"
                    name="tab"
                    class="sign-up"
                  /><label for="tab-2" class="tab">Sign Up</label>
                  <div class="login-space">
                    <div class="login">
                      <div class="group">
                        <label for="user" class="label">Username</label>
                        <input
                          id="user"
                          type="text"
                          class="input"
                          placeholder="Enter your username"
                        />
                      </div>
                      <div class="group">
                        <label for="pass" class="label">Password</label>
                        <input
                          id="pass"
                          type="password"
                          class="input"
                          data-type="password"
                          placeholder="Enter your password"
                        />
                      </div>
                      <div class="group">
                        <input
                          id="check"
                          type="checkbox"
                          class="check"
                          checked
                        />
                        <label for="check"
                          ><span class="icon"></span> Keep me Signed in</label
                        >
                      </div>
                      <div class="group">
                        <input type="submit" class="button" value="Sign In" />
                      </div>
                      <div class="hr"></div>
                      <div class="foot text-white">
                        <a href="#">Forgot Password?</a>
                      </div>
                    </div>
                    <div class="sign-up-form">
                      <div class="group">
                        <label for="user" class="label">Username</label>
                        <input
                          id="user"
                          type="text"
                          class="input"
                          placeholder="Create your Username"
                        />
                      </div>
                      <div class="group">
                        <label for="pass" class="label">Password</label>
                        <input
                          id="pass"
                          type="password"
                          class="input"
                          data-type="password"
                          placeholder="Create your password"
                        />
                      </div>
                      <div class="group">
                        <label for="pass" class="label">Repeat Password</label>
                        <input
                          id="pass"
                          type="password"
                          class="input"
                          data-type="password"
                          placeholder="Repeat your password"
                        />
                      </div>
                      <div class="group">
                        <label for="pass" class="label">Email Address</label>
                        <input
                          id="pass"
                          type="text"
                          class="input"
                          placeholder="Enter your email address"
                        />
                      </div>
                      <div class="group">
                        <input type="submit" class="button" value="Sign Up" />
                      </div>
                        <div class="hr">
                        <div class="foot">
                          <label for="tab-1">Already Member?</label>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <footer class="footer">
        <div class="container mt-5">
          <div class="copyright float-center">
            &copy;
            <script>
              document.write(new Date().getFullYear());
            </script>
            , made with <i class="material-icons">favorite</i> by
            <a href="#" target="_blank">Ali, Caro, Cédric, Rachida </a>
            Team Led Zeppelin.
          </div>
        </div>
      </footer>
    </div>
    <!--   Core JS Files   -->
    <script
      src="./assets/js/core/jquery.min.js"
      type="text/javascript"
    ></script>
    <script
      src="./assets/js/core/popper.min.js"
      type="text/javascript"
    ></script>
    <script
      src="./assets/js/core/bootstrap-material-design.min.js"
      type="text/javascript"
    ></script>
    <script src="./assets/js/plugins/moment.min.js"></script>
    <!--	Plugin for the Datepicker, full documentation here: https://github.com/Eonasdan/bootstrap-datetimepicker -->
    <script
      src="./assets/js/plugins/bootstrap-datetimepicker.js"
      type="text/javascript"
    ></script>
    <!--  Plugin for the Sliders, full documentation here: http://refreshless.com/nouislider/ -->
    <script
      src="./assets/js/plugins/nouislider.min.js"
      type="text/javascript"
    ></script>
    <!--  Google Maps Plugin    -->
    <!-- Control Center for Material Kit: parallax effects, scripts for the example pages etc -->
    <script
      src="./assets/js/material-kit.js?v=2.0.7"
      type="text/javascript"
    ></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  </body>
</html>
