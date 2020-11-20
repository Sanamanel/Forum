<!--
=========================================================
Material Kit - v2.0.7
=========================================================
Product Page: https://www.creative-tim.com/product/material-kit
Copyright 2020 Creative Tim (https://www.creative-tim.com/)
Coded by Creative Tim
=========================================================
The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software. -->
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <link
      rel="apple-touch-icon"
      sizes="76x76"
      href="../assets/img/apple-icon.png"
    />
    <link rel="icon" type="image/png" href="../assets/img/favicon.png" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <title>Comments</title>
    <meta
      content="width=device-width, initial-scale=1.0, shrink-to-fit=no"
      name="viewport"
    />
    <!--     Fonts and icons     -->
    <link
      rel="stylesheet"
      type="text/css"
      href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Roboto+Slab:400,700|Material+Icons"
    />
    <link
      rel="stylesheet"
      href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css"
    />

    <!-- CSS Files -->
    <link href="../assets/css/material-kit.css?v=2.0.7" rel="stylesheet" />
    <link href="../assets/css/comment.css" rel="stylesheet" />
  </head>

  <body class="landing-page sidebar-collapse">
    <nav
      class="navbar navbar-transparent navbar-color-on-scroll fixed-top navbar-expand-lg"
      color-on-scroll="100"
      id="sectionsNav"
    >
      <div class="container">
        <div class="navbar-translate">
          <button
            class="navbar-toggler"
            type="button"
            data-toggle="collapse"
            aria-expanded="false"
            aria-label="Toggle navigation"
          >
            <span class="sr-only">Toggle navigation</span>
            <span class="navbar-toggler-icon"></span>
            <span class="navbar-toggler-icon"></span>
            <span class="navbar-toggler-icon"></span>
          </button>
        </div>
        <div class="collapse navbar-collapse">
          <ul class="navbar-nav ml-auto">
            <li class="nav-item"></li>
            <li class="dropdown nav-item">
              <a
                href="#"
                class="dropdown-toggle nav-link"
                data-toggle="dropdown"
              >
                <i class="material-icons">apps</i> Menu
              </a>
              <div class="dropdown-menu dropdown-with-icons">
                <a href="../index.html" class="dropdown-item">
                  <i class="material-icons">dashboard</i> Board
                </a>
                <a href="profile-page.html" class="dropdown-item">
                  <i class="material-icons">account_box</i> Profile
                </a>
                <a href="#" class="dropdown-item">
                  <i class="material-icons">contact_support</i> Contact
                </a>
              </div>
            </li>

            <li class="nav-item">
              <a class="nav-link" href="#" target="_blank">
                <i class="material-icons">login</i> Log out
              </a>
            </li>
          </ul>
        </div>
      </div>
    </nav>
    <div
      class="page-header header-filter clear-filter purple-filter"
      data-parallax="true"
      style="background-image: url('../assets/img/bg3.jpg')"
    >
      <div class="container">
        <!-- <div class="row"> -->
        <!-- <div class="col-md-8 ml-auto mr-auto"> -->
        <div class="brand">
          <h1 class="text-center">Led Zeppelin</h1>
          <!-- </div> -->
          <!-- </div> -->
        </div>
      </div>
    </div>
    <div class="main main-raised">
      <div class="container">
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
            <li class="breadcrumb-item active" aria-current="page">
              Topics Read (Hot)
            </li>
          </ol>
        </nav>
      </div>
      <div class="container mt-3">
        <div class="row">
          <div class="col-lg-9">
            <h4 class="text-left">Topic Read (Hot)</h4>
            <div class="alert alertnew" role="alert">
              <a href="#" class="alert-link">Forum rules</a>
            </div>
            <div class="row">
              <div>
                <button type="button" class="btn btn-primary btn-round">
                  Post Reply<span class="material-icons">
                    undo
                    <div class="mx-3"></div>
                  </span>
                </button>
              </div>
              <button
                class="btn btn-secondary dropdown-toggle btn-round"
                type="button"
                id="dropdownMenuButton"
                data-toggle="dropdown"
                aria-haspopup="true"
                aria-expanded="false"
              >
                <span class="material-icons"> build </span>
              </button>
              <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                <a class="dropdown-item" href="#">Action</a>
                <a class="dropdown-item" href="#">Another action</a>
                <a class="dropdown-item" href="#">Something else here</a>
              </div>
              <!-- search -->
              <div>
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
            <div class="container padding-bottom-3x mb-2">
              <div class="row">
                <div>
                  <!-- Messages-->
                  <div class="comment">
                    <div class="comment-author-ava">
                      <img
                        src="https://bootdey.com/img/Content/avatar/avatar6.png"
                        alt="Avatar"
                      />
                    </div>
                    <div class="comment-body">
                      <p class="comment-text">
                        At vero eos et accusamus et iusto odio dignissimos
                        ducimus qui blanditiis praesentium voluptatum deleniti
                        atque corrupti quos dolores et quas molestias excepturi
                        sint occaecati cupiditate non provident, similique sunt
                        in culpa qui officia deserunt mollitia animi.
                      </p>
                      <div class="comment-footer">
                        <span class="comment-meta">Daniel Adams</span>
                      </div>
                    </div>
                  </div>
                  <div class="comment">
                    <div class="comment-author-ava">
                      <img
                        src="https://bootdey.com/img/Content/avatar/avatar2.png"
                        alt="Avatar"
                      />
                    </div>
                    <div class="comment-body">
                      <p class="comment-text">
                        Sed ut perspiciatis unde omnis iste natus error sit
                        voluptatem accusantium doloremque laudantium, totam rem
                        aperiam, eaque ipsa quae ab illo inventore veritatis et
                        quasi architecto beatae vitae dicta sunt explicabo. Nemo
                        enim ipsam voluptatem quia voluptas sit aspernatur aut
                        odit aut fugit, sed quia consequuntur magni dolores eos
                        qui ratione voluptatem sequi nesciunt.
                      </p>
                      <div class="comment-footer">
                        <span class="comment-meta">Jacob Hammond, Staff</span>
                      </div>
                    </div>
                  </div>
                  <div class="comment">
                    <div class="comment-author-ava">
                      <img
                        src="https://bootdey.com/img/Content/avatar/avatar3.png"
                        alt="Avatar"
                      />
                    </div>
                    <div class="comment-body">
                      <p class="comment-text">
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit,
                        sed do eiusmod tempor incididunt ut labore et dolore
                        magna aliqua. Ut enim ad minim veniam, quis nostrud
                        exercitation ullamco laboris nisi ut aliquip ex ea
                        commodo consequat.
                      </p>
                      <div class="comment-footer">
                        <span class="comment-meta">Jacob Hammond, Staff</span>
                      </div>
                    </div>
                  </div>
                  <!-- Reply Form-->
                  <h5 class="mb-30 padding-top-1x">Leave Message</h5>
                  <form method="post">
                    <div class="form-group">
                      <textarea
                        class="form-control form-control-rounded"
                        id="review_text"
                        rows="8"
                        placeholder="Write your message here..."
                        required=""
                      ></textarea>
                    </div>
                    <div class="text-right">
                      <button class="btn btn-outline-primary" type="submit">
                        Submit Message
                      </button>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
          <div class="col-lg-3 blog-aside">
            <!-- search -->
            <nav class="navbar navbar-expand-lg navbarbtn">
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
            </nav>
            <!-- Author -->
            <div class="widget widget-author">
              <div class="widget-title">
                <h3>Author</h3>
              </div>
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
                    <h6>
                      Hello, I'm<br />
                      Rachel Roth
                    </h6>
                  </div>
                </div>
                <p>
                  I design and develop services for customers of all sizes,
                  specializing in creating stylish, modern websites, web
                  services and online stores
                </p>
              </div>
            </div>
            <!-- End Author -->

            <!-- Latest Post -->
            <div class="widget widget-latest-post">
              <div class="widget-title">
                <h3>Latest Post</h3>
              </div>
              <div class="widget-body">
                <div class="latest-post-aside media">
                  <div class="lpa-left media-body">
                    <div class="lpa-title">
                      <h5>
                        <a href="#"
                          >Prevent 75% of visitors from google analytics</a
                        >
                      </h5>
                    </div>
                    <div class="lpa-meta">
                      <a class="name" href="#"> Rachel Roth </a>
                      <a class="date" href="#"> 26 FEB 2020 </a>
                    </div>
                  </div>
                  <div class="lpa-right">
                    <a href="#">
                      <img
                        src="https://via.placeholder.com/400x200/FFB6C1/000000"
                        title=""
                        alt=""
                      />
                    </a>
                  </div>
                </div>
                <div class="latest-post-aside media">
                  <div class="lpa-left media-body">
                    <div class="lpa-title">
                      <h5>
                        <a href="#"
                          >Prevent 75% of visitors from google analytics</a
                        >
                      </h5>
                    </div>
                    <div class="lpa-meta">
                      <a class="name" href="#"> Rachel Roth </a>
                      <a class="date" href="#"> 26 FEB 2020 </a>
                    </div>
                  </div>
                  <div class="lpa-right">
                    <a href="#">
                      <img
                        src="https://via.placeholder.com/400x200/FFB6C1/000000"
                        title=""
                        alt=""
                      />
                    </a>
                  </div>
                </div>
                <div class="latest-post-aside media">
                  <div class="lpa-left media-body">
                    <div class="lpa-title">
                      <h5>
                        <a href="#"
                          >Prevent 75% of visitors from google analytics</a
                        >
                      </h5>
                    </div>
                    <div class="lpa-meta">
                      <a class="name" href="#"> Rachel Roth </a>
                      <a class="date" href="#"> 26 FEB 2020 </a>
                    </div>
                  </div>
                  <div class="lpa-right">
                    <a href="#">
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
            <!-- End Latest Post -->
            <!-- Last users -->
            <div class="widget widget-post">
              <div class="widget-title">
                <h3>Last active user</h3>
              </div>
              <div class="widget-body"></div>
            </div>
            <!-- End Last users-->
          </div>

          <!-- fin test structure -->
        </div>
      </div>
    </div>
    <footer class="footer" data-background-color="black">
      <div class="container">
        <div class="contenair pt-5">
          <nav class="d-flex justify-content-around">
            <ul>
              <li class="px-3 mt-2">
                <i class="fa fa-2x fa-twitter"></i>
              </li>
              <li class="px-3 mt-2">
                <i class="fa fa-2x fa-facebook"></i>
              </li>

              <li class="px-3 mt-2">
                <i class="fa fa-2x fa-codepen"></i>
              </li>
              <li class="px-3 mt-2">
                <i class="fa fa-2x fa-google"></i>
              </li>
            </ul>
          </nav>
          <div class="copyright">
            <ul>
              <li>
                <a href="#"> Board </a>
              </li>
              <li>
                <a href="#"> About Us </a>
              </li>
              <li>
                <a href="#"> Contact </a>
              </li>
            </ul>
            Team Led Zeppelin &copy;
            <script>
              document.write(new Date().getFullYear());
            </script>
            , made with <i class="material-icons">favorite</i> by
            <a href="#" target="_blank">Ali, Caro, Cédric, Rachida </a>
          </div>
        </div>
      </div>
    </footer>
    <!--   Core JS Files   -->
    <script
      src="../assets/js/core/jquery.min.js"
      type="text/javascript"
    ></script>
    <script
      src="../assets/js/core/popper.min.js"
      type="text/javascript"
    ></script>
    <script
      src="../assets/js/core/bootstrap-material-design.min.js"
      type="text/javascript"
    ></script>
    <script src="../assets/js/plugins/moment.min.js"></script>
    <!--	Plugin for the Datepicker, full documentation here: https://github.com/Eonasdan/bootstrap-datetimepicker -->
    <script
      src="../assets/js/plugins/bootstrap-datetimepicker.js"
      type="text/javascript"
    ></script>
    <!--  Plugin for the Sliders, full documentation here: http://refreshless.com/nouislider/ -->
    <script
      src="../assets/js/plugins/nouislider.min.js"
      type="text/javascript"
    ></script>
    <!--  Google Maps Plugin    -->
    <!-- Control Center for Material Kit: parallax effects, scripts for the example pages etc -->
    <script
      src="../assets/js/material-kit.js?v=2.0.7"
      type="text/javascript"
    ></script>
  </body>
</html>