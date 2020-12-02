

	
  <?php

  $sql ="SELECT title,creation_date,CONCAT(SUBSTRING_INDEX(content, ' ', 5),'...') AS resume from topics
  Order by creation_date DESC
  Limit 3";
  $stmt = $conn->query($sql);
  $sql ="SELECT * from users WHERE user_active=1 order by last_login_date desc Limit 3";
  $stmt2 = $conn->query($sql);
  $currentUsername = $_SESSION['username'];
  $currentId = $_SESSION['id'];
  $sql = "SELECT * from users WHERE nickname = '$currentUsername'";
  $stmt3 = $conn->query($sql);
  $currentUserRow = $stmt3->fetch(PDO::FETCH_ASSOC);
  
  ?>
 

<!--  3 - Titre des 3 derniers Posts-->




<!-- div aside -->
<div class="col-lg-3 m-15px-tb blog-aside">
            <!-- search -->
            <div class="navbar navbar-expand-lg navbarbtn">
              <div class="container">
                <form class="form-inline ml-auto">
                  <div class="form-group no-border">
                    <input
                      type="text"
                      class="form-control"
                      placeholder="Search"
                    />
                  </div>
                  <button
                    type="submit"
                    class="btn btn-white btn-just-icon btn-round"
                  >
                    <i class="material-icons">search</i>
                  </button>
                </form>
              </div>
            </div>
            <!-- Author -->
            <div class="widget widget-author">
              <div class="widget-title">
                <h3>User</h3>
              </div>
              <div class="widget-body">
                <div class="media align-items-center">
                  <div class="avatar">
       
                    <img class="rounded-circle border border-primary" 
                      src="<?php 
                        if(!is_null($currentUserRow['image']) && file_exists('./Uploads/images/'.$currentUserRow['image'])){
                          echo "./Uploads/images/".$currentUserRow['image'];
                        }
                        else{
                          echo "https://www.gravatar.com/avatar/".md5(strtolower(trim($currentUserRow['email'])))."?"."&s=80";
                        }
                        
                      ?>"
                      alt=""
                    />
          
                  </div>
                  <div class="media-body">
                    <h6>
                      Hello<br />
                      <?php echo $currentUsername; ?> !
                    </h6>
                  <a name="" id="" class="btn btn-sm btn-outline-primary btn-round" href="https://led-zepplin-forum.herokuapp.com/profile-page.php" role="button">My profile </a>  
                  </div>
                </div>
               
              </div>
            </div>
            <!-- End Author -->
<div class="card">
  <div class="card-header last_post text-capitalize">last post</div>
  <ul class="list-group list-group-flush">
 
     
   
  <?php while($row = $stmt->fetch(PDO::FETCH_ASSOC)) : ?>
    <li class="list-group-item">

      <div class="box_post">
        <h4 class="cat text-capitalize"><?php echo htmlspecialchars($row["title"]);?></h4>
        <h4 class="hour"><?php echo getDateDisplay($row["creation_date"]) ?></h4>
        <div class="clear_both"></div>
        <p class="card_pra"><?php echo htmlspecialchars($row["resume"]);?></p>
        <span class="tags">tags: test <span>workeot repot</span></div></li> <?php endwhile; ?>

<!-- Fin de région à répéter -->  
  </ul>
</div>
            <!-- Last users -->
            <!-- Start Last Active User-->

            <div class="card">
              <div class="card-header last_post text-capitalize">
                active user
              </div>
              <ul class="list-group list-group-flush user_active">
              <?php while($row = $stmt2->fetch(PDO::FETCH_ASSOC)) : ?>
                <li class="list-group-item">
                  <div class="box_post box_image">
                    <div class="img active">
                    <img class="rounded-circle border border-primary"
                      src="<?php 
                        if(!is_null($row['image']) && file_exists('./Uploads/images/'.$row['image'])){
                          echo "./Uploads/images/".$row['image'];
                        }
                        else{
                          echo "https://www.gravatar.com/avatar/".md5(strtolower(trim($row['email'])))."?"."&s=80";
                        }
                        
                      ?>"
                      alt=""
                    />
                    </div>
                    <p class="neck_name text-capitalize mt-2"><?php echo ($row["nickname"]);?></p>
                  </div>
                </li><?php endwhile; ?>
               
               
              </ul>
            </div>
            <!-- End Last Active User-->
            <!-- End Last users-->
          </div>

          <!-- fin test structure -->
        </div>
      </div>