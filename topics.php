<!--
=========================================================
Material Kit - v2.0.7
=========================================================
Product Page: https://www.creative-tim.com/product/material-kit
Copyright 2020 Creative Tim (https://www.creative-tim.com/)
Coded by Creative Tim
=========================================================
The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software. -->
<?php require('server.php'); ?>  
<?php include("header.php"); ?>

      <div class="container-fluid">
        <div class="section text-center">
          <nav aria-label="breadcrumb" role="navigation">
            <ol class="breadcrumb">
              <i class="fa fa-home mr-1 pt-1 home_icon" aria-hidden="true"></i>
              <li class="breadcrumb-item"><a href="javascript:;">Home</a></li>
              <li class="breadcrumb-item">
                <a href="javascript:;">Board index</a>
              </li>
              <li class="breadcrumb-item">
                <a href="javascript:;">Category One</a>
              </li>
              <li class="breadcrumb-item" aria-current="page">
                <a href="javascript:;">Topics icon Demo </a>
              </li>
            </ol>
          </nav>
        </div>

        <!-- Start New Topic, Box Search -->
        <div class="row">
          <div class="col-md-9">
            <h4 class="topic_title mb-3">topic icon demo</h4>
            <div class="alert alert-danger my_alert mb-4" role="alert">
              forum rules
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
                          class="fa fa-check frst_i green"
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
            <!-- End Sixth Row -->
          </div>
          <!-- Start Side Bar-->
          <div class="col-md-3">
            <hr class="hr_first" />
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
            <div class="card">
              <div class="card-header last_post text-capitalize">Author</div>

              <div class="widget-body">
                <div class="media align-items-center">
                  <div class="avatar">
                    <img
                      src="https://bootdey.com/img/Content/avatar/avatar6.png"
                      title=""
                      alt=""
                    />
                  </div>
                  <div class="media-body">
                    <h6 class="px-4">
                      Hello, I'm<br />
                      Rachel Roth
                    </h6>
                  </div>
                </div>
                <p class="card_pra px-2">
                  I design and develop services for customers of all sizes,
                  specializing in creating stylish, modern websites, web
                  services and online stores
                </p>
              </div>
            </div>

            <!-- End Author -->

            <div class="line"></div>

            <div class="card">
              <div class="card-header last_post text-capitalize">last post</div>
              <ul class="list-group list-group-flush">
                <li class="list-group-item">
                  <div class="box_post">
                    <h4 class="cat text-capitalize">post-categori3</h4>
                    <h4 class="hour">2 hours</h4>
                    <div class="clear_both"></div>
                    <p class="card_pra">
                      Lorem ipsum dolor sit, amet consectetur adipisicing elit
                    </p>
                    <span class="tags"
                      >tags: test <span>workeot repot</span>
                    </span>
                  </div>
                </li>
                <li class="list-group-item">
                  <div class="box_post">
                    <h4 class="cat text-capitalize">post-categori3</h4>
                    <h4 class="hour">2 hours</h4>
                    <div class="clear_both"></div>
                    <p class="card_pra">
                      Lorem ipsum dolor sit, amet consectetur adipisicing elit
                    </p>
                    <span class="tags"
                      >tags: test <span>workeot repot</span>
                    </span>
                  </div>
                </li>
                <li class="list-group-item">
                  <div class="box_post">
                    <h4 class="cat text-capitalize">post-categori3</h4>
                    <h4 class="hour">2 hours</h4>
                    <div class="clear_both"></div>
                    <p class="card_pra">
                      Lorem ipsum dolor sit, amet consectetur adipisicing elit
                    </p>
                    <span class="tags"
                      >tags: test <span>workeot repot</span>
                    </span>
                  </div>
                </li>
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
          </div>
          <!-- End Side Bar-->
        </div>
      </div>
      <?php include("footer.php"); ?>