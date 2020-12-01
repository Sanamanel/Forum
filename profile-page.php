<?php
        session_start(); 
       // ini_set('display_errors', 1);
       // ini_set('display_startup_errors', 1);
       // error_reporting(E_ALL); 
          
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
                   <a href="./profile-page.php">Profile page</a>
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
                         class="btn btn-primary btn-round btn-fill pull-right"  value="Update Profile">
                         
                       </input>
                       <div class="clearfix"></div>
                     </form>
                   </div>
                 </div>
               </div>
               <!--	Profil Card with gravatard-->
               <div class="col-md-4">
               <?php


$name= $_FILES['file']['name'];

$tmp_name= $_FILES['file']['tmp_name'];

$position= strpos($name, ".");

$fileextension= substr($name, $position + 1);

$fileextension= strtolower($fileextension);


if (isset($name)) {

$path= 'Uploads/images/';
if (empty($name))
{
echo '<div class="alert alert-warning rounded rounded-lg" role="alert">Please choose a file</div>';
}
else if (!empty($name)){
if (($fileextension !== "jpg") && ($fileextension !== "jpeg") && ($fileextension !== "png") && ($fileextension !== "bmp"))
{
echo '<div class="alert alert-warning rounded rounded-lg" role="alert">The file extension must be .jpg, .jpeg, .png, or .bmp in order to be uploaded</div>';
}


else if (($fileextension == "jpg") || ($fileextension == "jpeg") || ($fileextension == "png") || ($fileextension == "bmp"))
{
if (move_uploaded_file($tmp_name, $path.$name)) {
echo '<div class="alert alert-success rounded rounded-lg" role="alert">Uploaded!</div>';
}
}
}
}

?>
                 <div class="card card-user">
                   <div class="card-image">
                     <img class="mt-5 rounded img-thumbnail mx-auto d-block border-primary" id="avatar"
                      scr=""
                       alt="Gravatar"
                     /><br>
                      <form action="#upload" method='post' enctype="multipart/form-data">
                        <div class="custom_file btn btn-round btn-outline-primary btn-sm">New avatar
                          <input type="file" class="custom_file input_file" name="file"/>
                        </div>
                            <input type="submit" class="btn btn-round btn-outline-primary btn-sm" value="Upload"/>
                      </form>
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
                     <?php

if (($fileextension == "jpg") || ($fileextension == "jpeg") || ($fileextension == "png") || ($fileextension == "bmp")) {
echo "The image you uploaded is shown below<br><br>";
echo "<img src='$path" . "$name'>";
echo "<br><br>";

}

?>
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