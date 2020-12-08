<?php
require_once "DBController.php";
//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
//error_reporting(E_ALL); 


class Rate extends DBController
{

    function getAllPost()
    {
        $topicId = $_GET["topic_id"];
        $query = "SELECT messages.content as messageContent,messages.id as messageId,messages.creation_date
        as messageCreationDate, messages.modification_date as messageModificationDate, messages.deleted as isDeleted, users.nickname
        as authorNickname, users.email as authorEmail, users.id as authorId, users.image as
        authorAvatar , COUNT(user_rate.rating) as  rating_count, group_concat(distinct rating) 
        as emoji_rating from messages
      left join user_rate ON messages.id = user_rate.message_rate_id 
       left join users on messages.message_by = users.id
        where message_topic ='$topicId' GROUP BY messages.id order by creation_date DESC";
    // $sql = "select messages.*, COUNT(user_rate.rating) as  rating_count, group_concat(distinct rating) as emoji_rating  inner join users on topics.message_by = users.id where message_topic = '$topicId' order by creation_date DESC";
    // "select messages.content as messageContent,messages.id as messageId,messages.creation_date as messageCreationDate, messages.modification_date as messageModificationDate,users.nickname as authorNickname, users.email as authorEmail, users.id as authorId, users.image as authorAvatar , COUNT(user_rate.rating) as  rating_count, group_concat(distinct rating) as emoji_rating  inner join users on topics.message_by = users.id where message_topic = '$topicId' from messages inner join users on messages.message_by = users.id where message_topic = '$topicId' LEFT JOIN user_rate ON messages.id = user_rate.message_rate_id GROUP BY messages.id order by creation_date DESC";
       // $messages_results = $conn->query($sql);
        
       $postResult = $this->getDBResult($query);
        return $postResult;
       
    }

    function getRatingByMessage($message_id)
    {    
        
        /*$topicId = $_GET["topic_id"];
        
        
        
        $query = "SELECT messages.content as messageContent,messages.id as messageId,messages.creation_date
        as messageCreationDate, messages.modification_date as messageModificationDate, messages.deleted as isDeleted, users.nickname
        as authorNickname, users.email as authorEmail, users.id as authorId, users.image as
        authorAvatar , COUNT(user_rate.rating) as  rating_count, group_concat(distinct rating) 
        as emoji_rating from messages
      join user_rate ON messages.id = user_rate.message_rate_id 
       join users on messages.message_by = users.id
        where messages.id ='$topicId'  GROUP BY messages.id order by creation_date DESC";*/

         $query = "SELECT messages.content as messageContent,messages.id as messageId,messages.creation_date
         as messageCreationDate, messages.modification_date as messageModificationDate, messages.deleted as isDeleted, users.nickname
         as authorNickname, users.email as authorEmail, users.id as authorId, users.image as
         authorAvatar , COUNT(user_rate.rating) as  rating_count, group_concat(distinct rating) 
         as emoji_rating from messages
       join user_rate ON messages.id = user_rate.message_rate_id 
        join users on messages.message_by = users.id
         where messages.id ='$message_id'";
        
        $params = array(
            array(
                "param_type" => "i",
                "param_value" => $message_id
            )
        );
        
        $postResult = $this->getDBResult($query, $params);
        return $postResult;
      
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
