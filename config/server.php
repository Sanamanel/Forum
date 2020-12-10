<?php  

  if (isset($_SERVER['REQUEST_METHOD']) == false) { //No request method is sent, do nothing
    return;
  }

  session_start();
  ini_set('display_errors', 1);
  ini_set('display_startup_errors', 1);
  error_reporting(E_ALL); 
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
     if (isset($_POST['content'])) { 
      
      $content= $_POST['content'];
   
      $decoded = json_decode($content, true);
      
      //call specific function, according to action-
      switch($decoded["action"]) 
      {
        case "login":
          login($decoded);
          break;
        case "register":
          register($decoded);
          break;  
        case "create_message":
            createMessage($decoded);
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

  function PutRequest()
  {
    global $errors;

    parse_str(file_get_contents('php://input'), $_PUT);
    if (isset($_PUT['content'])) { 

      $content= $_PUT['content'];
   
      $decoded = json_decode($content, true);
      
      //call specific function, according to action
      switch($decoded["action"]) 
      {
        case "updateProfile":
          updateProfile($decoded);
          break;     
      }
    }
  
  }




  function connectDb()
  {
    $dbhost = getenv('SQLSERVER');
    $dbuser = getenv('DBUSER');
    $dbpass = getenv('DBPASS');
    $dbdatabase = getenv('DBNAME');
    $db = mysqli_connect($dbhost, $dbuser, $dbpass, $dbdatabase);
    $db->set_charset('utf8mb4');
    $db->query("SET NAMES utf8mb4 COLLATE utf8mb4_unicode_ci");
    // if(! $db ) {
    //   writeResponse('Internal error. Please contact support.');
    // }

    return $db;
  }


  function login($input) {
    
    global $errors;
    $db = connectDb();
    //To prevent SQL injection
    
    $email =  mysqli_real_escape_string($db, $input['email']); 
    $password = mysqli_real_escape_string($db,$input['password']); 

    //Email & password must be checked in front AND in back.
    if (empty($email)) { array_push($errors, "Email is required"); } 
    if (empty($password)) { array_push($errors, "Password is required"); } 

    if (count($errors) == 0) { 

      $password = getHash($password); //get hash from password
      //Vous pouvez maintenant utiliser password_hash() pour créer un bcrypt hachage de n'importe quel mot de passe
      //tester   $password = password_hash($password);

      try {
       
        $query = "SELECT * FROM users WHERE email= '$email' and password_hash = '$password'"; 
        $results = mysqli_query($db, $query); 
       
        if (mysqli_num_rows($results) == 1) { //Login succeed
          
          $query = "UPDATE users SET last_login_date =  now() WHERE email = '$email'";  
          writeResponse($query);
          //Execute the query, that will insert a new user in table users
          if(!mysqli_query($db, $query)) //if a error occurs
          {
            header('HTTP/1.1 500');
            $error = mysql_error($db);
            array_push($errors, `An error occurs while logging : ` . $error);
          }
          else
          {
            $user=mysqli_fetch_array($results);

            // Storing username in session variable 
            $_SESSION['username'] = $user['nickname'];
            $_SESSION['id'] = $user['id']; 
            header("HTTP/1.1 200 OK");
            return;
          }

          
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
         
          $query = "INSERT INTO users (nickname, email, password_hash, last_login_date) VALUES('$username', '$email', '$password', now())";  
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
            $query = "SELECT nickname, id FROM users WHERE nickname = $username";
            $result = mysqli_query($db, $query);
            
            while ($row = $result->fetch_object()){
              if($row['nickname'] == $username){
                $_SESSION['id'] = $row['id'];
              }
            }
            
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

  

  function createMessage($input) {

    if (!isset($_SESSION['username'])) {  //user is not authenticated, return a 401
      header('HTTP/1.1 401');
      return;
    } 
    //$messageHTML =  emoji_entitizer($input['message']);
    global $errors;
    $db = connectDb();


     $message = mysqli_real_escape_string($db, trim($input['message'])); 
     $topicId = mysqli_real_escape_string($db, $input['topicId']); 
     $currentUserName = $_SESSION["username"];
    
     //Verify input
     if (empty($message)) { array_push($errors, "Message is required"); } 
     
     //If no validation error, create message
     if (count($errors) == 0) { 
        
       
         try {
         
          $query = "INSERT INTO messages (content,creation_date,message_by,message_topic) VALUES('$message', now(), (select id from users where nickname = '$currentUserName'),$topicId )";  
    
          //Execute the query, that will insert a new message in table messages
          if(!mysqli_query($db, $query)) //if a error occurs
          {
           
              header('HTTP/1.1 500');
              array_push($errors, 'An internal error occurs while message creation');
          } 
          else
          {
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
      $profileData = array("email"=> $user['email'], "firstname"=> $user['firstname'], "lastname"=> $user['lastname'],"username"=> $user['nickname'],"signature"=> $user['signature'], "birthdate"=> $user['birthdate'], "type"=> $user['image_type'], "image"=> base64_encode($user['image']), "country"=> $user['country']); //complete with birthdate and country
      header("HTTP/1.1 200 OK");
      writeResponse(json_encode($profileData));

    }
    else
    {
      header('HTTP/1.1 500');
      array_push($errors, `An internal error occurs while getting profile`);
    }

  }

  function updateProfile($input)
  {

    if (!isset($_SESSION['username'])) {  //user is not authenticated, return a 401
      header('HTTP/1.1 401');
      return;
    } 

    global $errors;
    $db = connectDb();
    $username = $_SESSION['username'];

    try {
         
      $firstname = mysqli_real_escape_string($db, $input['firstname']); 
      $lastname = mysqli_real_escape_string($db, $input['lastname']); 
      $birthdate = mysqli_real_escape_string($db, $input['birthdate']); 
      $country = mysqli_real_escape_string($db, $input['country']); 
      $signature = mysqli_real_escape_string($db, $input['signature']); 
      $password = mysqli_real_escape_string($db, $input['password']); 

      $query = "update users set firstname = '$firstname', lastname = '$lastname', country = '$country', signature = '$signature'";
    
      if (!empty($birthdate)) 
        $query .= ", birthdate = '$birthdate' ";
      else
        $query .= ", birthdate = null ";

      if (!empty($password)) { 
        $password = getHash($password);
        $query .= ", password_hash = '$password' ";
      }
      $query .= " where nickname = '$username'"; 
      writeResponse($query);
      if(!mysqli_query($db, $query)) //if a error occurs
      {
        $error = mysql_error($db);
        
        header('HTTP/1.1 500');
        array_push($errors, `An internal error occurs while updating profile` . $error );
        
      } 
      else
      {
        writeResponse("OK");
                header("HTTP/1.1 200 OK");
        return;
        
      }
    }
    catch(Exception $exception)
    {
      header('HTTP/1.1 500');
      array_push($errors, `An internal error occurs while updating profile : {$exception->getMessage()}`);
        
    }

  }

  //This method must be used to retrieve hash from a string. 
  //TODO  It's currently a MD5, but that not secure enough. Must be improved . (with salt)
  function getHash($toBeHashed)
  {
    return hash('sha512', $toBeHashed);
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
  
