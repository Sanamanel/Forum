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
      $sql = "select topics.id as topicId,topics.title as topicTitle,topics.content as topicContent,board.id as boardId,board.name as boardName from topics inner join board on topics.board_id = board.id where topics.id = $topicId";
      $topic_result = $conn->query($sql);
     
  
      if ($topic_result->rowCount() != 1) $redirect = true;
  }
  
  if ($redirect)
  {
      header('location: https://led-zepplin-forum.herokuapp.com/home.php');
      exit();
  }
  
  $topicRow = $topic_result->fetch();


  $sql = "select messages.content as messageContent,messages.id as messageId,messages.creation_date as messageCreationDate, messages.modification_date as messageModificationDate,users.nickname as authorNickname, users.email as authorEmail  from messages inner join users on messages.message_by = users.id where message_topic = '$topicId' order by creation_date DESC";
  $messages_results = $conn->query($sql);
 
 
  include ("header.php");
  require_once 'Michelf/Markdown.inc.php';
  function getDateDisplay($input)
  {
    if(is_null($input))
      return "";
  
    $date  = new DateTime($input);
    return date_format($date,"D M j, Y, g:i a");
  }
  
$currentUserName = $_SESSION["username"];
$emojiArray = array("like", "love", "smile", "wow", "sad", "angry");
require_once ("Rate.php");
$rate = new Rate();
$result = $rate->getAllPost();
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
                <button
                  type="button"
                  class="btn btn-primary btn-round reply-btn"
                >
                  Post Reply<span class="material-icons">
                    undo
                    <div class="mx-3"></div>
                  </span>
                </button>
              </div>
              <button
                class="btn btn-secondary dropdown-toggle btn-round size-btn"
                type="button"
                id="dropdownMenuButton"
                data-toggle="dropdown"
                aria-haspopup="true"
                aria-expanded="false"
              >
                <span class="material-icons"> build </span>
              </button>
              <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                <a class="dropdown-item" href="#">Action</a>
                <a class="dropdown-item" href="#">Another action</a>
                <a class="dropdown-item" href="#">Something else here</a>
              </div>
              <!-- search -->
              <div>
                <nav class="navbar navbar-expand-lg navbarbtn1">
                  <div class="container">
                    <form class="form-inline ml-auto">
                      <div class="form-group no-border">
                        <input
                          type="text"
                          class="form-control"
                          placeholder="Search"
                        />
                      </div>
                      <button
                        type="submit"
                        class="btn btn-white btn-just-icon btn-round"
                      >
                        <i class="material-icons">search</i>
                      </button>
                    </form>
                  </div>
                </nav>
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
                  <div class="row">
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
while ($message_row = $messages_results->fetch())
{
?>
                          <div class="d-flex flex-row comment-row">
                            <div class="p-2">
                              <span class="round"
                                ><img
                                  src="<?php echo "https://www.gravatar.com/avatar/".md5(strtolower(trim($message_row['authorEmail'])))."?"."&s=80";?>"
                                  alt="user"
                                  width="50"/> 
                                </span>
                            </div>
                            <div class="comment-text w-100">
                              <h5><?php echo $message_row['authorNickname'] ?></h5>
                              <div class="comment-footer">
                                <span class="date"><?php echo getDateDisplay($message_row['messageCreationDate']) ?></span>
                                <span class="label label-info">Pending</span>
                                <span class="action-icons">
                                  <a href="#" data-abc="true"
                                    ><i class="upd fa fa-pencil"></i
                                  ></a>
                                  
                                </span>
                              </div>
                              <p class="m-b-5 m-t-10">
                              <?php 
                                $comment = $message_row['messageContent'];
                                $markdowned_comment = Michelf\Markdown::defaultTransform($comment);
                                echo $markdowned_comment;
                                
                              ?><!-- Reaction system start -->
                              <div class="reaction-container"><!-- container div for reaction system -->
                                  <span class="reaction-btn"> <!-- Default like button -->
                                      <span class="reaction-btn-emo like-btn-default"></span> <!-- Default like button emotion-->
                                      <span class="reaction-btn-text">Like</span> <!-- Default like button text,(Like, wow, sad..) default:Like  -->
                                      <ul class="emojies-box"> <!-- Reaction buttons container-->
                                          <li class="emoji emo-like" data-reaction="Like"></li>
                                          <li class="emoji emo-love" data-reaction="Love"></li>
                                          <li class="emoji emo-haha" data-reaction="HaHa"></li>
                                          <li class="emoji emo-wow" data-reaction="Wow"></li>
                                          <li class="emoji emo-sad" data-reaction="Sad"></li>
                                          <li class="emoji emo-angry" data-reaction="Angry"></li>
                                      </ul>
                                  </span>
                                  <div class="like-stat"> <!-- Like statistic container-->
                                      <span class="like-emo"> <!-- like emotions container -->
                                          <span class="like-btn-like"></span> <!-- given emotions like, wow, sad (default:Like) -->
                                      </span>
                                      <span class="like-details">Knowband and 10k others</span>
                                  </div>
                              </div>
                              <!-- Reaction system end -->
                              </p>
                            </div>

                           
                            </div> <!-- end message -->
                            <?php
}
?>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              </div>
              <!-- message -->
              <h5 class="mb-30 padding-top-1x">Leave Message</h5>
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
                  <input id="btn_submit" data-topicId="<?php echo $topicId ?>" class="btn btn-primary btn-fill pull-right" value="Submit Message" type="button">
                    
                  </input>
                </div>
              </form>
            </div>
          </div>
          <?php include("aside.php"); ?>
         
          <!-- fin test structure -->
        </div>
      </div>
     
      <script type="text/javascript" src="./topic.js"></script>
     
    
      <?php include("footer.php"); ?>