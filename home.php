<?php 
session_start(); 
// If the session variable is empty, this  
        // means the user is yet to login 
        // User will be sent to 'login.php' page 
        // to allow the user to login 
        if (!isset($_SESSION['username'])) { 
            header('location: https://led-zepplin-forum.herokuapp.com/'); 
            exit();
        } 
ob_start();
 
        
include('connect.php');
 include("header.php");
include("main-home.php");
 include("aside.php"); 
 include("footer.php"); ?>
