<?php
// Here the member id is harcoded.
// You can integrate your authentication code here to get the logged in member id
session_start();
//ini_set('display_errors', 1);
  //ini_set('display_startup_errors', 1);
   //error_reporting(E_ALL); 
// If the session variable is empty, this  
        // means the user is yet to login 
        // User will be sent to 'login.php' page 
        // to allow the user to login 
        if (!isset($_SESSION['username'])) { 
            header('location: https://led-zepplin-forum.herokuapp.com/'); 
            exit();
        } 
ob_start();




$member_id = $_SESSION['id'];
if (! empty($_POST["rating"]) && ! empty($_POST["id"])) {
    require_once ("Rate.php");
    $rate = new Rate();
 
    
    
    $ratingResult = $rate->getRatingByMessageForMember($_POST["id"], $member_id);
    
    if (! empty($ratingResult)) {
        $rate->updateRating($_POST["rating"], $ratingResult[0]["id"]);
    } else {
        $rate->addRating($_POST["id"], $_POST["rating"], $member_id);
    }
    
    $postRating = $rate->getRatingByMessage($_POST["id"]);
    
    if (! empty($postRating[0]["rating_count"])) {
        echo $postRating[0]["rating_count"] . " Likes";
        if (! empty($postRating[0]["emoji_rating"])) {
            $emojiRatingArray = explode(",", $postRating[0]["emoji_rating"]);
            foreach ($emojiRatingArray as $emojiData) {
                ?>
                                        <img data-toggle="tooltip" data-html="true" data-placement="top" title="<?php 
                                          $reactions = $rate->getRatingNicknames($_POST["id"], $emojiData);
                                          foreach ($reactions as $reaction){
                                            echo $reaction['rateNickname'].'<br>';
                                          }
                                        ?>"
                                src="icons/<?php echo $emojiData; ?>.png"
                                class="emoji-data" />
                                    <?php
                }
            }
    }
}
?>

<script
      src="./assets/js/core/jquery.min.js"
      type="text/javascript"
    ></script>
    <script
      src="./assets/js/core/popper.min.js"
      type="text/javascript"
    ></script>
    
    <script src="./assets/js/plugins/moment.min.js"></script>
    <!--	Plugin for the Datepicker, full documentation here: https://github.com/Eonasdan/bootstrap-datetimepicker -->
    <script
      src="./assets/js/plugins/bootstrap-datetimepicker.js"
      type="text/javascript"
    ></script>
    
    <!-- Control Center for Material Kit: parallax effects, scripts for the example pages etc -->
    <script
      src="./assets/js/material-kit.js?v=2.0.7"
      type="text/javascript"
    ></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.bundle.min.js"></script> 
