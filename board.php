<?php
session_start(); 
// If the session variable is empty, this  
        // means the user is yet to login 
        // User will be sent to 'login.php' page 
        // to allow the user to login 
        if (!isset($_SESSION['username'])) { 
            header('https://led-zepplin-forum.herokuapp.com/'); 
            exit();
        }
        if($_GET['board_id'] == 5){
          if($_GET['pass'] != 1234){

            //header('HTTP/1.0 403 Forbidden');
            echo 'Access Denied, this board is top secret';
            exit();
          }
        }
ob_start();
require ('config/connect.php');
$redirect = false;
$boardId = isset($_GET["board_id"]) && is_numeric($_GET["board_id"]) ? intval($_GET["board_id"]): 0;
$board_result = NULL;

if (!isset($_GET["board_id"]))
{
    $redirect = true;
}
else
{
    $boardId = $_GET["board_id"];
    $sql = "select * from board where id = $boardId";
    $board_result = $conn->query($sql);

    if ($board_result->rowCount() != 1) $redirect = true;
}

if ($redirect)
{
    header('https://led-zepplin-forum.herokuapp.com/');
    exit();
}

$boardRow = $board_result->fetch();

$sql = "select topics.title as topicTitle,topics.content as topicContent,topics.id as topicId, topics.modification_date as topicModificationDate, topics.locked as locked, users.nickname as authorNickname from topics inner join users on topics.topic_by = users.id where board_id = '$boardId' order by creation_date DESC";
$topics_results = $conn->query($sql);

include ("header.php");

function getRandomTopicImageClasses()
{
    $images_types = array(
        "fa-check green ",
        "fa-check green",
        "fa-check red",
        "fa-times gray",
        "fa-check gray"
    );

    $rand_type = array_rand($images_types, 1);

    return $images_types[$rand_type];
}

function getDateDisplay($input)
{
  if(is_null($input))
    return "";

  $date  = new DateTime($input);
  return date_format($date,"D M j, Y, g:i a");
}

