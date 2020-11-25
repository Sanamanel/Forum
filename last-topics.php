<?php include("header.php"); ?>
<?php
  $host = 'remotemysql.com:3306';
  $dbname = 'Q2qsa8HqT2';
  $username = 'Q2qsa8HqT2';
  $password = 'vkN1eNSWhe';
    
  $dsn = "mysql:host=$host;dbname=$dbname"; 
  // 3 - Titre des 3 derniers Posts
	$sql ="SELECT title,creation_date,SUBSTRING_INDEX(content, '... ', 5) AS resume from topics
  Order by creation_date DESC
  Limit 3";
   
  try{
   $pdo = new PDO($dsn, $username, $password);
   $stmt = $pdo->query($sql);
   
   if($stmt === false){
    die("Erreur");
   }
   
  }catch (PDOException $e){
    echo $e->getMessage();
  }
?>


  <!-- Author -->
  <div class="widget widget-author">
              <div class="widget-title">
                <h3>Author</h3>
              </div>
              <div class="widget-body">
                <div class="media align-items-center">
                  <div class="avatar">
                    <img
                      src="./assets/img/hi-chandler.png"
                      title=""
                      alt=""
                    />
                  </div>
                  <div class="media-body">

                    <h6>Ali Mundher saeed</h6>
                  </div>
                </div>
               
              </div>
            </div>
            <!-- End Author -->
<!--  3 - Titre des 3 derniers Posts-->

            <!-- Latest Post -->
           

<div class="card">
  <div class="card-header last_post text-capitalize">last post</div>
  <ul class="list-group list-group-flush">
 
     
   
  <?php while($row = $stmt->fetch(PDO::FETCH_ASSOC)) : ?>
    <li class="list-group-item">

      <div class="box_post">
        <h4 class="cat text-capitalize"><?php echo htmlspecialchars($row["title"]);?></h4>
        <h4 class="hour"><?php echo htmlspecialchars($row["creation_date"]);?></h4>
        <div class="clear_both"></div>
        <p class="card_pra"><?php echo htmlspecialchars($row["resume"]);?></p>
  
        <span class="tags">tags: test <span>workeot repot</span></div></li> <?php endwhile; ?>

<!-- Fin de région à répéter -->


    
   
  </ul>
</div>
<!-- Start Last Active User-->

<div class="card">
              <div class="card-header last_post text-capitalize">
                last active user
              </div>
              <ul class="list-group list-group-flush user_active">
                <li class="list-group-item">
                  <div class="box_post box_image">
                    <div class="img active"></div>
                    <p class="neck_name text-capitalize mt-2">#mohnhyfgf</p>
                    <p class="help text-capitalize">here to help</p>
                  </div>
                </li>
                <li class="list-group-item">
                  <div class="box_post box_image">
                    <div class="img"></div>
                    <p class="neck_name text-capitalize mt-2">#colnhyfgf</p>
                    <p class="help text-capitalize">here to help</p>
                  </div>
                </li>
                <li class="list-group-item">
                  <div class="box_post box_image">
                    <div class="img"></div>
                    <p class="neck_name text-capitalize mt-2">#egohnhyfgf</p>
                    <p class="help text-capitalize">here to help</p>
                  </div>
                </li>
              </ul>
            </div>
            <!-- End Last Active User-->
            <!-- End Last users-->
          </div>

          <!-- fin test structure -->
        </div>
      </div>
<?php include("footer.php"); ?>