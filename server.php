<?php  

  if (isset($_SERVER['REQUEST_METHOD']) == false) { //No request method is sent, do nothing
    return;
  }

  session_start(); 
  $errors = array();  
  switch ($_SERVER['REQUEST_METHOD']) { //switch on request method
    case 'POST':
      PostRequest();
      break;
    case 'GET' :
      GetRequest();
      break;
      case 'PUT' :
        PutRequest();
      break;
    default:
      break;
  }

  function PostRequest()
  {
    global $errors;
    if (isset($_POST['content'])) { 
      
      $content= $_POST['content'];
   
      $decoded = json_decode($content, true);
      
      //call specific function, according to action
      switch($decoded["action"]) 
      {
        case "login":
          login($decoded);
          break;
        case "register":
          register($decoded);
          break;            
      }
    }
  
  }

  function GetRequest()
  {
    global $errors;
    if (isset($_GET['action'])) { 
      
      $action= $_GET['action'];
      
      //call specific function, according to action
      switch($action) 
      {
        case "profile":
          getProfile();
          break;
         
      }
    }
  }




  function connectDb()
  {
    $dbhost = 'remotemysql.com:3306';
    $dbuser = 'Q2qsa8HqT2';
    $dbpass = 'vkN1eNSWhe';
    $dbdatabase = 'Q2qsa8HqT2';
    $db = mysqli_connect($dbhost, $dbuser, $dbpass, $dbdatabase);
    // if(! $db ) {
    //   writeResponse('Internal error. Please contact support.');
    // }

    return $db;
  }


  function login($input) {
    
    global $errors;
    $db = connectDb();
    //To prevent SQL injection
    
    $username =  mysqli_real_escape_string($db, $input['username']); 
    $password = mysqli_real_escape_string($db,$input['password']); 

    //Username & password must be checked in front AND in back.
    if (empty($username)) { array_push($errors, "Username is required"); } 
    if (empty($password)) { array_push($errors, "Password is required"); } 

    if (count($errors) == 0) { 

      $password = getHash($password); //get hash from password
      //Vous pouvez maintenant utiliser password_hash() pour créer un bcrypt hachage de n'importe quel mot de passe
      //tester   $password = password_hash($password);

      try {
       
        $query = "SELECT * FROM users WHERE nickname = '$username' and password_hash = '$password'"; 
        $results = mysqli_query($db, $query); 

        if (mysqli_num_rows($results) == 1) { //Login succeed
                
          // Storing username in session variable 
          $_SESSION['username'] = $username; 
          header("HTTP/1.1 200 OK");
          return;
        } 
        else { 
              
            // If the username and password doesn't match 
            header("HTTP/1.1 400 Bad Request"); 
            array_push($errors, "Username or password incorrect");  
        } 

      }
      catch(Exception $exception)
      {
        header('HTTP/1.1 500');
        array_push($errors, `An error occurs while logging : {$exception->getMessage()}`);
      }
     
    }
    else
       header("HTTP/1.1 400 Bad Request"); 

    writeErrors($errors);
  }


  function register($input) {
    global $errors;
    $db = connectDb();

     $username = mysqli_real_escape_string($db, $input['username']); 
     $password = mysqli_real_escape_string($db, $input['password']); 
     $passwordConfirmation = mysqli_real_escape_string($db, $input['passwordConfirmation']); 
     $email = mysqli_real_escape_string($db, $input['email']); 
    
     //Verify input
     if (empty($username)) { array_push($errors, "Username is required"); } 
     if (empty($password)) { array_push($errors, "Password is required"); } 
     if (empty($email)) { array_push($errors, "Email is required"); } 
    
     //Checking if passwords match
     if ($password != $passwordConfirmation) { 
         array_push($errors, "The two passwords do not match"); 
     } 
     
     //If no validation error, register the user
     if (count($errors) == 0) { 
         $password = getHash($password); 
          
         try {
         
          $query = "INSERT INTO users (nickname, email, password_hash) VALUES('$username', '$email', '$password')";  
          //Execute the query, that will insert a new user in table users
          if(!mysqli_query($db, $query)) //if a error occurs
          {
            if(mysqli_errno($db) == 1062)  //Returns this specific error can be a security breach. Can be removed if needed
            {
              header('HTTP/1.1 409 Conflict');
              array_push($errors, "An account already exists with this username or email");
            }
            else
            {
              header('HTTP/1.1 500');
              array_push($errors, 'An internal error occurs while registration');
              //If you want to retrieve specific error, (can be dangerous)
              //array_push($errors, 'An error occurs while register : ' + mysqli_error($db));
            }
            
          } 
          else
          {
            $_SESSION['username'] = $username; //Fill username session variable to specify that the user in connected and give its username
            header("HTTP/1.1 200 OK");
            return;
            
          }
        }
        catch(Exception $exception)
        {
          header('HTTP/1.1 500');
          array_push($errors, `An internal error occurs while registration : {$exception->getMessage()}`);
            
        }
     } 
     else
      header("HTTP/1.1 400 Bad Request"); 
     writeErrors($errors);
  }

  function getProfile()
  {
    if (!isset($_SESSION['username'])) {  //user is not authenticated, return a 401
      header('HTTP/1.1 401');
      return;
    } 

    $db = connectDb();
    $username = $_SESSION['username'];

    $query = "SELECT * FROM users WHERE nickname = '$username'"; 
    $results = mysqli_query($db, $query); 
    if (mysqli_num_rows($results) == 1) { //user has been found in database
      $user=mysqli_fetch_array($results);
      $profileData = array("email"=> $user['email'], "firstname"=> $user['firstname'], "lastname"=> $user['lastname'],"username"=> $user['nickname'],"signature"=> $user['signature']); //complete with birthdate and country
      header("HTTP/1.1 200 OK");
      writeResponse(json_encode($profileData));

    }
    else
    {
      header('HTTP/1.1 500');
      array_push($errors, `An internal error occurs while getting profile`);
    }

  }

  //This method must be used to retrieve hash from a string. 
  //TODO  It's currently a MD5, but that not secure enough. Must be improved . (with salt)
  function getHash($toBeHashed)
  {
      return md5($toBeHashed);
  }

  function writeResponse( $content ){
    echo  $content ;
  }

  function writeErrors( $errors ){
    if($errors == null ) return;

    $errorMessage = "";
    for($i = 0; $i < count($errors); ++$i) {
      if($i > 0) 
      {
        $errorMessage .= "</br>";
      }   
      $errorMessage .= $errors[$i];
    }
    writeResponse($errorMessage);
  }

  ?> 
  