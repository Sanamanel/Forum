
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
<!--  3 - Titre des 3 derniers Posts-->

            <!-- Latest Post -->
            <  < class="line"></>

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
         