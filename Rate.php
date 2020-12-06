<?php
require_once "DBController.php";
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL); 
$redirect = false;
$topicId = 0;
$topic_result = NULL;
// $this->conn = $conn;

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

class Rate extends DBController
{

    function getAllPost()
    {
        $query = "SELECT messages.content as messageContent,messages.id as messageId,messages.creation_date as messageCreationDate, messages.modification_date as messageModificationDate,users.nickname as authorNickname, users.email as authorEmail, users.id as authorId, users.image as authorAvatar , COUNT(user_rate.rating) as  rating_count, group_concat(distinct rating) as emoji_rating from messages
        join user_rate ON messages.id = user_rate.message_rate_id 
        join users on messages.message_by = users.id
        where message_topic ='$topicId' GROUP BY messages.id order by creation_date DESC";
    // $sql = "select messages.*, COUNT(user_rate.rating) as  rating_count, group_concat(distinct rating) as emoji_rating  inner join users on topics.message_by = users.id where message_topic = '$topicId' order by creation_date DESC";
    // "select messages.content as messageContent,messages.id as messageId,messages.creation_date as messageCreationDate, messages.modification_date as messageModificationDate,users.nickname as authorNickname, users.email as authorEmail, users.id as authorId, users.image as authorAvatar , COUNT(user_rate.rating) as  rating_count, group_concat(distinct rating) as emoji_rating  inner join users on topics.message_by = users.id where message_topic = '$topicId' from messages inner join users on messages.message_by = users.id where message_topic = '$topicId' LEFT JOIN user_rate ON messages.id = user_rate.message_rate_id GROUP BY messages.id order by creation_date DESC";
       // $messages_results = $conn->query($sql);
        
       $postResult = $this->getDBResult($query);
        return $postResult;
        var_dump($postResult );
    }

    function getRatingByMessage($message_id)
    {
        $query = "SELECT messages.content as messageContent,messages.id as messageId,messages.creation_date as messageCreationDate, messages.modification_date as messageModificationDate,users.nickname as authorNickname, users.email as authorEmail, users.id as authorId, users.image as authorAvatar , COUNT(user_rate.rating) as rating_count, group_concat(distinct rating) as emoji_rating from messages join user_rate ON messages.id = user_rate.message_rate_id join users on messages.message_by = users.id where message_topic ='1' AND user_rate.message_rate_id = ? GROUP BY messages.id order by creation_date DESC";
        
        $params = array(
            array(
                "param_type" => "i",
                "param_value" => $message_id
            )
        );
        
        $postResult = $this->getDBResult($query, $params);
        return $postResult;
        var_dump($postResult );
    }
 

    function getRatingByMessageForMember($message_id, $member_id)
    {
        $query = "SELECT * FROM user_rate WHERE message_rate_id = ? AND user_rate_id = ?";
        
        $params = array(
            array(
                "param_type" => "i",
                "param_value" => $message_id
            ),
            array(
                "param_type" => "i",
                "param_value" => $member_id
            )
        );
        
        $ratingResult = $this->getDBResult($query, $params);
        return $ratingResult;
        var_dump( $ratingResult);
    }
  
    function addRating($message_id, $rating, $member_id)
    {
        $query = "INSERT INTO user_rate (message_rate_id,rating,user_rate_id) VALUES (?, ?, ?)";
        
        $params = array(
            array(
                "param_type" => "i",
                "param_value" => $message_id
            ),
            array(
                "param_type" => "s",
                "param_value" => $rating
            ),
            array(
                "param_type" => "i",
                "param_value" => $member_id
            )
        );
        
        $this->updateDB($query, $params);
    }

    function updateRating($rating, $rating_id)
    {
        $query = "UPDATE user_rate SET  rating = ? WHERE id= ?";
        
        $params = array(
            array(
                "param_type" => "s",
                "param_value" => $rating
            ),
            array(
                "param_type" => "i",
                "param_value" => $rating_id
            )
        );
        
        $this->updateDB($query, $params);
    }
}
