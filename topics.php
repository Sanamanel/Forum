
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
require('connect.php'); 
     include("header.php");
     
$boardid=$_GET['id'];
echo $boardid;
$sql = "select topics.title as topicTitle,topics.content as topicContent,topics.id as topicId, topics.modification_date as topicModificationDate from topics where board_id = '$boardId' order by id desc";
$topics_results = $conn->query($sql); 
$topicTitle = $topic_row['topicTitle'];
$topicContent = $topic_row['topicContent'];
$topicID= $topic_row['topicId'];
$topicModificationDate = $topic_row['topicModificationDate']; ?>

<div class="container-fluid">
<?php if ($board==1) { ?> <?php include("topics_general.php");?><?php }?>
<?php if ($board==2) { ?><?php include("topics_development.php");?> <?php }?>
<?php if ($board==3) { ?><?php include("topics_smalltalk.php");?> <?php }?>
<?php if ($board==4) { ?><?php include("topics_events.php");?> <?php }?>
      
   
        
            <!-- End Sixth Row -->
          </div>
          <!-- Start Side Bar-->
          <?php include("aside.php"); ?>
        </div>
      </div>
      <?php include("footer.php"); ?>