<?php echo "connect.php" ?>
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

            //---Start Board 
            $sql = 'select * from board ';  // Fetch All Rows From Board Table
            $result = $conn >query($sql);    // Connect to Database and Query from Database
            $cats = array();                  //This Array Stor all Categories
            $cats_id = array();                  //This Array Stor all Categories
            $counter=0;

            var_dump($result);
           
            while ($row = $result->fetch()) {   
              if($counter<sizeof($row)){
                $cats[$counter] = $row['name'];  //Stor Only The Name of Categories to Array
                $cats_id [$counter] = $row['id'];  //Stor Only The Id of Categories to Array
                $counter++;
              }
             
                
            }
            var_dump($cats);
            //--- End Board

            //---Start Topics 
            $titles = array();    //This Array Stor all Title
            $contents = array();  //This Array Stor all Contents
            $counter = 0;
            //$id_of_cat = 0;

              $stm = $conn->prepare('select title,content from topics where board_id = ? ');
              $stm->execute(array($cats_id[0]));
          
            

              while ($row = $stm->fetch()) {  
                if($counter <= sizeof($row)){
                  $titles[$counter] = $row['title'];      //Stor Only The Title to Array  $cats[0] 
                  $contents[$counter] = $row['content'];  //Stor Only The Content to Array
                  $counter++;
                }

              }

              $counter=0;
                //---------------- Normal ------------------
              $m = array();
              $n = array();
                  $stm1 = $conn->prepare('select title,content from topics where board_id = ? ');
                  $stm1->execute(array($cats_id[1]));
              
                while ($row = $stm1->fetch()) {  
                  if($counter <= sizeof($row)){
                    $m[$counter] = $row["title"];      //Stor Only The Title to Array  
                    $n[$counter] = $row["content"];  //Stor Only The Content to Array
                    $counter++;
                  }
                  
                } 
              
                $counter=0;
                //---------------- Design ------------------
              $d_titles = array();
              $d_contents = array();
                  $stm1 = $conn->prepare('select title,content from topics where board_id = ? ');
                  $stm1->execute(array($cats_id[2]));
              
                while ($row = $stm1->fetch()) {  
                  if($counter <= sizeof($row)){
                    $d_titles[$counter] = $row["title"];      //Stor Only The Title to Array  
                    $d_contents[$counter] = $row["content"];  //Stor Only The Content to Array
                    $counter++;
                  }
                  
                } 
            
                $counter=0;
                //---------------- Events ------------------
              $e_titles = array();
              $e_contents = array();
                  $stm1 = $conn->prepare('select title,content from topics where board_id = ? ');
                  $stm1->execute(array($cats_id[3]));
              
                while ($row = $stm1->fetch()) {  
                  if($counter <= sizeof($row)){
                    $e_titles[$counter] = $row["title"];      //Stor Only The Title to Array  
                    $e_contents[$counter] = $row["content"];  //Stor Only The Content to Array
                    $counter++;
                  }
                  
                } 
            

            //--- End Topics


          ?>
              <h2 class="text-muted font-weight-bold"><?php echo $cats[0]  ?></h2>

              <div class="d-flex flex-row flex-wrap justify-content-center">
                <div class="card mr-2" style="width: 15rem">
                  <div class="card-body">
                    <h4 class="card-title"><?php echo $titles[0] ?></h4>
                    <h6 class="card-subtitle mb-2 text-muted">Card subtitle</h6>
                    <p>
                      <i
                        class="fa fa-bell fa-3x text-primary pr-3"
                        aria-hidden="true"
                      ></i>
                      This is the topic
                    </p>
                    <p class="card-text"><?php echo $contents[0] ?></p>
                    <p class="card-text">
                      <small class="text-muted">Last updated 3 mins ago</small>
                    </p>
                    <a href="./pages/topics.html" class="card-link"
                      >Card link</a
                    >
                    <a href="./pages/topics.html" class="card-link"
                      >Another link</a
                    >
                  </div>
                </div>
                <div class="card mx-3" style="width: 15rem">
                  <div class="card-body">
                    <h4 class="card-title"><?php echo $titles[1] ?></h4>
                    <h6 class="card-subtitle mb-2 text-muted">Card subtitle</h6>
                    <p>
                      <i
                        class="fa fa-birthday-cake fa-3x text-success pr-3"
                        aria-hidden="true"
                      ></i>
                      This is the topic
                    </p>
                    <p class="card-text"><?php echo $contents[1] ?></p>
                    <p class="blockquote-footer">
                      <small class="text-muted">
                        Someone famous in
                        <cite title="Source Title">Source Title</cite>
                      </small>
                    </p>
                    <a href="./pages/topics.html" class="card-link"
                      >Card link</a
                    >
                    <a href="./pages/topics.html" class="card-link"
                      >Another link</a
                    >
                  </div>
                </div>
                <div class="card mx-3" style="width: 15rem">
                  <div class="card-body">
                    <h4 class="card-title"><?php echo $titles[2] ?></h4>
                    <h6 class="card-subtitle mb-2 text-muted">Card subtitle</h6>
                    <p>
                      <i
                        class="fa fa-bolt fa-3x text-warning pr-3"
                        aria-hidden="true"
                      ></i>
                      This is the topic
                    </p>
                    <p class="card-text"><?php echo $contents[2] ?></p>
                    <a href="./pages/topics.html" class="card-link"
                      >Card link</a
                    >
                    <a href="./pages/topics.html" class="card-link"
                      >Another link</a
                    >
                  </div>
                </div>
                <div class="card mx-3" style="width: 15rem">
                  <div class="card-body">
                    <h4 class="card-title"><?php echo $titles[3] ?></h4>
                    <h6 class="card-subtitle mb-2 text-muted">Card subtitle</h6>
                    <p>
                      <i
                        class="fa fa-bug fa-3x text-info pr-3"
                        aria-hidden="true"
                      ></i>
                      This is the topic
                    </p>
                    <p class="card-text"><?php echo $contents[3] ?></p>
                    <a href="./pages/topics.html" class="card-link"
                      >Card link</a
                    >
                    <a href="./pages/topics.html" class="card-link"
                      >Another link</a
                    >
                  </div>
                </div>
                <div class="card mx-3" style="width: 15rem">
                  <div class="card-body">
                    <h4 class="card-title"><?php echo $titles[4] ?></h4>
                    <h6 class="card-subtitle mb-2 text-muted">Card subtitle</h6>
                    <p>
                      <i
                        class="fa fa-heart fa-3x text-danger pr-3"
                        aria-hidden="true"
                      ></i>
                      This is the topic
                    </p>
                    <p class="card-text"><?php echo $contents[4] ?></p>
                    <a href="./pages/topics.html" class="card-link"
                      >Card link</a
                    >
                    <a href="./pages/topics.html" class="card-link"
                      >Another link</a
                    >
                  </div>
                </div>
              </div>
            </div>
            <div>
            
              <h2 class="text-muted font-weight-bold"><?php echo $cats[1] ?></h2>
              <div class="d-flex flex-row flex-wrap justify-content-center">
                <div class="card mx-3" style="width: 15rem">
                  <div class="card-body">
                    <h4 class="card-title"><?php echo $m[0]  ?></h4>
                    <h6 class="card-subtitle mb-2 text-muted">Card subtitle</h6>
                    <i
                      class="fa fa-3x fa-code text-info pr-3"
                      aria-hidden="true"
                    ></i>
                    <p class="card-text"><?php echo $n[0] ?></p>
                    <a href="./pages/topics.html" class="card-link"
                      >Card link</a
                    >
                    <a href="./pages/topics.html" class="card-link"
                      >Another link</a
                    >
                  </div>
                </div>
                <div class="card mx-3" style="width: 15rem">
                  <div class="card-body">
                    <h4 class="card-title"><?php echo $m[1]  ?></h4>
                    <h6 class="card-subtitle mb-2 text-muted">Card subtitle</h6>
                    <i
                      class="fa fa-3x fa-desktop text-warning pr-3"
                      aria-hidden="true"
                    ></i>
                    <p class="card-text"><?php echo $n[1] ?></p>
                    <a href="./pages/topics.html" class="card-link"
                      >Card link</a
                    >
                    <a href="./pages/topics.html" class="card-link"
                      >Another link</a
                    >
                  </div>
                </div>
              </div>
            </div>
            <div>
              <h2 class="text-muted font-weight-bold"><?php echo $cats[2] ?></h2>
              <div class="d-flex flex-row flex-wrap justify-content-center">
                <div class="card mx-3" style="width: 15rem">
                  <div class="card-body">
                    <h4 class="card-title"><?php echo $d_titles[0] ?></h4>
                    <h6 class="card-subtitle mb-2 text-muted">Card subtitle</h6>
                    <i
                      class="fa fa-3x fa-comments text-success pr-3"
                      aria-hidden="true"
                    ></i>
                    <p class="card-text"><?php echo $d_contents[0] ?></p>
                    <a href="./pages/topics.html" class="card-link"
                      >Card link</a
                    >
                    <a href="./pages/topics.html" class="card-link"
                      >Another link</a
                    >
                  </div>
                </div>
                <div class="card mx-3" style="width: 15rem">
                  <div class="card-body">
                    <h4 class="card-title"><?php echo $d_titles[1] ?></h4>
                    <h6 class="card-subtitle mb-2 text-muted">Card subtitle</h6>
                    <i
                      class="fa fa-3x fa-quote-right text-info pr-3"
                      aria-hidden="true"
                    ></i>
                    <p class="card-text"><?php echo $d_contents[1] ?></p>
                    <a href="./pages/topics.html" class="card-link"
                      >Card link</a
                    >
                    <a href="./pages/topics.html" class="card-link"
                      >Another link</a
                    >
                  </div>
                </div>
                <div class="card mx-3" style="width: 15rem">
                  <div class="card-body">
                    <h4 class="card-title"><?php echo $d_titles[2] ?></h4>
                    <h6 class="card-subtitle mb-2 text-muted">Card subtitle</h6>
                    <i
                      class="fa fa-3x fa-angellist text-primary pr-3"
                      aria-hidden="true"
                    ></i>
                    <p class="card-text"><?php echo $d_contents[2] ?></p>
                    <a href="./pages/topics.html" class="card-link"
                      >Card link</a
                    >
                    <a href="./pages/topics.html" class="card-link"
                      >Another link</a
                    >
                  </div>
                </div>
              </div>
            </div>

            <div>
              <h2 class="text-muted font-weight-bold"><?php echo $cats[3] ?></h2>
              <div class="d-flex flex-row flex-wrap justify-content-center">
                <div class="card mx-3" style="width: 15rem">
                  <div class="card-body">
                    <h4 class="card-title"><?php echo $e_titles[0] ?></h4>
                    <h6 class="card-subtitle mb-2 text-muted">Card subtitle</h6>
                    <i
                      class="fa fa-3x fa-user-plus text-info pr-3"
                      aria-hidden="true"
                    ></i>
                    <p class="card-text"><?php echo $e_contents[0] ?></p>
                    <a href="./pages/topics.html" class="card-link"
                      >Card link</a
                    >
                    <a href="./pages/topics.html" class="card-link"
                      >Another link</a
                    >
                  </div>
                </div>
                <div class="card mx-3" style="width: 15rem">
                  <div class="card-body">
                    <h4 class="card-title"><?php echo $e_titles[1] ?></h4>
                    <h6 class="card-subtitle mb-2 text-muted">Card subtitle</h6>

                    <i
                      class="fa fa-3x fa-bullhorn text-warning pr-3"
                      aria-hidden="true"
                    ></i>

                    <p class="card-text"><?php echo $e_contents[1] ?></p>
                    <a href="./pages/topics.html" class="card-link"
                      >Card link</a
                    >
                    <a href="./pages/topics.html" class="card-link"
                      >Another link</a
                    >
                  </div>
                </div>
                <div class="card mx-3" style="width: 15rem">
                  <div class="card-body">
                    <h4 class="card-title"><?php echo $e_titles[2] ?></h4>
                    <h6 class="card-subtitle mb-2 text-muted">Card subtitle</h6>
                    <i
                      class="fa fa-3x fa-envelope-square text-success pr-3"
                      aria-hidden="true"
                    ></i>

                    <p class="card-text"><?php echo $e_contents[2] ?></p>
                    <a href="./pages/topics.html" class="card-link"
                      >Card link</a
                    >
                    <a href="./pages/topics.html" class="card-link"
                      >Another link</a
                    >
                  </div>
                </div>
              </div>
            </div>
          </div>
        