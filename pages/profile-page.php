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
    <title>Profile</title>
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
    <link href="../assets/css/style.css" rel="stylesheet" />
  </head>
  <body class="index-page sidebar-collapse">
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
        <div class="row">
          <div class="col-md-8 ml-auto mr-auto">
            <div class="brand">
              <h1>Led Zeppelin</h1>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="main main-raised">
      <div>
        <div class="container">
          <nav aria-label="breadcrumb" role="navigation">
            <ol class="breadcrumb">
              <i class="fa fa-home mr-1 pt-1 home_icon" aria-hidden="true"></i>
              <li class="breadcrumb-item"><a href="javascript:;">Home</a></li>
              <li class="breadcrumb-item">
                <a href="../index.html">Board index</a>
              </li>
              <li class="breadcrumb-item">
                <a href="./profile-page.html">Profile page</a>
              </li>
            </ol>
          </nav>
        </div>
      </div>

      <div class="content">
        <div class="container">
          <div class="row">
            <div class="col-md-8 main-content">
              <h2 class="text-muted font-weight-bold">Profile page</h2>
              <div class="card">
                <div class="card-body">
                  <form>
                    <div class="row">
                      <div class="col-md-5 pr-1">
                        <div class="form-group">
                          <label>Email(disabled)</label>
                          <input
                            type="email"
                            class="form-control"
                            disabled=""
                            placeholder="Email"
                            value="user@gmail.com"
                          />
                        </div>
                      </div>
                      <div class="col-md-3">
                        <div class="form-group">
                          <label>Nickname</label>
                          <input
                            type="text"
                            class="form-control"
                            placeholder="Nickname"
                            value="Spooknick"
                          />
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <label for="exampleInputEmail1">Email address</label>
                          <input
                            type="email"
                            class="form-control"
                            placeholder="Email"
                          />
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group">
                          <label>First Name</label>
                          <input
                            type="text"
                            class="form-control"
                            placeholder="First Name"
                            value="Caroline"
                          />
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label>Last Name</label>
                          <input
                            type="text"
                            class="form-control"
                            placeholder="Last Name"
                            value="Jansen"
                          />
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group">
                          <label>Signature</label>
                          <input
                            type="text"
                            class="form-control"
                            placeholder="Signature"
                            value="Text"
                          />
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label>Password</label>
                          <input
                            type="password"
                            class="form-control"
                            placeholder="Password"
                            value="B12*rjki"
                          />
                        </div>
                      </div>
                    </div>
                    <button
                      type="submit"
                      class="btn btn-primary btn-fill pull-right"
                    >
                      Update Profile
                    </button>
                    <div class="clearfix"></div>
                  </form>
                </div>
              </div>
            </div>
            <!--	Profil Card with gravatard-->
            <div class="col-md-4">
              <div class="card card-user">
                <div class="card-image">
                  <img
                    src="https://ununsplash.imgix.net/photo-1431578500526-4d9613015464?fit=crop&fm=jpg&h=300&q=75&w=400"
                    alt="..."
                  />
                </div>
                <div class="card-body">
                  <div class="author">
                    <h5 class="title text-primary text-center">
                      Caroline Jansen
                    </h5>
                    <p class="description text-center">Spooknick</p>
                  </div>
                  <hr />
                  <p class="description text-center">
                    Don't worry, be happy :3
                    <br />
                    Video games <i class="material-icons">favorite</i>
                  </p>
                </div>
              </div>
            </div>
          </div>
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
