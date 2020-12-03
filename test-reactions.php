<?php
session_start();
//ini_set('display_errors', 1);
  //  ini_set('display_startup_errors', 1);
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
// Here the member id is harcoded.
// You can integrate your authentication code here to get the logged in member id
$member_id = $_SESSION['username'];
$emojiArray = array("like", "love", "smile", "wow", "sad", "angry");
require_once ("Rate.php");
$rate = new Rate();
$result = $rate->getAllPost();

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
    <title>Led Zeppelin</title>
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
    <!-- CSS Files -->

    <link href="./assets/css/material-kit.css?v=2.0.7" rel="stylesheet" />
    <link href="./assets/css/topics.css" rel="stylesheet" />
    <link href="./assets/css/comment.css" rel="stylesheet" />
    <link href="./assets/css/style.css" rel="stylesheet" />

<link rel="stylesheet" href="rating.css">
     <!-- Css for reaction system -->
     <link rel="stylesheet" type="text/css" href="./assets/css/reaction.css" />
    <!-- Emoji Lib-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/emojionearea/3.4.2/emojionearea.min.css" />
    <script type="text/javascript" src="https://platform-api.sharethis.com/js/sharethis.js#property=5fc7f882bfc76d001839b41a&product=sticky-share-buttons" async="async"></script>
  </head>

  <body class="index-page sidebar-collapse">
    <nav
      class="navbar navbar-transparent navbar-color-on-scroll fixed-top navbar-expand-lg"
      color-on-scroll="100"
      id="sectionsNav"
    >
      <div class="container">
        <div class="navbar-translate">
          <button
            class="navbar-toggler"
            type="button"
            data-toggle="collapse"
            aria-expanded="false"
            aria-label="Toggle navigation"
          >
            <span class="sr-only">Toggle navigation</span>
            <span class="navbar-toggler-icon"></span>
            <span class="navbar-toggler-icon"></span>
            <span class="navbar-toggler-icon"></span>
          </button>
        </div>
        <div class="collapse navbar-collapse">
          <ul class="navbar-nav ml-auto">
            <li class="nav-item"></li>
            <li class="dropdown nav-item">
              <a
                href="#"
                class="dropdown-toggle nav-link"
                data-toggle="dropdown"
              >
                <i class="material-icons">apps</i> Menu
              </a>
              <div class="dropdown-menu dropdown-with-icons">
              <a
                  href="https://led-zepplin-forum.herokuapp.com/home.php"
                  class="dropdown-item"
                >
                  <i class="material-icons">dashboard</i> Board
                </a>
                <a
                  href="https://led-zepplin-forum.herokuapp.com/profile-page.php"
                  class="dropdown-item"
                >
                  <i class="material-icons">account_box</i> Profile
                </a>
             
               
              
              </div>
            </li>

            <li class="nav-item">
              <a class="nav-link" href="logout.php" >
                <i class="material-icons">login</i> Log out
              </a>
            </li>
          </ul>
        </div>
      </div>
    </nav>
    <div
      class="page-header header-filter clear-filter purple-filter"
      data-parallax="true"
      style="background-image: url('./assets/img/bg3.jpg')"
    >
      <div class="container">
        <div class="row">
          <div class="col-md-8 ml-auto mr-auto">
          <a class="text-white" href="https://led-zepplin-forum.herokuapp.com/home.php" >  <div class="brand">
            <h1>Led Zeppelin</h1>
            </div></a>
          </div>
        </div>
      </div>
    </div>
    <div class="main main-raised">
    <script src="jquery-3.2.1.min.js" type="text/javascript"></script>
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
	url: "addUpdateRating.php",
	data:'id='+id+'&rating='+$(obj).data("emoji-rating"),
	type: "POST",
    success: function(data) {
        $("#emoji-rating-count-"+id).html(data);    
        }
	});
}
</script>

    <table class="demo-table">
        <tbody>
<?php
if (! empty($result)) {
    $i = 0;
    foreach ($result as $message) {
        $ratingResult = $rate->getRatingByTopicForMember($message["id"], $member_id);
        $ratingVal = "";
        if (! empty($ratingResult[0]["rating"])) {
            $ratingVal = $ratingResult[0]["rating"];
        }
        ?>
        <tr>
            <td valign="top">
                <div class="feed_title"><?php //echo $message["title"]; ?></div>
                    <div><?php echo $message['content']; ?></div>
                    <div id="topic-<?php echo $message["id"]; ?>"
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
                                    onClick="addUpdateRating(this, <?php echo $message["id"]; ?>)" /></li>
                            <?php
                            }
                            ?>
                            </ul>
                        </div>
                        <div
                            id="emoji-rating-count-<?php echo $message["id"]; ?>"
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
                                        <img
                                src="icons/<?php echo $emojiData; ?>.png"
                                class="emoji-data" />
                                    <?php
                                        }
                                    }
                                } else {
                               ?>
                                No Ratings
                               <?php  } ?>
                        </div>
                    </div>
                </td>
            </tr>
<?php
    }
}
?>
</tbody>
    </table>
