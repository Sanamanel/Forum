<?php

$sql = "select topics.title as topicTitle,topics.content as topicContent,topics.id as topicId, topics.modification_date as topicModificationDate,users.nickname as authorNickname from topics inner join users on topics.topic_by = users.id where board_id = 6 order by creation_date DESC LIMIT 5";
$topics_results = $conn->query($sql);

?>

  <?php 
while ($topic_row = $topics_results->fetch())
{ 
 
?>
                <tr>
                  <td class=" ">
                    <div class="row">
                      <div class="col">
                   
                      </div>


                      <div class="col-10">
  
                        <h5 class="global"> <a class="text-dark"href="https://led-zepplin-forum.herokuapp.com/topic.php?topic_id=<?php echo $topic_row["topicId"] ?>" ><?php echo $topic_row['topicTitle'] ?></a>  </h5>
                        by
                        <span class="name text-capitalize text-rose"
                          ><?php echo $topic_row['authorNickname'] ?></span
                        > 
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
}
?>

