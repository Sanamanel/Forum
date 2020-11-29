
  <div class="section text-center">
          <nav aria-label="breadcrumb" role="navigation">
            <ol class="breadcrumb">
              <i class="fa fa-home mr-1 pt-1 home_icon" aria-hidden="true"></i>
              <li class="breadcrumb-item"><a href="./home.php">Home</a></li>
              
              <li class="breadcrumb-item">
                <a href="./topics.php?id=4">Topics of Events</a>
              </li>
              
            </ol>
          </nav>
        </div>
 
        <!-- Start New Topic, Box Search -->
        <div class="row">
          <div class="col-md-9">
            <h4 class="topic_title mb-3">Topics of Events</h4>
            <div class="alert alert-danger my_alert mb-4" role="alert">
            Forum Rules Of the Events Board
            </div>

            <!-- Start Row Two -->
            <div class="row">
              <div class="col-md-4 col-sm-12">
                <div class="col">
                  <button class="btn_custum text-capitalize text-center mb-2">
                    new topic
                    <i class="fa fa-pencil ml-1 p" aria-hidden="true"></i>
                  </button>
                </div>
              </div>
              <div class="col-md-4 col-sm-12">
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
              </div>

              <div class="col-md-4 col-sm-12 col-xm-12 text-right count_page">
                12 topics, pages 1 of 1
              </div>
            </div>
            <!-- End Row Two-->

            <!-- Start Third Row Card-->

            <table class="table table-bordered mt-5">
              <thead class="table-bg">
                <tr class="text-white">
                  <th class="text-capitalize">Announcements</th>
                  <th>
                    <i class="fa fa-comments" aria-hidden="true"></i>
                  </th>
                  <th>
                    <i class="fa fa-eye" aria-hidden="true"></i>
                  </th>
                  <th>
                    <i class="fa fa-clock-o" aria-hidden="true"></i>
                  </th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td class=" ">
                    <div class="row">
                      <div class="col">
                        <i class="fa fa-bullhorn frst_i" aria-hidden="true"></i>
                      </div>
                      <div class="col-10">
                        <i
                          class="fa fa-bullhorn float-right text-primary"
                          aria-hidden="true"
                        ></i>
                        <h5 class="global">this is a global announcements</h5>

                        by <span class="name text-capitalize">carla</span>
                        <span>>> in Unread Forum</span>
                      </div>
                    </div>
                  </td>

                  <td>201</td>
                  <td>201</td>
                  <td>
                    <div class="text_cell">
                      by <span>carla</span>
                      <p>Sun Oct 09, 2016 5:58 pm</p>
                    </div>
                  </td>
                </tr>
              </tbody>
            </table>
            <!-- End Third Row Card-->

            <!-- Start Fourth Row Card-->

            <table class="table table-bordered mt-5">
              <thead class="table-bg">
                <tr class="text-white">
                  <th class="text-capitalize">Topics</th>
                  <th>
                    <i class="fa fa-comments" aria-hidden="true"></i>
                  </th>
                  <th>
                    <i class="fa fa-eye" aria-hidden="true"></i>
                  </th>
                  <th>
                    <i class="fa fa-clock-o" aria-hidden="true"></i>
                  </th>
                </tr>
              </thead>
              <tbody>
              <?php

