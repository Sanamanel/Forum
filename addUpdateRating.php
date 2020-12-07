<?php
// Here the member id is harcoded.
// You can integrate your authentication code here to get the logged in member id
session_start();
ini_set('display_errors', 1);
   ini_set('display_startup_errors', 1);
   error_reporting(E_ALL); 
// If the session variable is empty, this  
        // means the user is yet to login 
        // User will be sent to 'login.php' page 
        // to allow the user to login 
        if (!isset($_SESSION['username'])) { 
            header('location: https://led-zepplin-forum.herokuapp.com/'); 
            exit();
        } 
ob_start();
var_dump($_POST);
print_r($_POST);



$member_id = $_SESSION['id'];
if (! empty($_POST["rating"]) && ! empty($_POST["id"])) {
    require_once ("Rate.php");
    $rate = new Rate();
    
    
    $ratingResult = $rate->getRatingByMessageForMember($_POST["id"], $member_id);
    var_dump($ratingResult);
    if (! empty($ratingResult)) {
        $rate->updateRating($_POST["rating"], $ratingResult[0]["id"]);
    } else {
        $rate->addRating($_POST["id"], $_POST["rating"], $member_id);
    }var_dump($ratingResult);
    
    $postRating = $rate->getRatingByMessage($_POST["id"]);
    var_dump($postRating);
    if (! empty($postRating[0]["rating_count"])) {
        echo $postRating[0]["rating_count"] . " Likes";
        if (! empty($postRating[0]["emoji_rating"])) {
            $emojiRatingArray = explode(",", $postRating[0]["emoji_rating"]);
            foreach ($emojiRatingArray as $emojiData) {
                ?>
                                        <img
                                src="icons/<?php echo $emojiData; ?>.png"
                                class="emoji-data" />
                                    <?php
                }
            }
    }
}
?>
