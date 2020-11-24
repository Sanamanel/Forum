<?php include 'connect.php'?>

<div>
        <div class="container">
          <nav aria-label="breadcrumb" role="navigation">
            <ol class="breadcrumb">
              <i class="fa fa-home mr-1 pt-1 home_icon" aria-hidden="true"></i>
              <li class="breadcrumb-item"><a href="javascript:;">Home</a></li>
              <li class="breadcrumb-item">
                <a href="./index.html">Board index</a>
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
            $result = $con->query($sql);    // Connect to Database and Query from Database
            $cats = array();                  //This Array Stor all Catigories
            $cats_id = array();                  //This Array Stor all Catigories
            $counter=0;

            while ($row = $result->fetch()) {   
              if($counter<sizeof($row)){
                $cats[$counter] = $row['name'];  //Stor Only The Name of Categories to Array
                $cats_id [$counter] = $row['id'];  //Stor Only The Id of Categories to Array
                $counter++;
              }
                
            }
            //--- End Board

            //---Start Topics 
            $titles = array();    //This Array Stor all Title
            $contents = array();  //This Array Stor all Contents
            $counter = 0;
            //$id_of_cat = 0;

              $stm = $con->prepare('select title,content from topics where board_id_fk = ? ');
              $stm->execute(array($cats_id[0]));
          
            

              while ($row = $stm->fetch()) {  
                if($counter <= sizeof($row)){
                  $titles[$counter] = $row['title'];      //Stor Only The Tilte to Array  $cats[0] 
                  $contents[$counter] = $row['content'];  //Stor Only The Content to Array
                  $counter++;
                }

              }

                //----------------------------------

              $stm1 = $con->prepare('select title,content from topics where board_id_fk = ? ');
              $stm1->execute(array($cats_id[1]));
              
              

              while ($row = $stm1->fetch()) {  
                if($counter <= sizeof($row)){
                  $titles[$counter] = $row[0];      //Stor Only The Tilte to Array  
                  $contents[$counter] = $row[0];  //Stor Only The Content to Array
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
                    <h4 class="card-title"><?php echo $titles[0] ?></h4>
                    <h6 class="card-subtitle mb-2 text-muted">Card subtitle</h6>
                    <i
                      class="fa fa-3x fa-code text-info pr-3"
                      aria-hidden="true"
                    ></i>
                    <p class="card-text"><?php echo  $cats[1]? $contents[0] : '' ?></p>
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
                    <h4 class="card-title">Topic Type Demo</h4>
                    <h6 class="card-subtitle mb-2 text-muted">Card subtitle</h6>
                    <i
                      class="fa fa-3x fa-desktop text-warning pr-3"
                      aria-hidden="true"
                    ></i>
                    <p class="card-text">
                      Some quick example text to build on the card title and
                      make up the bulk of the card's content.
                    </p>
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
                    <h4 class="card-title">Topic Type Demo</h4>
                    <h6 class="card-subtitle mb-2 text-muted">Card subtitle</h6>
                    <i
                      class="fa fa-3x fa-comments text-success pr-3"
                      aria-hidden="true"
                    ></i>
                    <p class="card-text">
                      Some quick example text to build on the card title and
                      make up the bulk of the card's content.
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
                    <h4 class="card-title">Topic Type Demo</h4>
                    <h6 class="card-subtitle mb-2 text-muted">Card subtitle</h6>
                    <i
                      class="fa fa-3x fa-quote-right text-info pr-3"
                      aria-hidden="true"
                    ></i>
                    <p class="card-text">
                      Some quick example text to build on the card title and
                      make up the bulk of the card's content.
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
                    <h4 class="card-title">Topic Type Demo</h4>
                    <h6 class="card-subtitle mb-2 text-muted">Card subtitle</h6>
                    <i
                      class="fa fa-3x fa-angellist text-primary pr-3"
                      aria-hidden="true"
                    ></i>
                    <p class="card-text">
                      Some quick example text to build on the card title and
                      make up the bulk of the card's content.
                    </p>
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
                    <h4 class="card-title">Topic Type Demo</h4>
                    <h6 class="card-subtitle mb-2 text-muted">Card subtitle</h6>
                    <i
                      class="fa fa-3x fa-user-plus text-info pr-3"
                      aria-hidden="true"
                    ></i>
                    <p class="card-text">
                      Some quick example text to build on the card title and
                      make up the bulk of the card's content.
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
                    <h4 class="card-title">Topic Type Demo</h4>
                    <h6 class="card-subtitle mb-2 text-muted">Card subtitle</h6>

                    <i
                      class="fa fa-3x fa-bullhorn text-warning pr-3"
                      aria-hidden="true"
                    ></i>

                    <p class="card-text">
                      Some quick example text to build on the card title and
                      make up the bulk of the card's content.
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
                    <h4 class="card-title">Topic Type Demo</h4>
                    <h6 class="card-subtitle mb-2 text-muted">Card subtitle</h6>
                    <i
                      class="fa fa-3x fa-envelope-square text-success pr-3"
                      aria-hidden="true"
                    ></i>

                    <p class="card-text">
                      Some quick example text to build on the card title and
                      make up the bulk of the card's content.
                    </p>
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