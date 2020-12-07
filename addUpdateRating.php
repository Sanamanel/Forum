<?php
// Here the member id is harcoded.
// You can integrate your authentication code here to get the logged in member id

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
                                        <img
                                src="icons/<?php echo $emojiData; ?>.png"
                                class="emoji-data" />
                                    <?php
                }
            }
    }
}
?>