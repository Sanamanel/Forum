<?php
session_start(); 
// If the session variable is empty, this  
        // means the user is yet to login 
        // User will be sent to 'login.php' page 
        // to allow the user to login 
        if(!isset($_SESSION['username'])){ 
            header('location: https://led-zepplin-forum.herokuapp.com/'); 
            exit();
        }
		ob_start();
		include ('config/include.php');


	include ("header.php");
?>

			
			

<div class="container-fluid">
  <div class="section ">
				
				<center>
				<form action="search_result.php?search=" method="GET" name="">
					<table>
						<tr>
							<td> <input
                    type="search" name="k" 
                    autocomplete="off"
                      class="form-control"
                      placeholder="Search..."
                    /></td>
							<td> <button type="submit" name="" value="Search" class="btn btn-link text-primary" ><i class="fa fa-search"></i></button></td>
						</tr>
					</table>
				</form>
				
				</center>


				


				<table class="table table-bordered mt-5">
              <thead class="table-bg">
                <tr class="text-white">
                  <th class="text-capitalize"> Results of search</th>
                  
                 
                 
                </tr>
              </thead>
              <tbody>
              <tbody>





				<?php

					// CHECK TO SEE IF THE KEYWORDS WERE PROVIDED
					if (isset($_GET['k']) && $_GET['k'] != ''){
						
						// save the keywords from the url
						$k = trim($_GET['k']);

						// create a base query and words string
						$query_string = "SELECT * FROM topics WHERE ";
						$display_words = "";

						// seperate each of the keywords
						$content = explode(' ', $k); 
						foreach($content as $word){
							$query_string .= " content LIKE '%".$word."%' OR ";
							$display_words .= $word." ";
						}
						$query_string = substr($query_string, 0, strlen($query_string) - 3);

						// connect to the database
						$conn = mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);

						$query = mysqli_query($conn, $query_string);
						$result_count = mysqli_num_rows($query);

						// check to see if any results were returned
						if ($result_count > 0){
							
							 // display search result count to user
    echo '<center><h3>Your search for <b class="text-primary">'.$display_words.'</b></h3>';
    echo '<h3><b class="text-primary">'.$result_count.'</b> results found</h3></center><hr />';

							echo '<table class="search table table-bordered mt-5">';

							// display all the search results to the user
							while ($row = mysqli_fetch_assoc($query)){
								
								echo '<tr>
								<td class=" ">
            <div class="row">
              
            </div>
			<div class="col-10">
			<a class="text-dark" href="http://localhost:8888/Forum-local-last-version/topic.php?topic_id='.$row['id'].'"><h5 class="global"> '.$row['title'].'</h5></a>
			<span class="name text-capitalize text-rose"
			>'.$row['creation_date'].'</span>
			<p>  '.$row['content'].'</p>
		</div>
		</div>
		</td>

		
		
		
		  <div class="text_cell">
			
			<p></p>
		  </div>
		</>
	  </tr> '
								;
							}

							echo '</table>';
						}
						else
							echo ' <div class="alert alert-warning">
							<div class="container">
							  <div class="alert-icon">
							  <i class="material-icons">warning</i>
							  </div> <button type="button" class="close" data-dismiss="alert" aria-label="Close">
							  <span aria-hidden="true"><i class="material-icons">clear</i></span>
							</button><b>warning alert:</b> No results found. Please search something else.</div>
							</div> </table>';
					}
					else
						echo '</table>';
				?>
  <div class="row mt-5">
              <div class="col-md-4 col-sm-12">
                <a href="./index.php" class="text-capitalize return">
                  <i class="fa fa-angle-left mr-1" aria-hidden="true"></i>
                  return to board index</a
                >
              </div>
			  </div>
			  
			</div> 
			
			</div> 
			<?php include("footer.php"); ?>