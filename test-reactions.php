<?php
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
// Here the member id is harcoded.
// You can integrate your authentication code here to get the logged in member id
$member_id = $_SESSION['username'];
$emojiArray = array("like", "love", "smile", "wow", "sad", "angry");
require_once ("Rate.php");
$rate = new Rate();
$result = $rate->getAllPost();
include("header.php");
?>
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
  <?php include("footer.php"); ?>