?>
  
  
<div class="container">
  <div class="section text-center">
          <nav aria-label="breadcrumb" role="navigation">
            <ol class="breadcrumb">
              <i class="fa fa-home mr-1 pt-1 home_icon" aria-hidden="true"></i>
              <li class="breadcrumb-item"><a href="./home.php">Home</a></li>
             
             
              <li class="breadcrumb-item" aria-current="page">
                <a href="./board.php?board_id=<?php echo $boardRow["id"] ?>">Topics of <?php echo $boardRow['name'] ?> </a>
              </li>
            </ol>
          </nav>
        </div>
 
        <!-- Start New Topic, Box Search -->
        <div class="row">
          <div class="col-md-9">
            <h4 class="topic_title mb-3">Topics of <?php echo $boardRow['name'] ?></h4>
            <div class="alert alertnew mb-4" role="alert">
            Forum rules of the <?php echo $boardRow['name'] ?> Board
            <h4> No Spam / Advertising / Self-promote in the forums</h4>
        <p>These forums define spam as unsolicited advertisement for goods, services and/or other web sites, or posts with little, or completely unrelated content.</p> 
        <p>Do not spam the forums with links to your site or product, or try to self-promote your website, business or forums etc.</p>
        <p>Spamming also includes sending private messages to a large number of different users.</p>
        <h4> Remain respectful of other members at all times and Do not post “offensive” posts, links or images</h4>
            </div>
            

            <!-- Start Row Two -->
            <div class="row">
              <div class="col-md-4 col-sm-12">
                <div class="col">
                <a href="#new_topic" class="btn btn-round btn-primary">new topic
                  <i class="fa fa-pencil ml-1 p" aria-hidden="true"></i></a>
                </div>
              </div>

              <div class="col-md-12 col-sm-12 col-xm-12 text-right count_page">
              <?php echo $topics_results->rowCount() ?> topics, pages 1 of 1
              </div>
            </div>
            <!-- End Row Two-->

            <!-- Start Third Row Card-->

            <table class="table table-bordered mt-5">
              <thead class="table-bg">
                <tr class="text-white">
                  <th class="text-capitalize">Announcements</th>
                  <th>
                    <i class="fa fa-comments" aria-hidden="true"></i>
                  </th>
                  <th>
                    <i class="fa fa-eye" aria-hidden="true"></i>
                  </th>
                  <th>
                    <i class="fa fa-clock-o" aria-hidden="true"></i>
                  </th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td class=" ">
                    <div class="row">
                      <div class="col">
                        <i class="fa fa-bullhorn frst_i" aria-hidden="true"></i>
                      </div>
                      <div class="col-10">
                        <i
                          class="fa fa-bullhorn float-right text-primary"
                          aria-hidden="true"
                        ></i>
                        <h5 class="global">this is a global announcements</h5>

                        by <span class="name text-capitalize">carla</span>
                        <span>>> in Unread Forum</span>
                      </div>
                    </div>
                  </td>

                  <td>201</td>
                  <td>201</td>
                  <td>
                    <div class="text_cell">
                      by <span>carla</span>
                      <p>Sun Oct 09, 2016 5:58 pm</p>
                    </div>
                  </td>
                </tr>
              </tbody>
            </table>
            <!-- End Third Row Card-->

            <!-- Start Fourth Row Card-->

            <table class="table table-bordered mt-5">
              <thead class="table-bg">
                <tr class="text-white">
                  <th class="text-capitalize">Topics</th>
                  <th>
                    <i class="fa fa-comments" aria-hidden="true"></i>
                  </th>
                  <th>
                    <i class="fa fa-eye" aria-hidden="true"></i>
                  </th>
                  <th>
                    <i class="fa fa-clock-o" aria-hidden="true"></i>
                  </th>
                </tr>
              </thead>
              <tbody>
              <?php  if($boardId==6){ include "random_board.php";}
              else { 
while ($topic_row = $topics_results->fetch())
{ 
?>
                <tr>
                  <td class=" ">
                    <div class="row">
                      <div class="col">
                        <?php if($topic_row['locked']){
                          echo '<i class="fa fa-lock text-primary" aria-hidden="true"></i>';
                        }?>
                      </div>
  
                      
                      <div class="col-10">
                        <h5 class="global"> <a class="text-dark" href="https://led-zepplin-forum.herokuapp.com/topic.php?topic_id=<?php echo $topic_row["topicId"] ?>"><?php echo $topic_row['topicTitle'] ?></a>  </h5>
                        by
                        <span class="name text-capitalize text-rose"
                          ><?php echo $topic_row['authorNickname'] ?></span>
                      </div>

                      
               
                    </div>
                  </td>

                  <td>201</td>
                  <td>201</td>
                  <td>
                    <div class="text_cell">
                      by
                      <span class="text-rose text-capitalize name"
                        ><?php echo $topic_row['authorNickname'] ?></span
                      >
                      <p><?php echo getDateDisplay($topic_row['topicModificationDate']) ?></p>
                    </div>
                  </td>
                </tr>
                <?php
} };
?> 
    
               
              </tbody>
            </table>
            <!-- End Fourth Row Card-->

            <!-- Start Fiveth Row -->
            <div class="row mt-5">
              <div class="col-md-2 col-sm-12">
                </div>
              <div
                class="col-md-12 col-sm-12 col-xm-12 text-right text-capitalize count_page"
              >
              <?php echo $topics_results->rowCount() ?> topics, pages 1 of 1
              </div>
            </div>

            <!-- post new topic -->
            <?php
               if(isset($_SESSION['id'])) {
                 if(isset($_POST['tsubmit'])) {
                    if(isset($_POST['title'],$_POST['content'])) {
                       $sujet = htmlspecialchars($_POST['title']);
                       $contenu = htmlspecialchars($_POST['content']);
                       if(!empty($sujet) AND !empty($contenu)) {
                          if(strlen($sujet) <= 70) {
                             $ins = $conn->prepare('INSERT INTO topics(title, content, board_id, topic_by, creation_date, modification_date) VALUES(?,?,?,?,NOW(),NOW())');
                             $ins->execute(array($sujet,$contenu,$_GET['board_id'],$_SESSION['id']));
                          } else {
                             $terror = "Votre sujet ne peut pas dépasser 70 caractères";
                          }
                       } else {
                          $terror = "Veuillez compléter tous les champs";
                       }
                    }
                 }
              } else {
                 $terror = "Veuillez vous connecter pour poster un nouveau topic";
              }
            ?>

            <form method='POST' action='#'>
            <div class="form-group">
            <p class="font-weight-bold" id="new_topic">Post a new topic</p>

              <input type="text" name="title" maxlength="70" class="form-control" placeholder="Choose title">
            </div>
            <div class="form-group">
              <textarea type="text" name="content" class="form-control" placeholder="Please enter your content"></textarea>
            </div>
            <div>
            <button type="submit" name="tsubmit" class="btn btn-round btn-primary">Submit</button>
            </div>
            </form>

            <!-- end post new topic -->

            <!-- End Fiveth Row -->

            <!-- Start Sixth Row -->
            <div class="row mt-5">
              <div class="col-md-4 col-sm-12">
                <a href="./home.php" class="text-capitalize return">
                  <i class="fa fa-angle-left mr-1" aria-hidden="true"></i>
                  return to board index</a
                >
              </div>

            </div>


             <!-- End Sixth Row -->
             </div>
          <!-- Start Side Bar-->
          <?php include("aside.php"); ?>
        </div>
      </div>
      <?php include("footer.php"); ?>