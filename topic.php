<!--
=========================================================
Material Kit - v2.0.7
=========================================================
Product Page: https://www.creative-tim.com/product/material-kit
Copyright 2020 Creative Tim (https://www.creative-tim.com/)
Coded by Creative Tim
=========================================================
The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software. -->
<?php 
session_start();
//ini_set('display_errors', 1);
   // ini_set('display_startup_errors', 1);
   // error_reporting(E_ALL); 
// If the session variable is empty, this  
        // means the user is yet to login 
        // User will be sent to 'login.php' page 
        // to allow the user to login 
        if (!isset($_SESSION['username'])) { 
            header('location: https://led-zepplin-forum.herokuapp.com/'); 
            exit();
        } 
ob_start();
  require ('connect.php');
  $redirect = false;
  $topicId = 0;
  $topic_result = NULL;
  
  if (!isset($_GET["topic_id"]))
  {
      $redirect = true;
  }
  else
  {
      $topicId = $_GET["topic_id"];
      $sql = "select topics.id as topicId,topics.title as topicTitle,topics.locked as locked, topics.topic_by as topicAuthor, topics.content as topicContent,board.id as boardId,board.name as boardName from topics inner join board on topics.board_id = board.id where topics.id = $topicId";
      $topic_result = $conn->query($sql);
     
  
      if ($topic_result->rowCount() != 1) $redirect = true;
  }
  
  if ($redirect)
  {
      header('location: https://led-zepplin-forum.herokuapp.com/home.php');
      exit();
  }
  
  $topicRow = $topic_result->fetch();

  //print_r($topicRow['locked']);
  //print_r($topicRow['topicAuthor']);


  //$sql = "select messages.content as messageContent,messages.id as messageId,messages.creation_date as messageCreationDate, messages.modification_date as messageModificationDate, messages.deleted as isDeleted, users.nickname as authorNickname, users.email as authorEmail, users.id as authorId, users.image as authorAvatar  from messages inner join users on messages.message_by = users.id where message_topic = '$topicId' order by creation_date DESC";
 // $messages_results = $conn->query($sql);

  //LOCK THE TOPIC
  if(isset($_POST['tolock'])){
    //print_r('lock is set');
    if($_POST['tolock']){
      //print_r('and it works');
      $lock = $conn->prepare('UPDATE topics SET locked = 1 WHERE id = ? ');
      $lock->execute(array($topicRow['topicId']));
      header("Location: https://led-zepplin-forum.herokuapp.com/topic.php?topic_id=".$topicRow['topicId']."");
      exit();
    }
  }

  //DELETE MESSAGE

  if(isset($_POST['deleteMessageId'])){
    if (!empty($_POST['deleteMessageId'])){
      $delete = $conn->prepare('UPDATE messages SET content = ?, deleted = ? WHERE id = ? AND message_by = ?');
      $delete->execute(array("*This message was deleted*", 1, $_POST['deleteMessageId'], $_SESSION['id']));
      header("Location: https://led-zepplin-forum.herokuapp.com/topic.php?topic_id=".$topicRow['topicId']."");
      exit();
    }
  }
  

    
  $member_id = $_SESSION['id'];
  $emojiArray = array("like", "love", "smile", "wow", "sad", "angry");
   require_once ("Rate.php");
   $rate = new Rate();
  $result = $rate->getAllPost();

  

 
 
  include ("header.php");
  require_once 'Michelf/Markdown.inc.php';
  function getDateDisplay($input)
  {
    if(is_null($input))
      return "";
  
    $date  = new DateTime($input);
    return date_format($date,"D M j, Y, g:i a");
  }
  
  ?>
<div class="container">
        <nav aria-label="breadcrumb" role="navigation">
          <ol class="breadcrumb">
            <i class="fa fa-home mr-1 pt-1 home_icon" aria-hidden="true"></i>
            <li class="breadcrumb-item"><a href="./home.php">Home</a></li>
           
            <li class="breadcrumb-item">
              <a href="./board.php?board_id=<?php echo $topicRow["boardId"] ?>"><?php echo $topicRow['boardName'] ?></a>
            </li>
            <li class="breadcrumb-item" aria-current="page">
              <a href="./topic.php?topic_id=<?php echo $topicRow["topicId"] ?>"><?php echo $topicRow["topicTitle"] ?> </a>
            </li>
            
          </ol>
        </nav>
      </div>
      <div class="container mt-3">
        <div class="row">
          <div class="col-lg-9">
            <h4 class="text-left"><?php echo $topicRow['topicTitle'] ?></h4>
            <div class="alert alertnew" role="alert">
              <a href="#" class="alert-link">Forum rules</a>
            </div>
            <div class="row">
              <div>
              
              <?php if((!$topicRow['locked']) && ($topicRow['topicAuthor'] == $_SESSION['id'])){
                echo '<form method="POST" action="#">
                <input type="hidden" name="tolock" id="tolock" value="true">
                <button type="submit" class="btn btn-primary btn-round reply-btn">Lock this topic</button>
              </form>';
              }
              ?>
                
                
              </div>
            </div>
            <div class="container padding-bottom-3x mb-2">

              <div class="row">
                <div class="col-md-8 mx-auto">
                  <h2><?php echo $topicRow['topicTitle'] ?></h2>
                  <h4>
                  <?php echo $topicRow['topicContent'] ?>
                  </h4>
                </div>
                <!-- comments -->
                <div class="container d-flex justify-content-center mb-100">
                  <div class="row col-md-12">
                    <div class="col-md-12">
                      <div class="card">
                        <div class="card-body">
                          <h4 class="card-title">Recent Comments</h4>
                          <h6 class="card-subtitle">
                            Latest Comments section by users
                          </h6>
                        </div>
                        <div class="comment-widgets m-b-20">




      

                            <!-- start messages -->
                            <?php
                            if (! empty($result)) {
                              $i = 0;
                      $count = 0;
                      $lastId = 0;
                      foreach ($result as $message) {
                        //get ID of most recent author and most recent message
                        if($count == 0){

                          $lastId = $message['authorId'];
                          $lastMessageId = $message['messageId'];

                        }
                        $ratingResult = $rate->getRatingByMessageForMember($message["messageId"], $member_id);
        $ratingVal = "";
        if (! empty($ratingResult[0]["rating"])) {
            $ratingVal = $ratingResult[0]["rating"];
        }
                        
                      ?>
                          <div class="d-flex flex-row comment-row demo-table">
                            <div class="p-2">
                              <span class="round"
                                ><img
                                  src="<?php 

                                          if(!is_null($message['authorAvatar']) && file_exists('./Uploads/images/'.$message['authorAvatar'])){
                                            echo "./Uploads/images/".$message['authorAvatar'];
                                          }
                                          else{
                                            echo "https://www.gravatar.com/avatar/".md5(strtolower(trim($message['authorEmail'])))."?"."&s=80";
                                          }
                                  

                                  ?>"
                                  alt="user"
                                  width="50"/> 
                                </span>
                            </div>
                            <div class="comment-text w-100">
                            <h5><?php echo $message['authorNickname'] ?></h5>
                              <div class="comment-footer">
                                <span class="date">
                                  <?php 
                                  
                                    echo getDateDisplay($message['messageCreationDate']);

                                    if(!is_null($message['messageModificationDate'])){
                                      echo ' <strong><em>Edited on</em></strong> '.getDateDisplay($message['messageModificationDate']);
                                    }
                                    
                                  
                                  ?>
                                </span>
                                <span class="text-right">
                                <?php 
                                  if(($count == 0) && ($_SESSION['id'] == $lastId)){

                                    $messageToEditId = $message['messageId'];
                                    $commentToEdit = $message['messageContent'];

                                    if(!$message['isDeleted']){
                                    echo '<form method="POST" action="#form-edit">
                                      <input type="hidden" value="true" name="editMessage" id="editMessage">
                                      <button type="submit" class="btn"><i class="fa fa-pencil"></i></button>
                                    </form>';
                                    }
                                    
                                  
                                  }
                                  if(($_SESSION['id'] == $message['authorId']) && (!$message['isDeleted'])){
                                    echo '<form method="POST" action="#">
                                    <input type="hidden" value="true" name="deleteMessage" id="deleteMessage">
                                    <input type="hidden" value="'.$message['messageId'].'" name="deleteMessageId" id="deleteMessageId">
                                    <button type="submit" class="btn btn-danger"><i class="fa fa-times"></i></button>
                                  </form>';
                                  }
                                  
                                ?>
                                </span>
                              </div>
                              <p class="m-b-5 m-t-10">
                              <?php 
                                $comment = $message['messageContent'];
                                $markdowned_comment = Michelf\Markdown::defaultTransform($comment);
                                echo $markdowned_comment;
                                
                              ?><!-- Reaction system start -->
                              
                              </p>
                              <div id="topic-<?php echo $message["messageId"]; ?>"
                        class="emoji-rating-box">
                        <input type="hidden" name="rating" id="rating"
                            value="<?php echo $ratingVal; ?>" />

                        <div class="emoji-section">
                            <a class="like-link"
                                onmouseover="showEmojiPanel(this)"
                                onmouseout="hideEmojiPanel(this)"><img
                                src="like.png" /> Like</a>
                            <ul class="emoji-icon-container">
                            <?php
                            foreach ($emojiArray as $icon) {
                            ?>
                                <li><img src="icons/<?php echo $icon; ?>.png" class="emoji-icon"
                                    data-emoji-rating="<?php echo $icon; ?>"
                                    onClick="addUpdateRating(this, <?php echo $message["messageId"]; ?>)" /></li>
                            <?php
                            }
                            ?> 
                             </ul>
                            </div>
                            <div
                            id="emoji-rating-count-<?php echo $message["messageId"]; ?>"
                            class="emoji-rating-count">
                                <?php
                                if (! empty($message["rating_count"])) {
                                    echo $message["rating_count"] . " Likes";
                                ?>
                                <?php
                                    if (! empty($message["emoji_rating"])) {
                                        $emojiRatingArray = explode(",", $message["emoji_rating"]);
                                        foreach ($emojiRatingArray as $emojiData) {
                               ?>
                                        <img data-toggle="tooltip" data-placement="top" title="<?php 
                                          $reactions = $rate->getRatingNicknames($message['messageId'], $emojiData);
                                          foreach ($reactions as $reaction){
                                            echo $reaction['rateNickname'].'
                                            ';
                                          }
                                        ?>"
                                src="icons/<?php echo $emojiData; ?>.png"
                                class="emoji-data" />
                                    <?php
                                    //$test = $rate->getRatingNicknames($message['messageId'], $emojiData);
                                    //var_dump($test[0]["rateNickname"]);
                                        }
                                    }
                                } else {
                               ?>
                                No Ratings
                               <?php  } ?>
                        </div>
                        </div>
                            </div>

                            </div> <!-- end message -->
                            <?php
                            $count = $count + 1;
}
}
?>

<script>
function showEmojiPanel(obj) {
        $(".emoji-icon-container").hide();
	    $(obj).next(".emoji-icon-container").show();
}
function hideEmojiPanel(obj) {
    setTimeout(function() {
    $(obj).next(".emoji-icon-container").hide();
    }, 2000);
}

function addUpdateRating(obj,id) {
	$(obj).closest(".emoji-icon-container").hide();
	$.ajax({
	url: "https://led-zepplin-forum.herokuapp.com/addUpdateRating.php",
	data:'id='+id+'&rating='+$(obj).data("emoji-rating"),
	type: "POST",
    success: function(data) {
        $("#emoji-rating-count-"+id).html(data);    
        }
	});
}
</script>

                      </div>
                    </div>
                  </div>
                </div>
              </div>
              </div>


              <!-- message -->
              <?php 
                if($topicRow['locked']){
                  echo '<h5 class="mb-30 padding-top-1x bg-danger text-center text-white rounded font-weight-bold">This topic is locked</h5>';
                }
                else if((isset($_POST['editMessage'])) && ($_POST['editMessage']) && (isset($messageToEditId))){
                 
                  echo '<h5 id="form-edit" class="mb-30 padding-top-1x bg-light text-center text-dark rounded ">Edit your message</h5>
                  <form method="post">
                    <div class="form-group">
                      <textarea
                        class="form-control form-control-rounded"
                        id="message_text_edit"
                        name="message_text_edit"
                        rows="8"
                        placeholder=""
                        required=""
                      >'.$commentToEdit.'</textarea>
                    </div>
                    <div class="text-right">
                    <input id="edit_submit" class="btn btn-primary btn-fill pull-right" value="Edit Message" type="submit">
                        
                      </input>
                    </div>
                  </form>';
                }
                else if($lastId == $_SESSION['id']){
                  echo '<h5 class="mb-30 padding-top-1x bg-danger text-center text-white rounded font-weight-bold">You cannot post two messages in a row.</h5>';
                }
                else{
                  echo '<h5 class="mb-30 padding-top-1x bg-light text-center text-dark rounded ">Leave a message</h5>
                  <form method="post">
                    <div class="form-group">
                      <textarea
                        class="form-control form-control-rounded"
                        id="message_text"
                        rows="8"
                        placeholder="Write your message here..."
                        required=""
                      ></textarea>
                    </div>
                    <div class="text-right">
                      <input id="btn_submit" data-topicId="'.$topicId.'" class="btn btn-round btn-primary btn-fill pull-right" value="Submit Message" type="button">
                        
                      </input>
                    </div>
                  </form>';
                }

                //EDIT MESSAGE
                if((isset($_POST['message_text_edit'])) && ($lastId == $_SESSION['id'])){
                  //print_r($lastMessageId);
                  //print_r('you did good');
                  $edit = $conn->prepare('UPDATE messages SET content = ?, modification_date = NOW() WHERE id = ?');
                  $edit->execute(array($_POST['message_text_edit'], $lastMessageId));
                  header("Location: https://led-zepplin-forum.herokuapp.com/topic.php?topic_id=".$topicRow['topicId']."");
                  exit();
                }
              ?>

              


            </div>
          </div>
          <?php include("aside.php"); ?>
         
          <!-- fin test structure -->
        </div>
      </div>
      <script type="text/javascript" src="./topic.js"></script>
      <?php include("footer.php"); ?>