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
         <?php include("footer.php"); ?>