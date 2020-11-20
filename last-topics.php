
<?php require_once("connexion.php"); ?>
<?php
	$sql = "SELECT id, title, creation_date, link,
                            DATE_FORMAT(new_date,'%d-%m-%Y' ) 
                            AS ladate 
                            FROM topics 
                            ORDER BY new_date DESC;";
	$rs = mysql_query($sql);
?>
<div class="article">
   <h2>Last Topics</h2>
          <div class="clr"></div>
        <!-- Début de région à répéter --> 
<? while ($r = mysql_fetch_array($rs)) { ?> 
   <div class="cat">
        
        <h3> <? echo $r["title"];  ?></h3>
         <? echo $r["ladate"];  ?>
    <? echo $r["link"];  ?>
   
           
           <p></p><div class="clr"></div></div><? } 

mysql_free_result($rs);
?>
<!-- Fin de région à répéter -->
          
          <ul class="sb_menu">
            <li></li>
          </ul>



            <!-- Latest Post -->
            <div class="widget widget-latest-post">
              <div class="widget-title">
                <h3>Latest Post</h3>
              </div>
                      <!-- Début de région à répéter --> 
<? while ($r = mysql_fetch_array($rs)) { ?> 
              <div class="widget-body">
                <div class="latest-post-aside media">
                  <div class="lpa-left media-body">
                    <div class="lpa-title">
                      <h5>
                        <a href="./pages/comments.html"
                          ><? echo $r["title"];  ?></a
                        >
                      </h5>
                    </div>
                    <div class="lpa-meta">
                      <a class="name" href="#"> Rachel Roth </a>
                      <a class="date" href="#">  <? echo $r["ladate"];  ?></a>
                    </div>
                  </div>
                  <div class="lpa-right">
                    <a href="<? echo $r["link"];  ?>">
                      <img
                        src="https://via.placeholder.com/400x200/FFB6C1/000000"
                        title=""
                        alt=""
                      />
                    </a>
                  </div>
                </div>
               
              </div>
            </div>