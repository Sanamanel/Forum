<!--
=========================================================
Material Kit - v2.0.7
=========================================================
Product Page: https://www.creative-tim.com/product/material-kit
Copyright 2020 Creative Tim (https://www.creative-tim.com/)
Coded by Creative Tim
=========================================================
The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software. -->
<?php session_start(); 
// If the session variable is empty, this  
        // means the user is yet to login 
        // User will be sent to 'login.php' page 
        // to allow the user to login 
        if (!isset($_SESSION['username'])) { 
            header('location: https://led-zepplin-forum.herokuapp.com/'); 
            exit();
        } 
ob_start();
require('connect.php'); 
     include("header.php"); ?>
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
                <button
                  type="button"
                  class="btn btn-primary btn-round reply-btn"
                >
                  Post Reply<span class="material-icons">
                    undo
                    <div class="mx-3"></div>
                  </span>
                </button>
              </div>
              <button
                class="btn btn-secondary dropdown-toggle btn-round size-btn"
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
                <nav class="navbar navbar-expand-lg navbarbtn1">
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
              </div>
            </div>
            <div class="container padding-bottom-3x mb-2">
              <div class="row">
                <div class="col-md-8 mx-auto">
                  <h2>Do you love this Forum</h2>
                  <h4>
                    Lorem ipsum dolor sit amet consectetur adipisicing elit. At
                    cumque, aspernatur tempora magni, harum iste, architecto
                    modi aliquam est doloribus ducimus eligendi voluptas nihil
                    doloremque atque corrupti nisi hic animi!
                  </h4>
                </div>
                <!-- comments -->
                <div class="container d-flex justify-content-center mb-100">
                  <div class="row">
                    <div class="col-md-12">
                      <div class="card">
                        <div class="card-body">
                          <h4 class="card-title">Recent Comments</h4>
                          <h6 class="card-subtitle">
                            Latest Comments section by users
                          </h6>
                        </div>
                        <div class="comment-widgets m-b-20">
                          <div class="d-flex flex-row comment-row">
                            <div class="p-2">
                              <span class="round"
                                ><img
                                  src="https://i.imgur.com/uIgDDDd.jpg"
                                  alt="user"
                                  width="50"
                              /></span>
                            </div>
                            <div class="comment-text w-100">
                              <h5>Samso Nagaro</h5>
                              <div class="comment-footer">
                                <span class="date">April 14, 2019</span>
                                <span class="label label-info">Pending</span>
                                <span class="action-icons">
                                  <a href="#" data-abc="true"
                                    ><i class="fa fa-pencil"></i
                                  ></a>
                                  <a href="#" data-abc="true"
                                    ><i class="fa fa-rotate-right"></i
                                  ></a>
                                  <a href="#" data-abc="true"
                                    ><i class="fa fa-heart"></i
                                  ></a>
                                </span>
                              </div>
                              <p class="m-b-5 m-t-10">
                                Lorem Ipsum is simply dummy text of the printing
                                and typesetting industry. Lorem Ipsum has been
                                the industry's standard dummy text ever since
                                the 1500s, when an unknown printer took a galley
                                of type and scrambled it
                              </p>
                            </div>
                          </div>
                          <div class="d-flex flex-row comment-row">
                            <div class="p-2">
                              <span class="round"
                                ><img
                                  src="https://i.imgur.com/tT8rjKC.jpg"
                                  alt="user"
                                  width="50"
                              /></span>
                            </div>
                            <div class="comment-text active w-100">
                              <h5>Jonty Andrews</h5>
                              <div class="comment-footer">
                                <span class="date">March 13, 2020</span>
                                <span class="label label-success"
                                  >Approved</span
                                >
                                <span class="action-icons active">
                                  <a href="#" data-abc="true"
                                    ><i class="fa fa-pencil"></i
                                  ></a>
                                  <a href="#" data-abc="true"
                                    ><i
                                      class="fa fa-rotate-right text-success"
                                    ></i
                                  ></a>
                                  <a href="#" data-abc="true"
                                    ><i class="fa fa-heart text-danger"></i
                                  ></a>
                                </span>
                              </div>
                              <p class="m-b-5 m-t-10">
                                Contrary to popular belief, Lorem Ipsum is not
                                simply random text. It has roots in a piece of
                                classical Latin literature from 45 BC, making it
                                over 2000 years old. Richard McClintock, a Latin
                                professor at Hampden-Sydney College in Virginia,
                                looked up one of the more obscure Latin words,
                                consectetur, from a Lorem Ipsum passage, and
                                going through the cites
                              </p>
                            </div>
                          </div>
                          <div class="d-flex flex-row comment-row">
                            <div class="p-2">
                              <span class="round"
                                ><img
                                  src="https://i.imgur.com/cAdLHeY.jpg"
                                  alt="user"
                                  width="50"
                              /></span>
                            </div>
                            <div class="comment-text w-100">
                              <h5>Sarah Tim</h5>
                              <div class="comment-footer">
                                <span class="date">Jan 20, 2020</span>
                                <span class="label label-danger">Rejected</span>
                                <span class="action-icons">
                                  <a href="#" data-abc="true"
                                    ><i class="fa fa-pencil"></i
                                  ></a>
                                  <a href="#" data-abc="true"
                                    ><i class="fa fa-rotate-right"></i
                                  ></a>
                                  <a href="#" data-abc="true"
                                    ><i class="fa fa-heart"></i
                                  ></a>
                                </span>
                              </div>
                              <p class="m-b-5 m-t-10">
                                There are many variations of passages of Lorem
                                Ipsum available, but the majority have suffered
                                alteration in some form, by injected humour, or
                                randomised words which don't look even slightly
                                believable. If you are going to use a passage of
                                Lorem Ipsum, you need to be sure
                              </p>
                            </div>
                          </div>
                          <div class="d-flex flex-row comment-row">
                            <div class="p-2">
                              <span class="round"
                                ><img
                                  src="https://i.imgur.com/uIgDDDd.jpg"
                                  alt="user"
                                  width="50"
                              /></span>
                            </div>
                            <div class="comment-text w-100">
                              <h5>Samso Nagaro</h5>
                              <div class="comment-footer">
                                <span class="date">March 20, 2020</span>
                                <span class="label label-info">Pending</span>
                                <span class="action-icons">
                                  <a href="#" data-abc="true"
                                    ><i class="fa fa-pencil"></i
                                  ></a>
                                  <a href="#" data-abc="true"
                                    ><i class="fa fa-rotate-right"></i
                                  ></a>
                                  <a href="#" data-abc="true"
                                    ><i class="fa fa-heart"></i
                                  ></a>
                                </span>
                              </div>
                              <p class="m-b-5 m-t-10">
                                It uses a dictionary of over 200 Latin words,
                                combined with a handful of model sentence
                                structures, to generate Lorem Ipsum which looks
                                reasonable. The generated Lorem Ipsum is
                                therefore always free from repetition, injected
                                humour, or non-characteristic words etc.
                              </p>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <!-- message -->
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
          <?php include("aside.php"); ?>
         
          <!-- fin test structure -->
        </div>
      </div>
      <?php include("footer.php"); ?>