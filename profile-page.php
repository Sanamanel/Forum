<?php
        session_start(); 
          
        // If the session variable is empty, this  
        // means the user is yet to login 
        // User will be sent to 'login.php' page 
        // to allow the user to login 
        if (!isset($_SESSION['username'])) { 
            header('location: https://led-zepplin-forum.herokuapp.com/'); 
            exit();
        } 
        include("header.php");
?>
    
         <div>
           <div class="container">
             <nav aria-label="breadcrumb" role="navigation">
               <ol class="breadcrumb">
                 <i class="fa fa-home mr-1 pt-1 home_icon" aria-hidden="true"></i>
                 <li class="breadcrumb-item"><a href="javascript:;">Home</a></li>
                 <li class="breadcrumb-item">
                   <a href="./home.php">Board index</a>
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
                         <div class="col-md-4 pr-1">
                           <div class="form-group">
                             <label>Email (disabled)</label>
                             <input id="email"
                               type="email"
                               class="form-control"
                               disabled=""
                               placeholder="Email"
                             />
                           </div>
                         </div>
                         <div class="col-md-4">
                           <div class="form-group">
                             <label>Firstname</label>
                             <input id="firstname"
                               type="text"
                               class="form-control"
                               placeholder="First name"
                             />
                           </div>
                         </div>
                         <div class="col-md-4">
                           <div class="form-group">
                             <label for="exampleInputEmail1">Last name</label>
                             <input id="lastname"
                               type="text"
                               class="form-control"
                               placeholder="Last name"
                             />
                           </div>
                         </div>
                       </div>
                       <div class="row">
                         <div class="col-md-4">
                           <div class="form-group">
                             <label>Nickname (disabled)</label>
                             <input id="username"
                               type="text"
                               class="form-control"
                               disabled=""
                               placeholder="Nickname"
                             />
                           </div>
                         </div>
                         <div class="col-md-4">
                           <div class="form-group">
                             <label>Birthdate</label>
                             <input id="birthdate"
                               type="date"
                               class="form-control"
                               placeholder="Birthdate"
                             />
                           </div>
                         </div>
                         <div class="col-md-4">
                          <div class="form-group">
                            <label>Country</label>
                            <input id="country"
                              type="text"
                              class="form-control"
                              placeholder="Country"
                            />
                          
                        </div>
                      </div>
                       </div>
                 
                       <div class="row">
                         <div class="col-md-6">
                           <div class="form-group">
                             <label>Change signature</label>
                             <textarea id="signature"
                              class="form-control" 
                              placeholder="Signature">
                            </textarea>
                           </div>
                         </div>
                         <div class="col-md-6">
                           <div class="form-group">
                             <label>Change password</label>
                             <input id="password"
                               type="password"
                               class="form-control"
                               placeholder="Password"
                             />
                           </div>
                         </div>
                       </div>
                       <input id="btn_save"
                        type="button"
                         class="btn btn-primary btn-fill pull-right"  value="Update Profile">
                         
                       </input>
                       <div class="clearfix"></div>
                     </form>
                   </div>
                 </div>
               </div>
               <!--	Profil Card with gravatard-->
               <div class="col-md-4">
                 <div class="card card-user">
                   <div class="card-image">
                     <img class="mt-5 rounded img-thumbnail mx-auto d-block border-primary" id="avatar"
                      scr=""
                       alt="Gravatar"
                     />
                   </div>
                   <div class="card-body">
                     <div class="author">
                       <h5 class="title text-primary text-center" id="fullname_display">
                      
                       </h5>
                       <p class="description text-center" id="username_display"></p>
                     </div>
                     <hr />
                     <p class="description text-center" id="signature_display">
                      
                     </p>
                   </div>
                 </div>
               </div>
             </div>
           </div>
         </div>

         </div>
         <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
         <script src="md5.js"></script>
         <script src="profile-page.js"></script>
         <?php include("footer.php"); ?>