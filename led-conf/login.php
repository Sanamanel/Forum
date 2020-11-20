<?php session_start();
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

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Panneau d'adminnistration | Powered by Bout de Créations</title>
<link rel="stylesheet" type="text/css" href="style.css" />
<script type="text/javascript" src="jquery.min.js"></script>
<script type="text/javascript" src="ddaccordion.js"></script>
<script type="text/javascript">
ddaccordion.init({
	headerclass: "submenuheader", //Shared CSS class name of headers group
	contentclass: "submenu", //Shared CSS class name of contents group
	revealtype: "click", //Reveal content when user clicks or onmouseover the header? Valid value: "click", "clickgo", or "mouseover"
	mouseoverdelay: 200, //if revealtype="mouseover", set delay in milliseconds before header expands onMouseover
	collapseprev: true, //Collapse previous content (so only one open at any time)? true/false 
	defaultexpanded: [], //index of content(s) open by default [index1, index2, etc] [] denotes no content
	onemustopen: false, //Specify whether at least one header should be open always (so never all headers closed)
	animatedefault: false, //Should contents open by default be animated into view?
	persiststate: true, //persist state of opened contents within browser session?
	toggleclass: ["", ""], //Two CSS classes to be applied to the header when it's collapsed and expanded, respectively ["class1", "class2"]
	togglehtml: ["suffix", "<img src='images/plus.gif' class='statusicon' />", "<img src='images/minus.gif' class='statusicon' />"], //Additional HTML added to the header when it's collapsed and expanded, respectively  ["position", "html1", "html2"] (see docs)
	animatespeed: "fast", //speed of animation: integer in milliseconds (ie: 200), or keywords "fast", "normal", or "slow"
	oninit:function(headers, expandedindices){ //custom code to run when headers have initalized
		//do nothing
	},
	onopenclose:function(header, index, state, isuseractivated){ //custom code to run whenever a header is opened or closed
		//do nothing
	}
})
</script>

<script type="text/javascript" src="jconfirmaction.jquery.js"></script>
<script type="text/javascript">
	
	$(document).ready(function() {
		$('.ask').jConfirmAction();
	});
	
</script>

<script language="javascript" type="text/javascript" src="niceforms.js"></script>
<link rel="stylesheet" type="text/css" media="all" href="niceforms-default.css" />

</head>
<body>
<div id="main_container">

	<div class="header_login">
    <div class="logo"><a href="#"><img src="images/logo_petit.png" alt="" title="" border="0" /></a></div>
    
    </div>

     
         <div class="login_form">
         
         <h3>Login Admin Panel </h3>
         
         <a href="#" class="forgot_pass">Mot de passe oubli&eacute;</a> 
         
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" class="niceform" method="post" enctype="multipart/form-data" name="form1" id="form1">
         
                <fieldset>
                    <dl>
                        <dt><label for="email">Login:</label></dt>
                        <dd><input type="text" name="login" id="login" size="54" /></dd>
                    </dl>
                    <dl>
                        <dt><label for="password">Mot de passe:</label></dt>
                        <dd><input type="password" name="mdp" id="mdp" size="54" /></dd>
                    </dl>
                    
                    <dl>
                        <dt><label></label></dt>
                        <dd>
                    <input type="checkbox" name="interests[]" id="" value="" /><label class="check_label">Se souvenir de moi</label>
                        </dd>
                    </dl>
                    
                     <dl class="submit">
                    <input type="submit" name="submit" id="submit" value="Entrez" /><input type="hidden" name="todo" id="todo" value="login" />
                     </dl>
                    
                </fieldset>
                
         </form>
         </div>  
          
	
    
    <div class="footer_login">
    
    	<div class="left_footer_login">Panneau d'administration</div>
    	<div class="right_footer_login"></div>
    
    </div>

</div>		
</body>
</html>