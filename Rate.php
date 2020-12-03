<?php
require_once "connect.php";

class Rate extends DBController
{

    function getAllPost()
    {
        $query = "SELECT topics.*, COUNT(user_rate.rating) as rating_count, group_concat(distinct rating) as emoji_rating FROM topics LEFT JOIN user_rate ON topics.id = user_rate.topic_rate_id GROUP BY topics.id";
    // $sql = "select messages.*, COUNT(user_rate.rating) as  rating_count, group_concat(distinct rating) as emoji_rating  inner join users on messages.message_by = users.id where message_topic = '$topicId' order by creation_date DESC";
       // $messages_results = $conn->query($sql);
        
        $postResult = $this->getDBResult($query);
        return $postResult;
    }

    function getRatingByTopic($topic_id)
    {
        $query = "SELECT topics.*, COUNT(user_rate.rating) as rating_count, group_concat(distinct rating) as emoji_rating FROM topics LEFT JOIN user_rate ON topics.id = user_rate.topic_rate_id WHERE user_rate.topic_rate_id = ? GROUP BY user_rate.topic_rate_id";
        
        $params = array(
            array(
                "param_type" => "i",
                "param_value" => $topic_id
            )
        );
        
        $postResult = $this->getDBResult($query, $params);
        return $postResult;
    }

    function getRatingByTopicForMember($topic_id, $member_id)
    {
        $query = "SELECT * FROM user_rate WHERE topic_rate_id = ? AND user_rate_id = ?";
        
        $params = array(
            array(
                "param_type" => "i",
                "param_value" => $topic_id
            ),
            array(
                "param_type" => "i",
                "param_value" => $member_id
            )
        );
        
        $ratingResult = $this->getDBResult($query, $params);
        return $ratingResult;
    }

    function addRating($topic_id, $rating, $member_id)
    {
        $query = "INSERT INTO user_rate (topic_rate_id,rating,user_rate_id) VALUES (?, ?, ?)";
        
        $params = array(
            array(
                "param_type" => "i",
                "param_value" => $topic_id
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
