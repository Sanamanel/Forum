
<div>
        <div class="container">
          <nav aria-label="breadcrumb" role="navigation">
            <ol class="breadcrumb">
              <i class="fa fa-home mr-1 pt-1 home_icon" aria-hidden="true"></i>
              <li class="breadcrumb-item"><a href="javascript:;">Home</a></li>
              <li class="breadcrumb-item">
                <a href="./home.php">Board index</a>
              </li>
            </ol>
          </nav>
        </div>
      </div>
      <div class="container mt-3">
        <div class="row">
          <!-- structure contenu board -->

          <div class="col-lg-9 m-15px-tb main-content">
            <div>

           <?php

        
            $sql = 'select board.id as boardId,board.name as boardName,topics.title as topicTitle,topics.content as topicContent,topics.modification_date as topicModificationDate from board inner join topics on topics.board_id = board.id order by board.id ';  //Get all boards - topics - datas
   
            $result = $conn->query($sql);    // Connect to Database and Query from Database
        
           $previousBoardId = NULL; //Store the previous board id, will be used to detect if we change board

            while ($row = $result->fetch()) {
                  $boardId = $row['boardId'];
                  $boardName = $row['boardName'];
                  $topicTitle = $row['topicTitle'];
                  $topicContent = $row['topicContent'];
                  $topicModificationDate = $row['topicModificationDate'];

                  if($previousBoardId != $boardId) //When we change board
                    {
                      
                      if (!is_null($previousBoardId)) //End of previous board
                        ?></div><?php

                      ?><h2 class="text-muted font-weight-bold"><?php echo $boardName  ?></h2> <div class="d-flex flex-row flex-wrap justify-content-center"><?php
                      $previousBoardId = $boardId;
                    }

                    ?>
                      <div class="card mx-3" style="width: 15rem">
                      <div class="card-body">
                        <h4 class="card-title"><?php echo $topicTitle ?></h4>
                        <h6 class="card-subtitle mb-2 text-muted">Card subtitle</h6>
                        <p>
                          <i
                            class="fa <?php echo getRandomTopicImageClasses()?> fa-3x pr-3"
                            aria-hidden="true"
                          ></i>
                        </p>
                        <p class="card-text"><?php echo $topicContent ?></p>
                        <p class="card-text">
                      <small class="text-muted"><?php echo getLastModificationText($topicModificationDate) ?></small>
                        </p>
                        <a href="./pages/topics.php" class="card-link"
                          >Card link</a
                        >
                        <a href="./pages/topics.php" class="card-link"
                          >Another link</a
                        >
                      </div>
                      </div>
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

            
            function getRandomTopicImageClasses()
            {
              $images_types = array("fa-code","fa-desktop","fa-comments","fa-quote-right","fa-angellist","fa-user-plus","fa-bullhorn","fa-envelope-square");
              $images_colors = array("text-success","text-warning","text-info","text-primary");

              $rand_type = array_rand($images_types, 1);
              $rand_color = array_rand($images_colors, 1);

              return $images_types[$rand_type] . " " . $images_colors[$rand_color];
            }
           ?>



