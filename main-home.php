
<div>
        <div class="container">
          <nav aria-label="breadcrumb" role="navigation">
            <ol class="breadcrumb">
              <i class="fa fa-home mr-1 pt-1 home_icon" aria-hidden="true"></i>
              <li class="breadcrumb-item"><a href="javascript:;">Home</a></li>
           
            </ol>
          </nav>
        </div>
      </div>
      <div class="container mt-3">
        <div class="row">
          <!-- structure contenu board --->

          <div class="col-lg-9 m-15px-tb main-content">
            <div>

           <?php

            $sql = 'select board.id as boardId,board.name as boardName from board order by board.id ';  
            $boards_results = $conn->query($sql); 
            while ($board_row = $boards_results->fetch()) {
              $boardId = $board_row['boardId'];
              $boardName = $board_row['boardName'];

              ?>
              <?php
                if($boardId != 5){
                  echo '<a href="./board.php?board_id='.$boardId.'"><h2 class="font-weight-bold">  '.$boardName.'</h2></a>';
                }else{
                  echo ' <h2 class="font-weight-bold text-primary">  '.$boardName.'</h2>';
                }
              ?> <div class="d-flex flex-row flex-wrap justify-content-center"><?php

              $sql = "select topics.title as topicTitle,topics.content as topicContent,topics.id as topicId, topics.modification_date as topicModificationDate from topics where board_id = '$boardId' order by id desc limit 3";  //Get all topics for board

              $topics_results = $conn->query($sql); 
              while ($topic_row = $topics_results->fetch()) {
                $topicTitle = $topic_row['topicTitle'];
                $topicContent = $topic_row['topicContent'];
                $topicID= $topic_row['topicId'];
                $topicModificationDate = $topic_row['topicModificationDate'];
                
                ?>
                <div class="card mx-3" style="width: 15rem">
                <div class="card-body">
                  <h4 class="card-title"><?php echo $topicTitle ?></h4>
                 
                  <p class="card-text"><?php echo $topicContent ?></p>
                  <p class="card-text">
                <small class="text-muted"><?php echo getLastModificationText($topicModificationDate) ?></small>
                  </p>
                  <?php
                    if($boardId != 5){
                      echo '<a href="./topic.php?topic_id='.$topic_row["topicId"].'" class="card-link">All comments</a>';
                    }
                  ?>
                 
                </div>
                  
                </div>
              <?php
              }
              ?></div>
              <?php
                if($boardId != 5){
                  echo '<a href="./board.php?board_id='.$boardId.'"><div class="d-flex justify-content-end mr-4"><button class="btn btn-primary btn-round btn-center text-capitalize text-center justify-content-center">More about this</button></div></a>';
                }
              ?>
            
              <?php
             
            }

            ?></div></div><?php


            function getLastModificationText($modificationDate) //Get last modification text
            {
              if (is_null($modificationDate))
                return "";
              $modifDate  = new DateTime($modificationDate);
              $nowDate = new DateTime();
              
              $interval = $modifDate->diff($nowDate); //Compute time interval between 2 dates
              return "Last updated " . formatTimeLapse($interval) . " ago";

            }

            function formatTimeLapse($interval) //format time lapse
            {
              if($interval->d > 0)
                return $interval->d . " " . "days";
              
              if($interval->h > 0)
                return $interval->h . " " . "hours";

              if($interval->i > 0)
                return $interval->i. " " . "minutes";

            }

            
           