$sql = "select topics.title as topicTitle,topics.id as topicId, topics.modification_date as topicModificationDate, users.nickname as topicBy from topics INNER JOIN users on topic_by = users.id  where board_id = '4' order by topicModificationDate DESC";
$topics_results = $conn->query($sql); 
while ($topic_row = $topics_results->fetch()) {
$topicTitle = $topic_row['topicTitle'];
$topicID= $topic_row['topicId'];
$topicModificationDate = $topic_row['topicModificationDate'];
$topicBy = $topic_row['topicBy'];
?>
                <tr>
                  <td class=" ">
                    <div class="row">
                      <div class="col">
                        <i
                          class="fa frst_i  <?php echo getRandomTopicImageClasses()?> "
                          aria-hidden="true"
                        ></i>
                      </div>
  
                      
                      <div class="col-10">
                        <h5 class="global"><?php echo $topicTitle ?></h5>
                        by
                        <span class="name text-capitalize text-rose"
                          ><?php echo $topicBy ?></span
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
                        ><?php echo $topicBy ?></span
                      >
                      <p><?php echo $topicModificationDate ?></p>
                    </div>
                  </td>
                </tr>
                <?php
              }
              ?>

              <?php
               function getRandomTopicImageClasses()
               {
                 $images_types = array("fa-check green ","fa-check green","fa-check red","fa-times gray","fa-check gray");
                 
   
                 $rand_type = array_rand($images_types, 1);
                 
   
                 return $images_types[$rand_type] ;
               }
              ?>
                <tr>
                  <td class=" ">
                    <div class="row">
                      <div class="col">
                        <i
                          class="fa fa-check frst_i green"
                          aria-hidden="true"
                        ></i>
                      </div>
                      <div class="col-10">
                        <h5 class="global">topic unread (mine)</h5>
                        by
                        <span class="name text-capitalize text-rose"
                          >plantes styles</span
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
                        >plantes styles</span
                      >
                      <p>Sun Oct 09, 2016 5:58 pm</p>
                    </div>
                  </td>
                </tr>
                <tr>
                  <td class=" ">
                    <div class="row">
                      <div class="col">
                        <i
                          class="fa fa-check frst_i gray"
                          aria-hidden="true"
                        ></i>
                      </div>
                      <div class="col-10">
                        <h5 class="global">topic read (mine)</h5>
                        by
                        <span class="name text-capitalize text-rose"
                          >plantes styles</span
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
                        >plantes styles</span
                      >
                      <p>Sun Oct 09, 2016 5:58 pm</p>
                    </div>
                  </td>
                </tr>
                <tr>
                  <td class=" ">
                    <div class="row">
                      <div class="col">
                        <i
                          class="fa fa-check frst_i gray"
                          aria-hidden="true"
                        ></i>
                      </div>
                      <div class="col-10">
                        <h5 class="global">topic read (mine)</h5>
                        by
                        <span class="name text-capitalize text-rose"
                          >plantes styles</span
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
                        >plantes styles</span
                      >
                      <p>Sun Oct 09, 2016 5:58 pm</p>
                    </div>
                  </td>
                </tr>
                <tr>
                  <td class=" ">
                    <div class="row">
                      <div class="col">
                        <i
                          class="fa fa-check frst_i red"
                          aria-hidden="true"
                        ></i>
                      </div>
                      <div class="col-10">
                        <h5 class="global">topic unread (located, mine)</h5>
                        by
                        <span class="name text-capitalize text-rose"
                          >plantes styles</span
                        >
                        <i
                          class="fa fa-lock float-right text-primary"
                          aria-hidden="true"
                        ></i>
                      </div>
                    </div>
                  </td>

                  <td>301</td>
                  <td>401</td>
                  <td>
                    <div class="text_cell">
                      by
                      <span class="text-rose text-capitalize name"
                        >plantes styles</span
                      >
                      <p>Sun Oct 08, 2017 7:58 pm</p>
                    </div>
                  </td>
                </tr>
                <tr>
                  <td class=" ">
                    <div class="row">
                      <div class="col">
                        <i
                          class="fa fa-check frst_i red"
                          aria-hidden="true"
                        ></i>
                      </div>
                      <div class="col-10">
                        <h5 class="global">topic unread (located, mine)</h5>
                        by
                        <span class="name text-capitalize text-rose"
                          >plantes styles</span
                        >
                        <i
                          class="fa fa-lock float-right text-primary"
                          aria-hidden="true"
                        ></i>
                      </div>
                    </div>
                  </td>

                  <td>101</td>
                  <td>701</td>
                  <td>
                    <div class="text_cell">
                      by
                      <span class="text-rose text-capitalize name"
                        >plantes styles</span
                      >
                      <p>Sun Oct 1, 2016 10:58 pm</p>
                    </div>
                  </td>
                </tr>
                <tr>
                  <td class=" ">
                    <div class="row">
                      <div class="col">
                        <i
                          class="fa fa-times frst_i gray"
                          aria-hidden="true"
                        ></i>
                      </div>
                      <div class="col-10">
                        <h5 class="global">topic unread (located, mine)</h5>
                        by
                        <span class="name text-capitalize text-rose"
                          >plantes styles</span
                        >
                        <i
                          class="fa fa-lock float-right text-primary"
                          aria-hidden="true"
                        ></i>
                      </div>
                    </div>
                  </td>

                  <td>107</td>
                  <td>701</td>
                  <td>
                    <div class="text_cell">
                      by
                      <span class="text-rose text-capitalize name"
                        >plantes styles</span
                      >
                      <p>Sun Oct 1, 2016 10:58 pm</p>
                    </div>
                  </td>
                </tr>
                <tr>
                  <td class=" ">
                    <div class="row">
                      <div class="col">
                        <i
                          class="fa fa-times frst_i gray"
                          aria-hidden="true"
                        ></i>
                      </div>
                      <div class="col-10">
                        <h5 class="global">topic unread (located, mine)</h5>
                        by
                        <span class="name text-capitalize text-rose"
                          >plantes styles</span
                        >
                        <i
                          class="fa fa-lock float-right text-primary"
                          aria-hidden="true"
                        ></i>
                      </div>
                    </div>
                  </td>

                  <td>607</td>
                  <td>701</td>
                  <td>
                    <div class="text_cell">
                      by
                      <span class="text-rose text-capitalize name"
                        >plantes styles</span
                      >
                      <p>Sun Oct 1, 2016 10:58 pm</p>
                    </div>
                  </td>
                </tr>
                <tr>
                  <td class=" ">
                    <div class="row">
                      <div class="col">
                        <i
                          class="fa fa-check frst_i gray"
                          aria-hidden="true"
                        ></i>
                      </div>
                      <div class="col-10">
                        <h5 class="global">topic read (mine)</h5>
                        by
                        <span class="name text-capitalize text-rose"
                          >plantes styles</span
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
                        >plantes styles</span
                      >
                      <p>Sun Oct 09, 2016 5:58 pm</p>
                    </div>
                  </td>
                </tr>
                <tr>
                  <td class=" ">
                    <div class="row">
                      <div class="col">
                        <i
                          class="fa fa-check frst_i gray"
                          aria-hidden="true"
                        ></i>
                      </div>
                      <div class="col-10">
                        <h5 class="global">topic read (mine)</h5>
                        by
                        <span class="name text-capitalize text-rose"
                          >plantes styles</span
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
                        >plantes styles</span
                      >
                      <p>Sun Oct 09, 2016 5:58 pm</p>
                    </div>
                  </td>
                </tr>
              
              
               
               
              </tbody>
            </table>
            <!-- End Fourth Row Card-->

            <!-- Start Fiveth Row -->
            <div class="row mt-5">
              <div class="col-md-4 col-sm-12">
                <div class="col">
                  <button class="btn_custum text-capitalize text-center mb-2">
                    new topic
                    <i class="fa fa-pencil ml-1 p" aria-hidden="true"></i>
                  </button>
                </div>
              </div>
              <div class="col-md-2 col-sm-12">
                <div class="dropdown">
                  <button
                    class="btn btn-primary btn-round dropdown-toggle btn_sort"
                    type="button"
                    id="drop"
                    data-toggle="dropdown"
                    aria-haspopup="true"
                    aria-expanded="false"
                  >
                    <i class="fa fa-sort-amount-asc" aria-hidden="true"></i>
                  </button>
                  <div class="dropdown-menu" aria-labelledby="dropd">
                    <a class="dropdown-item" href="#">Action</a>
                    <a class="dropdown-item" href="#">Another action</a>
                    <a class="dropdown-item" href="#">Something else here</a>
                  </div>
                </div>
              </div>

              <div
                class="col-md-6 col-sm-12 col-xm-12 text-right text-capitalize count_page"
              >
                12 topics, pages 1 of 1
              </div>
            </div>
            <!-- End Fiveth Row -->

            <!-- Start Sixth Row -->
            <div class="row mt-5">
              <div class="col-md-4 col-sm-12">
                <a href="../index.html" class="text-capitalize return">
                  <i class="fa fa-angle-left mr-1" aria-hidden="true"></i>
                  return to board index</a
                >
              </div>

              <div class="col-md-8 text-right col-sm-12">
                <div class="dropdown">
                  <button
                    class="btn btn-primary btn-round dropdown-toggle btn_sort text-capitalize"
                    type="button"
                    id="drop"
                    data-toggle="dropdown"
                    aria-haspopup="true"
                    aria-expanded="false"
                  >
                    Jumb to
                  </button>
                  <div class="dropdown-menu" aria-labelledby="dropd">
                    <a class="dropdown-item" href="../index.html">Board</a>
                    <a class="dropdown-item" href="./profile-page.html"
                      >Profile</a
                    >
                    <a class="dropdown-item" href="#">Something else here</a>
                  </div>
                </div>
              </div>
            </div>
          