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
    $dbhost = 'remotemysql.com:3306';
    $dbuser = 'Q2qsa8HqT2';
    $dbpass = 'vkN1eNSWhe';
    $dbdatabase = 'Q2qsa8HqT2';
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

  /*function emoji_entitizer($str) {
    $emoji_pattern = "/\\x{1F469}\\x{200D}\\x{2764}\\x{FE0F}\\x{200D}\\x{1F48B}\\x{200D}\\x{1F469}|\\x{1F469}\\x{200D}\\x{2764}\\x{FE0F}\\x{200D}\\x{1F48B}\\x{200D}\\x{1F468}|\\x{1F468}\\x{200D}\\x{2764}\\x{FE0F}\\x{200D}\\x{1F48B}\\x{200D}\\x{1F468}|\\x{1F469}\\x{200D}\\x{1F469}\\x{200D}\\x{1F466}\\x{200D}\\x{1F466}|\\x{1F468}\\x{200D}\\x{1F468}\\x{200D}\\x{1F467}\\x{200D}\\x{1F466}|\\x{1F469}\\x{200D}\\x{1F469}\\x{200D}\\x{1F467}\\x{200D}\\x{1F467}|\\x{1F469}\\x{200D}\\x{1F469}\\x{200D}\\x{1F467}\\x{200D}\\x{1F466}|\\x{1F468}\\x{200D}\\x{1F469}\\x{200D}\\x{1F467}\\x{200D}\\x{1F467}|\\x{1F468}\\x{200D}\\x{1F469}\\x{200D}\\x{1F467}\\x{200D}\\x{1F466}|\\x{1F468}\\x{200D}\\x{1F469}\\x{200D}\\x{1F466}\\x{200D}\\x{1F466}|\\x{1F468}\\x{200D}\\x{1F468}\\x{200D}\\x{1F467}\\x{200D}\\x{1F467}|\\x{1F468}\\x{200D}\\x{1F468}\\x{200D}\\x{1F466}\\x{200D}\\x{1F466}|\\x{1F3CC}\\x{FE0F}\\x{200D}\\x{2640}\\x{FE0F}\\x{1F3FB}|\\x{1F3CB}\\x{FE0F}\\x{200D}\\x{2640}\\x{FE0F}\\x{1F3FF}|\\x{1F575}\\x{FE0F}\\x{200D}\\x{2642}\\x{FE0F}\\x{1F3FD}|\\x{1F575}\\x{FE0F}\\x{200D}\\x{2642}\\x{FE0F}\\x{1F3FC}|\\x{1F575}\\x{FE0F}\\x{200D}\\x{2642}\\x{FE0F}\\x{1F3FB}|\\x{1F575}\\x{FE0F}\\x{200D}\\x{2640}\\x{FE0F}\\x{1F3FF}|\\x{1F575}\\x{FE0F}\\x{200D}\\x{2640}\\x{FE0F}\\x{1F3FE}|\\x{1F575}\\x{FE0F}\\x{200D}\\x{2640}\\x{FE0F}\\x{1F3FD}|\\x{1F575}\\x{FE0F}\\x{200D}\\x{2640}\\x{FE0F}\\x{1F3FC}|\\x{1F575}\\x{FE0F}\\x{200D}\\x{2640}\\x{FE0F}\\x{1F3FB}|\\x{1F3CB}\\x{FE0F}\\x{200D}\\x{2640}\\x{FE0F}\\x{1F3FB}|\\x{1F3CB}\\x{FE0F}\\x{200D}\\x{2640}\\x{FE0F}\\x{1F3FC}|\\x{1F469}\\x{200D}\\x{2764}\\x{FE0F}\\x{200D}\\x{1F469}|\\x{1F469}\\x{200D}\\x{2764}\\x{FE0F}\\x{200D}\\x{1F468}|\\x{1F3CB}\\x{FE0F}\\x{200D}\\x{2640}\\x{FE0F}\\x{1F3FD}|\\x{1F3CB}\\x{FE0F}\\x{200D}\\x{2640}\\x{FE0F}\\x{1F3FE}|\\x{1F468}\\x{200D}\\x{2764}\\x{FE0F}\\x{200D}\\x{1F468}|\\x{1F3CC}\\x{FE0F}\\x{200D}\\x{2640}\\x{FE0F}\\x{1F3FC}|\\x{1F3CB}\\x{FE0F}\\x{200D}\\x{2642}\\x{FE0F}\\x{1F3FB}|\\x{1F3CB}\\x{FE0F}\\x{200D}\\x{2642}\\x{FE0F}\\x{1F3FC}|\\x{1F3CB}\\x{FE0F}\\x{200D}\\x{2642}\\x{FE0F}\\x{1F3FD}|\\x{1F3CB}\\x{FE0F}\\x{200D}\\x{2642}\\x{FE0F}\\x{1F3FE}|\\x{1F3CB}\\x{FE0F}\\x{200D}\\x{2642}\\x{FE0F}\\x{1F3FF}|\\x{1F575}\\x{FE0F}\\x{200D}\\x{2642}\\x{FE0F}\\x{1F3FF}|\\x{1F3CC}\\x{FE0F}\\x{200D}\\x{2642}\\x{FE0F}\\x{1F3FF}|\\x{1F3CC}\\x{FE0F}\\x{200D}\\x{2642}\\x{FE0F}\\x{1F3FE}|\\x{1F3CC}\\x{FE0F}\\x{200D}\\x{2642}\\x{FE0F}\\x{1F3FD}|\\x{1F3CC}\\x{FE0F}\\x{200D}\\x{2642}\\x{FE0F}\\x{1F3FC}|\\x{1F3CC}\\x{FE0F}\\x{200D}\\x{2642}\\x{FE0F}\\x{1F3FB}|\\x{1F3CC}\\x{FE0F}\\x{200D}\\x{2640}\\x{FE0F}\\x{1F3FF}|\\x{1F3CC}\\x{FE0F}\\x{200D}\\x{2640}\\x{FE0F}\\x{1F3FE}|\\x{1F3CC}\\x{FE0F}\\x{200D}\\x{2640}\\x{FE0F}\\x{1F3FD}|\\x{1F575}\\x{FE0F}\\x{200D}\\x{2642}\\x{FE0F}\\x{1F3FE}|\\x{26F9}\\x{FE0F}\\x{200D}\\x{2642}\\x{FE0F}\\x{1F3FF}|\\x{26F9}\\x{FE0F}\\x{200D}\\x{2640}\\x{FE0F}\\x{1F3FF}|\\x{26F9}\\x{FE0F}\\x{200D}\\x{2640}\\x{FE0F}\\x{1F3FE}|\\x{26F9}\\x{FE0F}\\x{200D}\\x{2642}\\x{FE0F}\\x{1F3FE}|\\x{26F9}\\x{FE0F}\\x{200D}\\x{2642}\\x{FE0F}\\x{1F3FB}|\\x{26F9}\\x{FE0F}\\x{200D}\\x{2640}\\x{FE0F}\\x{1F3FD}|\\x{26F9}\\x{FE0F}\\x{200D}\\x{2642}\\x{FE0F}\\x{1F3FC}|\\x{26F9}\\x{FE0F}\\x{200D}\\x{2640}\\x{FE0F}\\x{1F3FC}|\\x{26F9}\\x{FE0F}\\x{200D}\\x{2642}\\x{FE0F}\\x{1F3FD}|\\x{26F9}\\x{FE0F}\\x{200D}\\x{2640}\\x{FE0F}\\x{1F3FB}|\\x{1F468}\\x{200D}\\x{1F469}\\x{200D}\\x{1F466}|\\x{1F468}\\x{200D}\\x{1F469}\\x{200D}\\x{1F467}|\\x{1F468}\\x{200D}\\x{1F467}\\x{200D}\\x{1F466}|\\x{1F468}\\x{200D}\\x{1F468}\\x{200D}\\x{1F466}|\\x{1F468}\\x{200D}\\x{1F468}\\x{200D}\\x{1F467}|\\x{1F469}\\x{200D}\\x{1F469}\\x{200D}\\x{1F467}|\\x{1F469}\\x{200D}\\x{1F469}\\x{200D}\\x{1F466}|\\x{1F469}\\x{200D}\\x{1F467}\\x{200D}\\x{1F467}|\\x{1F469}\\x{200D}\\x{1F467}\\x{200D}\\x{1F466}|\\x{1F469}\\x{200D}\\x{1F466}\\x{200D}\\x{1F466}|\\x{1F468}\\x{200D}\\x{1F467}\\x{200D}\\x{1F467}|\\x{1F468}\\x{200D}\\x{1F466}\\x{200D}\\x{1F466}|\\x{1F645}\\x{200D}\\x{2642}\\x{FE0F}\\x{1F3FE}|\\x{1F645}\\x{200D}\\x{2642}\\x{FE0F}\\x{1F3FF}|\\x{1F646}\\x{200D}\\x{2640}\\x{FE0F}\\x{1F3FB}|\\x{1F646}\\x{200D}\\x{2640}\\x{FE0F}\\x{1F3FC}|\\x{1F468}\\x{200D}\\x{2695}\\x{FE0F}\\x{1F3FB}|\\x{1F646}\\x{200D}\\x{2640}\\x{FE0F}\\x{1F3FD}|\\x{1F646}\\x{200D}\\x{2640}\\x{FE0F}\\x{1F3FE}|\\x{1F646}\\x{200D}\\x{2640}\\x{FE0F}\\x{1F3FF}|\\x{1F645}\\x{200D}\\x{2642}\\x{FE0F}\\x{1F3FD}|\\x{1F646}\\x{200D}\\x{2642}\\x{FE0F}\\x{1F3FC}|\\x{1F646}\\x{200D}\\x{2642}\\x{FE0F}\\x{1F3FD}|\\x{1F646}\\x{200D}\\x{2642}\\x{FE0F}\\x{1F3FE}|\\x{1F646}\\x{200D}\\x{2642}\\x{FE0F}\\x{1F3FF}|\\x{1F647}\\x{200D}\\x{2640}\\x{FE0F}\\x{1F3FB}|\\x{1F646}\\x{200D}\\x{2642}\\x{FE0F}\\x{1F3FB}|\\x{1F645}\\x{200D}\\x{2640}\\x{FE0F}\\x{1F3FD}|\\x{1F645}\\x{200D}\\x{2642}\\x{FE0F}\\x{1F3FC}|\\x{1F93E}\\x{200D}\\x{2640}\\x{FE0F}\\x{1F3FD}|\\x{1F487}\\x{200D}\\x{2640}\\x{FE0F}\\x{1F3FC}|\\x{1F487}\\x{200D}\\x{2640}\\x{FE0F}\\x{1F3FD}|\\x{1F487}\\x{200D}\\x{2640}\\x{FE0F}\\x{1F3FE}|\\x{1F487}\\x{200D}\\x{2640}\\x{FE0F}\\x{1F3FF}|\\x{1F487}\\x{200D}\\x{2642}\\x{FE0F}\\x{1F3FB}|\\x{1F487}\\x{200D}\\x{2642}\\x{FE0F}\\x{1F3FC}|\\x{1F487}\\x{200D}\\x{2642}\\x{FE0F}\\x{1F3FD}|\\x{1F487}\\x{200D}\\x{2642}\\x{FE0F}\\x{1F3FE}|\\x{1F487}\\x{200D}\\x{2642}\\x{FE0F}\\x{1F3FF}|\\x{1F93E}\\x{200D}\\x{2640}\\x{FE0F}\\x{1F3FE}|\\x{1F93E}\\x{200D}\\x{2640}\\x{FE0F}\\x{1F3FC}|\\x{1F645}\\x{200D}\\x{2642}\\x{FE0F}\\x{1F3FB}|\\x{1F93E}\\x{200D}\\x{2640}\\x{FE0F}\\x{1F3FB}|\\x{1F93D}\\x{200D}\\x{2642}\\x{FE0F}\\x{1F3FF}|\\x{1F93D}\\x{200D}\\x{2642}\\x{FE0F}\\x{1F3FE}|\\x{1F93D}\\x{200D}\\x{2642}\\x{FE0F}\\x{1F3FD}|\\x{1F93D}\\x{200D}\\x{2642}\\x{FE0F}\\x{1F3FC}|\\x{1F93D}\\x{200D}\\x{2642}\\x{FE0F}\\x{1F3FB}|\\x{1F645}\\x{200D}\\x{2640}\\x{FE0F}\\x{1F3FB}|\\x{1F645}\\x{200D}\\x{2640}\\x{FE0F}\\x{1F3FC}|\\x{1F647}\\x{200D}\\x{2640}\\x{FE0F}\\x{1F3FD}|\\x{1F645}\\x{200D}\\x{2640}\\x{FE0F}\\x{1F3FE}|\\x{1F645}\\x{200D}\\x{2640}\\x{FE0F}\\x{1F3FF}|\\x{1F647}\\x{200D}\\x{2640}\\x{FE0F}\\x{1F3FC}|\\x{1F3CA}\\x{200D}\\x{2642}\\x{FE0F}\\x{1F3FF}|\\x{1F647}\\x{200D}\\x{2640}\\x{FE0F}\\x{1F3FE}|\\x{1F64D}\\x{200D}\\x{2642}\\x{FE0F}\\x{1F3FB}|\\x{1F3C4}\\x{200D}\\x{2642}\\x{FE0F}\\x{1F3FB}|\\x{1F3C4}\\x{200D}\\x{2640}\\x{FE0F}\\x{1F3FF}|\\x{1F64D}\\x{200D}\\x{2640}\\x{FE0F}\\x{1F3FB}|\\x{1F3C4}\\x{200D}\\x{2640}\\x{FE0F}\\x{1F3FE}|\\x{1F64D}\\x{200D}\\x{2640}\\x{FE0F}\\x{1F3FC}|\\x{1F3C4}\\x{200D}\\x{2640}\\x{FE0F}\\x{1F3FD}|\\x{1F64D}\\x{200D}\\x{2640}\\x{FE0F}\\x{1F3FD}|\\x{1F64D}\\x{200D}\\x{2640}\\x{FE0F}\\x{1F3FE}|\\x{1F64D}\\x{200D}\\x{2640}\\x{FE0F}\\x{1F3FF}|\\x{1F3C4}\\x{200D}\\x{2640}\\x{FE0F}\\x{1F3FC}|\\x{1F3C4}\\x{200D}\\x{2640}\\x{FE0F}\\x{1F3FB}|\\x{1F64D}\\x{200D}\\x{2642}\\x{FE0F}\\x{1F3FC}|\\x{1F3C4}\\x{200D}\\x{2642}\\x{FE0F}\\x{1F3FC}|\\x{1F64D}\\x{200D}\\x{2642}\\x{FE0F}\\x{1F3FD}|\\x{1F64D}\\x{200D}\\x{2642}\\x{FE0F}\\x{1F3FE}|\\x{1F3C3}\\x{200D}\\x{2642}\\x{FE0F}\\x{1F3FF}|\\x{1F64D}\\x{200D}\\x{2642}\\x{FE0F}\\x{1F3FF}|\\x{1F3C3}\\x{200D}\\x{2642}\\x{FE0F}\\x{1F3FE}|\\x{1F468}\\x{200D}\\x{2708}\\x{FE0F}\\x{1F3FE}|\\x{1F64E}\\x{200D}\\x{2640}\\x{FE0F}\\x{1F3FB}|\\x{1F64E}\\x{200D}\\x{2640}\\x{FE0F}\\x{1F3FC}|\\x{1F64E}\\x{200D}\\x{2640}\\x{FE0F}\\x{1F3FD}|\\x{1F64E}\\x{200D}\\x{2640}\\x{FE0F}\\x{1F3FE}|\\x{1F64E}\\x{200D}\\x{2640}\\x{FE0F}\\x{1F3FF}|\\x{1F64B}\\x{200D}\\x{2642}\\x{FE0F}\\x{1F3FF}|\\x{1F64B}\\x{200D}\\x{2642}\\x{FE0F}\\x{1F3FE}|\\x{1F647}\\x{200D}\\x{2640}\\x{FE0F}\\x{1F3FF}|\\x{1F3CA}\\x{200D}\\x{2640}\\x{FE0F}\\x{1F3FF}|\\x{1F647}\\x{200D}\\x{2642}\\x{FE0F}\\x{1F3FB}|\\x{1F647}\\x{200D}\\x{2642}\\x{FE0F}\\x{1F3FC}|\\x{1F647}\\x{200D}\\x{2642}\\x{FE0F}\\x{1F3FD}|\\x{1F3CA}\\x{200D}\\x{2642}\\x{FE0F}\\x{1F3FE}|\\x{1F647}\\x{200D}\\x{2642}\\x{FE0F}\\x{1F3FE}|\\x{1F3CA}\\x{200D}\\x{2642}\\x{FE0F}\\x{1F3FD}|\\x{1F647}\\x{200D}\\x{2642}\\x{FE0F}\\x{1F3FF}|\\x{1F3CA}\\x{200D}\\x{2642}\\x{FE0F}\\x{1F3FC}|\\x{1F3CA}\\x{200D}\\x{2642}\\x{FE0F}\\x{1F3FB}|\\x{1F64B}\\x{200D}\\x{2640}\\x{FE0F}\\x{1F3FB}|\\x{1F64B}\\x{200D}\\x{2640}\\x{FE0F}\\x{1F3FC}|\\x{1F64B}\\x{200D}\\x{2640}\\x{FE0F}\\x{1F3FD}|\\x{1F3C4}\\x{200D}\\x{2642}\\x{FE0F}\\x{1F3FD}|\\x{1F3CA}\\x{200D}\\x{2640}\\x{FE0F}\\x{1F3FE}|\\x{1F64B}\\x{200D}\\x{2640}\\x{FE0F}\\x{1F3FE}|\\x{1F3CA}\\x{200D}\\x{2640}\\x{FE0F}\\x{1F3FD}|\\x{1F64B}\\x{200D}\\x{2640}\\x{FE0F}\\x{1F3FF}|\\x{1F3CA}\\x{200D}\\x{2640}\\x{FE0F}\\x{1F3FC}|\\x{1F3CA}\\x{200D}\\x{2640}\\x{FE0F}\\x{1F3FB}|\\x{1F64B}\\x{200D}\\x{2642}\\x{FE0F}\\x{1F3FB}|\\x{1F3C4}\\x{200D}\\x{2642}\\x{FE0F}\\x{1F3FF}|\\x{1F64B}\\x{200D}\\x{2642}\\x{FE0F}\\x{1F3FC}|\\x{1F3C4}\\x{200D}\\x{2642}\\x{FE0F}\\x{1F3FE}|\\x{1F64B}\\x{200D}\\x{2642}\\x{FE0F}\\x{1F3FD}|\\x{1F487}\\x{200D}\\x{2640}\\x{FE0F}\\x{1F3FB}|\\x{1F486}\\x{200D}\\x{2640}\\x{FE0F}\\x{1F3FF}|\\x{1F486}\\x{200D}\\x{2642}\\x{FE0F}\\x{1F3FF}|\\x{1F46E}\\x{200D}\\x{2642}\\x{FE0F}\\x{1F3FB}|\\x{1F468}\\x{200D}\\x{2695}\\x{FE0F}\\x{1F3FE}|\\x{1F468}\\x{200D}\\x{2695}\\x{FE0F}\\x{1F3FD}|\\x{1F93E}\\x{200D}\\x{2640}\\x{FE0F}\\x{1F3FF}|\\x{1F468}\\x{200D}\\x{2695}\\x{FE0F}\\x{1F3FC}|\\x{1F46E}\\x{200D}\\x{2640}\\x{FE0F}\\x{1F3FB}|\\x{1F46E}\\x{200D}\\x{2640}\\x{FE0F}\\x{1F3FC}|\\x{1F46E}\\x{200D}\\x{2640}\\x{FE0F}\\x{1F3FD}|\\x{1F46E}\\x{200D}\\x{2640}\\x{FE0F}\\x{1F3FE}|\\x{1F46E}\\x{200D}\\x{2640}\\x{FE0F}\\x{1F3FF}|\\x{1F93D}\\x{200D}\\x{2640}\\x{FE0F}\\x{1F3FF}|\\x{1F46E}\\x{200D}\\x{2642}\\x{FE0F}\\x{1F3FC}|\\x{1F469}\\x{200D}\\x{2708}\\x{FE0F}\\x{1F3FF}|\\x{1F46E}\\x{200D}\\x{2642}\\x{FE0F}\\x{1F3FD}|\\x{1F46E}\\x{200D}\\x{2642}\\x{FE0F}\\x{1F3FE}|\\x{1F46E}\\x{200D}\\x{2642}\\x{FE0F}\\x{1F3FF}|\\x{1F93E}\\x{200D}\\x{2642}\\x{FE0F}\\x{1F3FE}|\\x{1F471}\\x{200D}\\x{2640}\\x{FE0F}\\x{1F3FB}|\\x{1F471}\\x{200D}\\x{2640}\\x{FE0F}\\x{1F3FC}|\\x{1F471}\\x{200D}\\x{2640}\\x{FE0F}\\x{1F3FD}|\\x{1F471}\\x{200D}\\x{2640}\\x{FE0F}\\x{1F3FE}|\\x{1F471}\\x{200D}\\x{2640}\\x{FE0F}\\x{1F3FF}|\\x{1F471}\\x{200D}\\x{2642}\\x{FE0F}\\x{1F3FB}|\\x{1F93E}\\x{200D}\\x{2642}\\x{FE0F}\\x{1F3FB}|\\x{1F469}\\x{200D}\\x{2708}\\x{FE0F}\\x{1F3FE}|\\x{1F471}\\x{200D}\\x{2642}\\x{FE0F}\\x{1F3FD}|\\x{1F468}\\x{200D}\\x{2696}\\x{FE0F}\\x{1F3FF}|\\x{1F93E}\\x{200D}\\x{2642}\\x{FE0F}\\x{1F3FD}|\\x{1F468}\\x{200D}\\x{2708}\\x{FE0F}\\x{1F3FD}|\\x{1F468}\\x{200D}\\x{2708}\\x{FE0F}\\x{1F3FC}|\\x{1F93E}\\x{200D}\\x{2642}\\x{FE0F}\\x{1F3FC}|\\x{1F468}\\x{200D}\\x{2708}\\x{FE0F}\\x{1F3FB}|\\x{1F469}\\x{200D}\\x{2695}\\x{FE0F}\\x{1F3FB}|\\x{1F469}\\x{200D}\\x{2695}\\x{FE0F}\\x{1F3FC}|\\x{1F469}\\x{200D}\\x{2695}\\x{FE0F}\\x{1F3FD}|\\x{1F469}\\x{200D}\\x{2695}\\x{FE0F}\\x{1F3FE}|\\x{1F469}\\x{200D}\\x{2695}\\x{FE0F}\\x{1F3FF}|\\x{1F468}\\x{200D}\\x{2696}\\x{FE0F}\\x{1F3FE}|\\x{1F469}\\x{200D}\\x{2708}\\x{FE0F}\\x{1F3FD}|\\x{1F468}\\x{200D}\\x{2696}\\x{FE0F}\\x{1F3FD}|\\x{1F468}\\x{200D}\\x{2696}\\x{FE0F}\\x{1F3FC}|\\x{1F468}\\x{200D}\\x{2696}\\x{FE0F}\\x{1F3FB}|\\x{1F469}\\x{200D}\\x{2696}\\x{FE0F}\\x{1F3FB}|\\x{1F469}\\x{200D}\\x{2696}\\x{FE0F}\\x{1F3FC}|\\x{1F469}\\x{200D}\\x{2696}\\x{FE0F}\\x{1F3FD}|\\x{1F469}\\x{200D}\\x{2696}\\x{FE0F}\\x{1F3FE}|\\x{1F469}\\x{200D}\\x{2696}\\x{FE0F}\\x{1F3FF}|\\x{1F468}\\x{200D}\\x{2695}\\x{FE0F}\\x{1F3FF}|\\x{1F469}\\x{200D}\\x{2708}\\x{FE0F}\\x{1F3FB}|\\x{1F469}\\x{200D}\\x{2708}\\x{FE0F}\\x{1F3FC}|\\x{1F471}\\x{200D}\\x{2642}\\x{FE0F}\\x{1F3FC}|\\x{1F471}\\x{200D}\\x{2642}\\x{FE0F}\\x{1F3FE}|\\x{1F486}\\x{200D}\\x{2642}\\x{FE0F}\\x{1F3FE}|\\x{1F482}\\x{200D}\\x{2642}\\x{FE0F}\\x{1F3FB}|\\x{1F481}\\x{200D}\\x{2642}\\x{FE0F}\\x{1F3FC}|\\x{1F481}\\x{200D}\\x{2642}\\x{FE0F}\\x{1F3FD}|\\x{1F481}\\x{200D}\\x{2642}\\x{FE0F}\\x{1F3FE}|\\x{1F481}\\x{200D}\\x{2642}\\x{FE0F}\\x{1F3FF}|\\x{1F482}\\x{200D}\\x{2640}\\x{FE0F}\\x{1F3FB}|\\x{1F482}\\x{200D}\\x{2640}\\x{FE0F}\\x{1F3FC}|\\x{1F482}\\x{200D}\\x{2640}\\x{FE0F}\\x{1F3FD}|\\x{1F482}\\x{200D}\\x{2640}\\x{FE0F}\\x{1F3FE}|\\x{1F482}\\x{200D}\\x{2640}\\x{FE0F}\\x{1F3FF}|\\x{1F441}\\x{FE0F}\\x{200D}\\x{1F5E8}\\x{FE0F}|\\x{1F482}\\x{200D}\\x{2642}\\x{FE0F}\\x{1F3FC}|\\x{1F481}\\x{200D}\\x{2640}\\x{FE0F}\\x{1F3FF}|\\x{1F482}\\x{200D}\\x{2642}\\x{FE0F}\\x{1F3FD}|\\x{1F482}\\x{200D}\\x{2642}\\x{FE0F}\\x{1F3FE}|\\x{1F482}\\x{200D}\\x{2642}\\x{FE0F}\\x{1F3FF}|\\x{1F486}\\x{200D}\\x{2640}\\x{FE0F}\\x{1F3FB}|\\x{1F486}\\x{200D}\\x{2640}\\x{FE0F}\\x{1F3FC}|\\x{1F486}\\x{200D}\\x{2640}\\x{FE0F}\\x{1F3FD}|\\x{1F486}\\x{200D}\\x{2640}\\x{FE0F}\\x{1F3FE}|\\x{1F3C3}\\x{200D}\\x{2642}\\x{FE0F}\\x{1F3FB}|\\x{1F486}\\x{200D}\\x{2642}\\x{FE0F}\\x{1F3FB}|\\x{1F486}\\x{200D}\\x{2642}\\x{FE0F}\\x{1F3FC}|\\x{1F486}\\x{200D}\\x{2642}\\x{FE0F}\\x{1F3FD}|\\x{1F481}\\x{200D}\\x{2642}\\x{FE0F}\\x{1F3FB}|\\x{1F481}\\x{200D}\\x{2640}\\x{FE0F}\\x{1F3FE}|\\x{1F471}\\x{200D}\\x{2642}\\x{FE0F}\\x{1F3FF}|\\x{1F473}\\x{200D}\\x{2642}\\x{FE0F}\\x{1F3FF}|\\x{1F93E}\\x{200D}\\x{2642}\\x{FE0F}\\x{1F3FF}|\\x{1F473}\\x{200D}\\x{2640}\\x{FE0F}\\x{1F3FB}|\\x{1F473}\\x{200D}\\x{2640}\\x{FE0F}\\x{1F3FC}|\\x{1F473}\\x{200D}\\x{2640}\\x{FE0F}\\x{1F3FD}|\\x{1F473}\\x{200D}\\x{2640}\\x{FE0F}\\x{1F3FE}|\\x{1F473}\\x{200D}\\x{2640}\\x{FE0F}\\x{1F3FF}|\\x{1F473}\\x{200D}\\x{2642}\\x{FE0F}\\x{1F3FB}|\\x{1F473}\\x{200D}\\x{2642}\\x{FE0F}\\x{1F3FC}|\\x{1F473}\\x{200D}\\x{2642}\\x{FE0F}\\x{1F3FD}|\\x{1F473}\\x{200D}\\x{2642}\\x{FE0F}\\x{1F3FE}|\\x{1F477}\\x{200D}\\x{2640}\\x{FE0F}\\x{1F3FB}|\\x{1F481}\\x{200D}\\x{2640}\\x{FE0F}\\x{1F3FD}|\\x{1F477}\\x{200D}\\x{2640}\\x{FE0F}\\x{1F3FC}|\\x{1F477}\\x{200D}\\x{2640}\\x{FE0F}\\x{1F3FD}|\\x{1F477}\\x{200D}\\x{2640}\\x{FE0F}\\x{1F3FE}|\\x{1F477}\\x{200D}\\x{2640}\\x{FE0F}\\x{1F3FF}|\\x{1F477}\\x{200D}\\x{2642}\\x{FE0F}\\x{1F3FB}|\\x{1F477}\\x{200D}\\x{2642}\\x{FE0F}\\x{1F3FC}|\\x{1F477}\\x{200D}\\x{2642}\\x{FE0F}\\x{1F3FD}|\\x{1F477}\\x{200D}\\x{2642}\\x{FE0F}\\x{1F3FE}|\\x{1F477}\\x{200D}\\x{2642}\\x{FE0F}\\x{1F3FF}|\\x{1F481}\\x{200D}\\x{2640}\\x{FE0F}\\x{1F3FB}|\\x{1F481}\\x{200D}\\x{2640}\\x{FE0F}\\x{1F3FC}|\\x{1F3C3}\\x{200D}\\x{2642}\\x{FE0F}\\x{1F3FC}|\\x{1F3C3}\\x{200D}\\x{2642}\\x{FE0F}\\x{1F3FD}|\\x{1F468}\\x{200D}\\x{2708}\\x{FE0F}\\x{1F3FF}|\\x{1F6B5}\\x{200D}\\x{2640}\\x{FE0F}\\x{1F3FE}|\\x{1F938}\\x{200D}\\x{2640}\\x{FE0F}\\x{1F3FD}|\\x{1F6B6}\\x{200D}\\x{2640}\\x{FE0F}\\x{1F3FB}|\\x{1F938}\\x{200D}\\x{2640}\\x{FE0F}\\x{1F3FE}|\\x{1F6B5}\\x{200D}\\x{2642}\\x{FE0F}\\x{1F3FF}|\\x{1F938}\\x{200D}\\x{2640}\\x{FE0F}\\x{1F3FF}|\\x{1F6B5}\\x{200D}\\x{2642}\\x{FE0F}\\x{1F3FE}|\\x{1F6B5}\\x{200D}\\x{2642}\\x{FE0F}\\x{1F3FD}|\\x{1F6B5}\\x{200D}\\x{2642}\\x{FE0F}\\x{1F3FC}|\\x{1F6B5}\\x{200D}\\x{2642}\\x{FE0F}\\x{1F3FB}|\\x{1F938}\\x{200D}\\x{2642}\\x{FE0F}\\x{1F3FB}|\\x{1F6B5}\\x{200D}\\x{2640}\\x{FE0F}\\x{1F3FF}|\\x{1F6B5}\\x{200D}\\x{2640}\\x{FE0F}\\x{1F3FD}|\\x{1F6B6}\\x{200D}\\x{2640}\\x{FE0F}\\x{1F3FD}|\\x{1F6B5}\\x{200D}\\x{2640}\\x{FE0F}\\x{1F3FC}|\\x{1F6B5}\\x{200D}\\x{2640}\\x{FE0F}\\x{1F3FB}|\\x{1F938}\\x{200D}\\x{2642}\\x{FE0F}\\x{1F3FC}|\\x{1F6B4}\\x{200D}\\x{2642}\\x{FE0F}\\x{1F3FF}|\\x{1F6B4}\\x{200D}\\x{2642}\\x{FE0F}\\x{1F3FE}|\\x{1F6B4}\\x{200D}\\x{2642}\\x{FE0F}\\x{1F3FD}|\\x{1F937}\\x{200D}\\x{2640}\\x{FE0F}\\x{1F3FB}|\\x{1F6B4}\\x{200D}\\x{2642}\\x{FE0F}\\x{1F3FC}|\\x{1F6B4}\\x{200D}\\x{2642}\\x{FE0F}\\x{1F3FB}|\\x{1F6B4}\\x{200D}\\x{2640}\\x{FE0F}\\x{1F3FF}|\\x{1F6B4}\\x{200D}\\x{2640}\\x{FE0F}\\x{1F3FE}|\\x{1F6B4}\\x{200D}\\x{2640}\\x{FE0F}\\x{1F3FD}|\\x{1F6B6}\\x{200D}\\x{2640}\\x{FE0F}\\x{1F3FC}|\\x{1F938}\\x{200D}\\x{2640}\\x{FE0F}\\x{1F3FC}|\\x{1F938}\\x{200D}\\x{2642}\\x{FE0F}\\x{1F3FF}|\\x{1F926}\\x{200D}\\x{2640}\\x{FE0F}\\x{1F3FC}|\\x{1F937}\\x{200D}\\x{2640}\\x{FE0F}\\x{1F3FD}|\\x{1F926}\\x{200D}\\x{2642}\\x{FE0F}\\x{1F3FF}|\\x{1F926}\\x{200D}\\x{2642}\\x{FE0F}\\x{1F3FE}|\\x{1F937}\\x{200D}\\x{2640}\\x{FE0F}\\x{1F3FE}|\\x{1F926}\\x{200D}\\x{2642}\\x{FE0F}\\x{1F3FD}|\\x{1F926}\\x{200D}\\x{2642}\\x{FE0F}\\x{1F3FC}|\\x{1F937}\\x{200D}\\x{2640}\\x{FE0F}\\x{1F3FF}|\\x{1F926}\\x{200D}\\x{2642}\\x{FE0F}\\x{1F3FB}|\\x{1F926}\\x{200D}\\x{2640}\\x{FE0F}\\x{1F3FF}|\\x{1F937}\\x{200D}\\x{2642}\\x{FE0F}\\x{1F3FB}|\\x{1F926}\\x{200D}\\x{2640}\\x{FE0F}\\x{1F3FE}|\\x{1F926}\\x{200D}\\x{2640}\\x{FE0F}\\x{1F3FD}|\\x{1F937}\\x{200D}\\x{2642}\\x{FE0F}\\x{1F3FC}|\\x{1F6B6}\\x{200D}\\x{2640}\\x{FE0F}\\x{1F3FE}|\\x{1F926}\\x{200D}\\x{2640}\\x{FE0F}\\x{1F3FB}|\\x{1F937}\\x{200D}\\x{2642}\\x{FE0F}\\x{1F3FD}|\\x{1F937}\\x{200D}\\x{2642}\\x{FE0F}\\x{1F3FE}|\\x{1F6B6}\\x{200D}\\x{2642}\\x{FE0F}\\x{1F3FF}|\\x{1F6B6}\\x{200D}\\x{2642}\\x{FE0F}\\x{1F3FE}|\\x{1F937}\\x{200D}\\x{2642}\\x{FE0F}\\x{1F3FF}|\\x{1F6B6}\\x{200D}\\x{2642}\\x{FE0F}\\x{1F3FD}|\\x{1F64E}\\x{200D}\\x{2642}\\x{FE0F}\\x{1F3FB}|\\x{1F6B6}\\x{200D}\\x{2642}\\x{FE0F}\\x{1F3FC}|\\x{1F6B6}\\x{200D}\\x{2642}\\x{FE0F}\\x{1F3FB}|\\x{1F938}\\x{200D}\\x{2640}\\x{FE0F}\\x{1F3FB}|\\x{1F6B6}\\x{200D}\\x{2640}\\x{FE0F}\\x{1F3FF}|\\x{1F938}\\x{200D}\\x{2642}\\x{FE0F}\\x{1F3FE}|\\x{1F938}\\x{200D}\\x{2642}\\x{FE0F}\\x{1F3FD}|\\x{1F6B4}\\x{200D}\\x{2640}\\x{FE0F}\\x{1F3FC}|\\x{1F6A3}\\x{200D}\\x{2640}\\x{FE0F}\\x{1F3FC}|\\x{1F6A3}\\x{200D}\\x{2642}\\x{FE0F}\\x{1F3FB}|\\x{1F939}\\x{200D}\\x{2642}\\x{FE0F}\\x{1F3FB}|\\x{1F939}\\x{200D}\\x{2642}\\x{FE0F}\\x{1F3FC}|\\x{1F939}\\x{200D}\\x{2642}\\x{FE0F}\\x{1F3FD}|\\x{1F939}\\x{200D}\\x{2642}\\x{FE0F}\\x{1F3FE}|\\x{1F939}\\x{200D}\\x{2642}\\x{FE0F}\\x{1F3FF}|\\x{1F6A3}\\x{200D}\\x{2640}\\x{FE0F}\\x{1F3FF}|\\x{1F93D}\\x{200D}\\x{2640}\\x{FE0F}\\x{1F3FB}|\\x{1F6A3}\\x{200D}\\x{2640}\\x{FE0F}\\x{1F3FE}|\\x{1F6A3}\\x{200D}\\x{2640}\\x{FE0F}\\x{1F3FD}|\\x{1F93D}\\x{200D}\\x{2640}\\x{FE0F}\\x{1F3FC}|\\x{1F93D}\\x{200D}\\x{2640}\\x{FE0F}\\x{1F3FD}|\\x{1F939}\\x{200D}\\x{2640}\\x{FE0F}\\x{1F3FE}|\\x{1F6A3}\\x{200D}\\x{2640}\\x{FE0F}\\x{1F3FB}|\\x{1F93D}\\x{200D}\\x{2640}\\x{FE0F}\\x{1F3FE}|\\x{1F3C3}\\x{200D}\\x{2640}\\x{FE0F}\\x{1F3FB}|\\x{1F3C3}\\x{200D}\\x{2640}\\x{FE0F}\\x{1F3FC}|\\x{1F64E}\\x{200D}\\x{2642}\\x{FE0F}\\x{1F3FF}|\\x{1F3C3}\\x{200D}\\x{2640}\\x{FE0F}\\x{1F3FD}|\\x{1F64E}\\x{200D}\\x{2642}\\x{FE0F}\\x{1F3FE}|\\x{1F64E}\\x{200D}\\x{2642}\\x{FE0F}\\x{1F3FD}|\\x{1F3C3}\\x{200D}\\x{2640}\\x{FE0F}\\x{1F3FE}|\\x{1F64E}\\x{200D}\\x{2642}\\x{FE0F}\\x{1F3FC}|\\x{1F3C3}\\x{200D}\\x{2640}\\x{FE0F}\\x{1F3FF}|\\x{1F939}\\x{200D}\\x{2640}\\x{FE0F}\\x{1F3FF}|\\x{1F937}\\x{200D}\\x{2640}\\x{FE0F}\\x{1F3FC}|\\x{1F939}\\x{200D}\\x{2640}\\x{FE0F}\\x{1F3FD}|\\x{1F6A3}\\x{200D}\\x{2642}\\x{FE0F}\\x{1F3FE}|\\x{1F6B4}\\x{200D}\\x{2640}\\x{FE0F}\\x{1F3FB}|\\x{1F6A3}\\x{200D}\\x{2642}\\x{FE0F}\\x{1F3FD}|\\x{1F6A3}\\x{200D}\\x{2642}\\x{FE0F}\\x{1F3FC}|\\x{1F939}\\x{200D}\\x{2640}\\x{FE0F}\\x{1F3FB}|\\x{1F939}\\x{200D}\\x{2640}\\x{FE0F}\\x{1F3FC}|\\x{1F6A3}\\x{200D}\\x{2642}\\x{FE0F}\\x{1F3FF}|\\x{1F575}\\x{FE0F}\\x{200D}\\x{2640}\\x{FE0F}|\\x{1F3CC}\\x{FE0F}\\x{200D}\\x{2642}\\x{FE0F}|\\x{1F3CB}\\x{FE0F}\\x{200D}\\x{2640}\\x{FE0F}|\\x{1F3CB}\\x{FE0F}\\x{200D}\\x{2642}\\x{FE0F}|\\x{1F3CC}\\x{FE0F}\\x{200D}\\x{2640}\\x{FE0F}|\\x{1F575}\\x{FE0F}\\x{200D}\\x{2642}\\x{FE0F}|\\x{26F9}\\x{FE0F}\\x{200D}\\x{2640}\\x{FE0F}|\\x{26F9}\\x{FE0F}\\x{200D}\\x{2642}\\x{FE0F}|\\x{1F468}\\x{200D}\\x{1F4BC}\\x{1F3FE}|\\x{1F468}\\x{200D}\\x{1F33E}\\x{1F3FB}|\\x{1F468}\\x{200D}\\x{1F3EB}\\x{1F3FF}|\\x{1F468}\\x{200D}\\x{1F4BC}\\x{1F3FD}|\\x{1F468}\\x{200D}\\x{1F33E}\\x{1F3FC}|\\x{1F468}\\x{200D}\\x{1F3EB}\\x{1F3FE}|\\x{1F468}\\x{200D}\\x{1F527}\\x{1F3FC}|\\x{1F468}\\x{200D}\\x{1F3EB}\\x{1F3FD}|\\x{1F468}\\x{200D}\\x{1F4BC}\\x{1F3FF}|\\x{1F468}\\x{200D}\\x{1F527}\\x{1F3FB}|\\x{1F468}\\x{200D}\\x{1F3A8}\\x{1F3FB}|\\x{1F468}\\x{200D}\\x{1F3A8}\\x{1F3FC}|\\x{1F468}\\x{200D}\\x{1F3EB}\\x{1F3FC}|\\x{1F468}\\x{200D}\\x{1F527}\\x{1F3FD}|\\x{1F468}\\x{200D}\\x{1F3EB}\\x{1F3FB}|\\x{1F468}\\x{200D}\\x{1F3A8}\\x{1F3FF}|\\x{1F468}\\x{200D}\\x{1F527}\\x{1F3FE}|\\x{1F468}\\x{200D}\\x{1F3A8}\\x{1F3FE}|\\x{1F468}\\x{200D}\\x{1F3A8}\\x{1F3FD}|\\x{1F468}\\x{200D}\\x{1F527}\\x{1F3FF}|\\x{1F468}\\x{200D}\\x{1F3A4}\\x{1F3FF}|\\x{1F468}\\x{200D}\\x{1F3A4}\\x{1F3FD}|\\x{1F468}\\x{200D}\\x{1F33E}\\x{1F3FD}|\\x{1F468}\\x{200D}\\x{1F393}\\x{1F3FB}|\\x{1F468}\\x{200D}\\x{1F3ED}\\x{1F3FC}|\\x{1F468}\\x{200D}\\x{1F3A4}\\x{1F3FB}|\\x{1F468}\\x{200D}\\x{1F3ED}\\x{1F3FD}|\\x{1F468}\\x{200D}\\x{1F393}\\x{1F3FF}|\\x{1F468}\\x{200D}\\x{1F3ED}\\x{1F3FE}|\\x{1F468}\\x{200D}\\x{1F393}\\x{1F3FE}|\\x{1F468}\\x{200D}\\x{1F3ED}\\x{1F3FF}|\\x{1F468}\\x{200D}\\x{1F393}\\x{1F3FD}|\\x{1F468}\\x{200D}\\x{1F4BB}\\x{1F3FB}|\\x{1F468}\\x{200D}\\x{1F393}\\x{1F3FC}|\\x{1F468}\\x{200D}\\x{1F4BB}\\x{1F3FC}|\\x{1F468}\\x{200D}\\x{1F3ED}\\x{1F3FB}|\\x{1F468}\\x{200D}\\x{1F33E}\\x{1F3FE}|\\x{1F468}\\x{200D}\\x{1F4BB}\\x{1F3FD}|\\x{1F468}\\x{200D}\\x{1F373}\\x{1F3FF}|\\x{1F468}\\x{200D}\\x{1F3A4}\\x{1F3FE}|\\x{1F468}\\x{200D}\\x{1F373}\\x{1F3FE}|\\x{1F468}\\x{200D}\\x{1F4BB}\\x{1F3FE}|\\x{1F468}\\x{200D}\\x{1F373}\\x{1F3FD}|\\x{1F468}\\x{200D}\\x{1F4BB}\\x{1F3FF}|\\x{1F468}\\x{200D}\\x{1F4BC}\\x{1F3FB}|\\x{1F468}\\x{200D}\\x{1F373}\\x{1F3FC}|\\x{1F468}\\x{200D}\\x{1F4BC}\\x{1F3FC}|\\x{1F468}\\x{200D}\\x{1F3A4}\\x{1F3FC}|\\x{1F468}\\x{200D}\\x{1F33E}\\x{1F3FF}|\\x{1F468}\\x{200D}\\x{1F373}\\x{1F3FB}|\\x{1F469}\\x{200D}\\x{1F33E}\\x{1F3FE}|\\x{1F468}\\x{200D}\\x{1F52C}\\x{1F3FB}|\\x{1F469}\\x{200D}\\x{1F4BB}\\x{1F3FC}|\\x{1F469}\\x{200D}\\x{1F4BC}\\x{1F3FE}|\\x{1F469}\\x{200D}\\x{1F4BC}\\x{1F3FD}|\\x{1F469}\\x{200D}\\x{1F4BC}\\x{1F3FC}|\\x{1F469}\\x{200D}\\x{1F4BC}\\x{1F3FB}|\\x{1F469}\\x{200D}\\x{1F4BB}\\x{1F3FF}|\\x{1F469}\\x{200D}\\x{1F4BB}\\x{1F3FE}|\\x{1F469}\\x{200D}\\x{1F4BB}\\x{1F3FD}|\\x{1F469}\\x{200D}\\x{1F4BB}\\x{1F3FB}|\\x{1F469}\\x{200D}\\x{1F527}\\x{1F3FB}|\\x{1F469}\\x{200D}\\x{1F3ED}\\x{1F3FF}|\\x{1F469}\\x{200D}\\x{1F3ED}\\x{1F3FE}|\\x{1F469}\\x{200D}\\x{1F3ED}\\x{1F3FD}|\\x{1F469}\\x{200D}\\x{1F3ED}\\x{1F3FC}|\\x{1F469}\\x{200D}\\x{1F3ED}\\x{1F3FB}|\\x{1F469}\\x{200D}\\x{1F3EB}\\x{1F3FF}|\\x{1F468}\\x{200D}\\x{1F52C}\\x{1F3FC}|\\x{1F469}\\x{200D}\\x{1F4BC}\\x{1F3FF}|\\x{1F469}\\x{200D}\\x{1F527}\\x{1F3FC}|\\x{1F469}\\x{200D}\\x{1F3EB}\\x{1F3FC}|\\x{1F469}\\x{200D}\\x{1F680}\\x{1F3FD}|\\x{1F469}\\x{200D}\\x{1F692}\\x{1F3FF}|\\x{1F469}\\x{200D}\\x{1F692}\\x{1F3FE}|\\x{1F469}\\x{200D}\\x{1F692}\\x{1F3FD}|\\x{1F469}\\x{200D}\\x{1F692}\\x{1F3FC}|\\x{1F469}\\x{200D}\\x{1F692}\\x{1F3FB}|\\x{1F469}\\x{200D}\\x{1F680}\\x{1F3FF}|\\x{1F469}\\x{200D}\\x{1F680}\\x{1F3FE}|\\x{1F469}\\x{200D}\\x{1F680}\\x{1F3FC}|\\x{1F469}\\x{200D}\\x{1F527}\\x{1F3FD}|\\x{1F469}\\x{200D}\\x{1F680}\\x{1F3FB}|\\x{1F469}\\x{200D}\\x{1F52C}\\x{1F3FF}|\\x{1F469}\\x{200D}\\x{1F52C}\\x{1F3FE}|\\x{1F469}\\x{200D}\\x{1F52C}\\x{1F3FD}|\\x{1F469}\\x{200D}\\x{1F52C}\\x{1F3FC}|\\x{1F469}\\x{200D}\\x{1F52C}\\x{1F3FB}|\\x{1F469}\\x{200D}\\x{1F527}\\x{1F3FF}|\\x{1F469}\\x{200D}\\x{1F527}\\x{1F3FE}|\\x{1F469}\\x{200D}\\x{1F3EB}\\x{1F3FD}|\\x{1F469}\\x{200D}\\x{1F3EB}\\x{1F3FE}|\\x{1F469}\\x{200D}\\x{1F3EB}\\x{1F3FB}|\\x{1F468}\\x{200D}\\x{1F692}\\x{1F3FC}|\\x{1F469}\\x{200D}\\x{1F3A8}\\x{1F3FF}|\\x{1F469}\\x{200D}\\x{1F33E}\\x{1F3FD}|\\x{1F469}\\x{200D}\\x{1F33E}\\x{1F3FC}|\\x{1F469}\\x{200D}\\x{1F33E}\\x{1F3FB}|\\x{1F468}\\x{200D}\\x{1F692}\\x{1F3FF}|\\x{1F468}\\x{200D}\\x{1F692}\\x{1F3FE}|\\x{1F468}\\x{200D}\\x{1F692}\\x{1F3FD}|\\x{1F468}\\x{200D}\\x{1F692}\\x{1F3FB}|\\x{1F469}\\x{200D}\\x{1F373}\\x{1F3FC}|\\x{1F468}\\x{200D}\\x{1F680}\\x{1F3FF}|\\x{1F468}\\x{200D}\\x{1F680}\\x{1F3FE}|\\x{1F468}\\x{200D}\\x{1F680}\\x{1F3FD}|\\x{1F468}\\x{200D}\\x{1F680}\\x{1F3FC}|\\x{1F468}\\x{200D}\\x{1F680}\\x{1F3FB}|\\x{1F468}\\x{200D}\\x{1F52C}\\x{1F3FF}|\\x{1F468}\\x{200D}\\x{1F52C}\\x{1F3FE}|\\x{1F468}\\x{200D}\\x{1F52C}\\x{1F3FD}|\\x{1F469}\\x{200D}\\x{1F373}\\x{1F3FB}|\\x{1F469}\\x{200D}\\x{1F33E}\\x{1F3FF}|\\x{1F469}\\x{200D}\\x{1F373}\\x{1F3FD}|\\x{1F469}\\x{200D}\\x{1F393}\\x{1F3FF}|\\x{1F469}\\x{200D}\\x{1F3A8}\\x{1F3FB}|\\x{1F469}\\x{200D}\\x{1F3A4}\\x{1F3FF}|\\x{1F469}\\x{200D}\\x{1F3A4}\\x{1F3FE}|\\x{1F469}\\x{200D}\\x{1F3A4}\\x{1F3FD}|\\x{1F469}\\x{200D}\\x{1F3A4}\\x{1F3FC}|\\x{1F469}\\x{200D}\\x{1F3A8}\\x{1F3FE}|\\x{1F469}\\x{200D}\\x{1F3A4}\\x{1F3FB}|\\x{1F469}\\x{200D}\\x{1F393}\\x{1F3FE}|\\x{1F469}\\x{200D}\\x{1F3A8}\\x{1F3FD}|\\x{1F469}\\x{200D}\\x{1F393}\\x{1F3FD}|\\x{1F469}\\x{200D}\\x{1F393}\\x{1F3FC}|\\x{1F469}\\x{200D}\\x{1F393}\\x{1F3FB}|\\x{1F469}\\x{200D}\\x{1F373}\\x{1F3FF}|\\x{1F469}\\x{200D}\\x{1F373}\\x{1F3FE}|\\x{1F469}\\x{200D}\\x{1F3A8}\\x{1F3FC}|\\x{1F3F3}\\x{FE0F}\\x{200D}\\x{1F308}|\\x{1F3C4}\\x{200D}\\x{2640}\\x{FE0F}|\\x{1F468}\\x{200D}\\x{2695}\\x{FE0F}|\\x{1F3C3}\\x{200D}\\x{2640}\\x{FE0F}|\\x{1F3C4}\\x{200D}\\x{2642}\\x{FE0F}|\\x{1F468}\\x{200D}\\x{2708}\\x{FE0F}|\\x{1F3CA}\\x{200D}\\x{2640}\\x{FE0F}|\\x{1F3CA}\\x{200D}\\x{2642}\\x{FE0F}|\\x{1F468}\\x{200D}\\x{2696}\\x{FE0F}|\\x{1F3C3}\\x{200D}\\x{2642}\\x{FE0F}|\\x{1F93D}\\x{200D}\\x{2642}\\x{FE0F}|\\x{1F6B4}\\x{200D}\\x{2642}\\x{FE0F}|\\x{1F93C}\\x{200D}\\x{2642}\\x{FE0F}|\\x{1F487}\\x{200D}\\x{2642}\\x{FE0F}|\\x{1F937}\\x{200D}\\x{2642}\\x{FE0F}|\\x{1F6B5}\\x{200D}\\x{2642}\\x{FE0F}|\\x{1F93E}\\x{200D}\\x{2640}\\x{FE0F}|\\x{1F6B4}\\x{200D}\\x{2640}\\x{FE0F}|\\x{1F645}\\x{200D}\\x{2640}\\x{FE0F}|\\x{1F6B6}\\x{200D}\\x{2640}\\x{FE0F}|\\x{1F645}\\x{200D}\\x{2642}\\x{FE0F}|\\x{1F938}\\x{200D}\\x{2640}\\x{FE0F}|\\x{1F646}\\x{200D}\\x{2640}\\x{FE0F}|\\x{1F6A3}\\x{200D}\\x{2642}\\x{FE0F}|\\x{1F926}\\x{200D}\\x{2640}\\x{FE0F}|\\x{1F93D}\\x{200D}\\x{2640}\\x{FE0F}|\\x{1F93C}\\x{200D}\\x{2640}\\x{FE0F}|\\x{1F6B5}\\x{200D}\\x{2640}\\x{FE0F}|\\x{1F939}\\x{200D}\\x{2640}\\x{FE0F}|\\x{1F646}\\x{200D}\\x{2642}\\x{FE0F}|\\x{1F647}\\x{200D}\\x{2640}\\x{FE0F}|\\x{1F647}\\x{200D}\\x{2642}\\x{FE0F}|\\x{1F64B}\\x{200D}\\x{2640}\\x{FE0F}|\\x{1F939}\\x{200D}\\x{2642}\\x{FE0F}|\\x{1F64B}\\x{200D}\\x{2642}\\x{FE0F}|\\x{1F938}\\x{200D}\\x{2642}\\x{FE0F}|\\x{1F64D}\\x{200D}\\x{2640}\\x{FE0F}|\\x{1F6B6}\\x{200D}\\x{2642}\\x{FE0F}|\\x{1F64D}\\x{200D}\\x{2642}\\x{FE0F}|\\x{1F6A3}\\x{200D}\\x{2640}\\x{FE0F}|\\x{1F64E}\\x{200D}\\x{2640}\\x{FE0F}|\\x{1F487}\\x{200D}\\x{2640}\\x{FE0F}|\\x{1F64E}\\x{200D}\\x{2642}\\x{FE0F}|\\x{1F486}\\x{200D}\\x{2642}\\x{FE0F}|\\x{1F477}\\x{200D}\\x{2642}\\x{FE0F}|\\x{1F471}\\x{200D}\\x{2640}\\x{FE0F}|\\x{1F46F}\\x{200D}\\x{2642}\\x{FE0F}|\\x{1F471}\\x{200D}\\x{2642}\\x{FE0F}|\\x{1F473}\\x{200D}\\x{2640}\\x{FE0F}|\\x{1F926}\\x{200D}\\x{2642}\\x{FE0F}|\\x{1F46F}\\x{200D}\\x{2640}\\x{FE0F}|\\x{1F46E}\\x{200D}\\x{2642}\\x{FE0F}|\\x{1F46E}\\x{200D}\\x{2640}\\x{FE0F}|\\x{1F473}\\x{200D}\\x{2642}\\x{FE0F}|\\x{1F477}\\x{200D}\\x{2640}\\x{FE0F}|\\x{1F93E}\\x{200D}\\x{2642}\\x{FE0F}|\\x{1F469}\\x{200D}\\x{2708}\\x{FE0F}|\\x{1F481}\\x{200D}\\x{2642}\\x{FE0F}|\\x{1F486}\\x{200D}\\x{2640}\\x{FE0F}|\\x{1F482}\\x{200D}\\x{2642}\\x{FE0F}|\\x{1F469}\\x{200D}\\x{2696}\\x{FE0F}|\\x{1F937}\\x{200D}\\x{2640}\\x{FE0F}|\\x{1F481}\\x{200D}\\x{2640}\\x{FE0F}|\\x{1F482}\\x{200D}\\x{2640}\\x{FE0F}|\\x{1F469}\\x{200D}\\x{2695}\\x{FE0F}|\\x{1F468}\\x{200D}\\x{1F680}|\\x{1F469}\\x{200D}\\x{1F52C}|\\x{1F468}\\x{200D}\\x{1F3A8}|\\x{1F468}\\x{200D}\\x{1F373}|\\x{1F469}\\x{200D}\\x{1F692}|\\x{1F468}\\x{200D}\\x{1F466}|\\x{1F468}\\x{200D}\\x{1F4BB}|\\x{1F468}\\x{200D}\\x{1F393}|\\x{1F469}\\x{200D}\\x{1F3EB}|\\x{1F469}\\x{200D}\\x{1F373}|\\x{1F468}\\x{200D}\\x{1F3ED}|\\x{1F468}\\x{200D}\\x{1F4BC}|\\x{1F469}\\x{200D}\\x{1F680}|\\x{1F468}\\x{200D}\\x{1F3A4}|\\x{1F468}\\x{200D}\\x{1F467}|\\x{1F468}\\x{200D}\\x{1F33E}|\\x{1F469}\\x{200D}\\x{1F527}|\\x{1F468}\\x{200D}\\x{1F692}|\\x{1F469}\\x{200D}\\x{1F393}|\\x{1F468}\\x{200D}\\x{1F52C}|\\x{1F469}\\x{200D}\\x{1F3A4}|\\x{1F468}\\x{200D}\\x{1F3EB}|\\x{1F469}\\x{200D}\\x{1F4BB}|\\x{1F469}\\x{200D}\\x{1F467}|\\x{1F469}\\x{200D}\\x{1F4BC}|\\x{1F469}\\x{200D}\\x{1F466}|\\x{1F469}\\x{200D}\\x{1F3A8}|\\x{1F468}\\x{200D}\\x{1F527}|\\x{1F469}\\x{200D}\\x{1F3ED}|\\x{1F469}\\x{200D}\\x{1F33E}|\\x{0039}\\x{FE0F}\\x{20E3}|\\x{0030}\\x{FE0F}\\x{20E3}|\\x{0037}\\x{FE0F}\\x{20E3}|\\x{0036}\\x{FE0F}\\x{20E3}|\\x{0023}\\x{FE0F}\\x{20E3}|\\x{002A}\\x{FE0F}\\x{20E3}|\\x{0038}\\x{FE0F}\\x{20E3}|\\x{0034}\\x{FE0F}\\x{20E3}|\\x{0031}\\x{FE0F}\\x{20E3}|\\x{0033}\\x{FE0F}\\x{20E3}|\\x{0035}\\x{FE0F}\\x{20E3}|\\x{0032}\\x{FE0F}\\x{20E3}|\\x{1F1F0}\\x{1F1FF}|\\x{1F1EE}\\x{1F1F9}|\\x{1F1F0}\\x{1F1F3}|\\x{1F1F1}\\x{1F1F0}|\\x{1F1F0}\\x{1F1F7}|\\x{1F1F0}\\x{1F1FC}|\\x{1F1EF}\\x{1F1EA}|\\x{1F930}\\x{1F3FE}|\\x{1F1F1}\\x{1F1EE}|\\x{1F1EF}\\x{1F1F2}|\\x{1F1F1}\\x{1F1F8}|\\x{1F1EF}\\x{1F1F4}|\\x{1F1F1}\\x{1F1F7}|\\x{1F933}\\x{1F3FB}|\\x{1F1EF}\\x{1F1F5}|\\x{1F1F1}\\x{1F1E6}|\\x{1F1F0}\\x{1F1F2}|\\x{1F1F0}\\x{1F1EA}|\\x{1F1F0}\\x{1F1EC}|\\x{1F933}\\x{1F3FC}|\\x{1F1F0}\\x{1F1FE}|\\x{1F1F1}\\x{1F1E8}|\\x{1F930}\\x{1F3FF}|\\x{1F1F0}\\x{1F1ED}|\\x{1F1F0}\\x{1F1EE}|\\x{1F1F0}\\x{1F1F5}|\\x{1F1F1}\\x{1F1E7}|\\x{1F918}\\x{1F3FF}|\\x{1F1EE}\\x{1F1F8}|\\x{1F1EB}\\x{1F1F7}|\\x{1F1EC}\\x{1F1F1}|\\x{1F1EC}\\x{1F1EE}|\\x{1F1EC}\\x{1F1ED}|\\x{1F1EC}\\x{1F1EC}|\\x{1F6C0}\\x{1F3FC}|\\x{1F1EC}\\x{1F1EB}|\\x{1F1EC}\\x{1F1EA}|\\x{1F1EC}\\x{1F1E9}|\\x{1F1EC}\\x{1F1E7}|\\x{1F1EC}\\x{1F1E6}|\\x{1F6C0}\\x{1F3FB}|\\x{1F1EB}\\x{1F1F4}|\\x{1F1EC}\\x{1F1F3}|\\x{1F1EB}\\x{1F1F2}|\\x{1F1EB}\\x{1F1F0}|\\x{1F1EB}\\x{1F1EF}|\\x{1F933}\\x{1F3FF}|\\x{1F934}\\x{1F3FB}|\\x{1F934}\\x{1F3FC}|\\x{1F934}\\x{1F3FD}|\\x{1F934}\\x{1F3FE}|\\x{1F934}\\x{1F3FF}|\\x{1F935}\\x{1F3FB}|\\x{1F935}\\x{1F3FC}|\\x{1F1EC}\\x{1F1F2}|\\x{1F1EC}\\x{1F1F5}|\\x{1F1EE}\\x{1F1F7}|\\x{1F1ED}\\x{1F1F3}|\\x{1F1EE}\\x{1F1F6}|\\x{1F1EE}\\x{1F1F4}|\\x{1F1EE}\\x{1F1F3}|\\x{1F1EE}\\x{1F1F2}|\\x{1F1EE}\\x{1F1F1}|\\x{1F1EE}\\x{1F1EA}|\\x{1F1EE}\\x{1F1E9}|\\x{1F1EE}\\x{1F1E8}|\\x{1F1ED}\\x{1F1FA}|\\x{1F1ED}\\x{1F1F9}|\\x{1F1ED}\\x{1F1F7}|\\x{1F1ED}\\x{1F1F2}|\\x{1F1EC}\\x{1F1F6}|\\x{1F933}\\x{1F3FD}|\\x{1F1ED}\\x{1F1F0}|\\x{1F1EC}\\x{1F1FE}|\\x{1F1EC}\\x{1F1FA}|\\x{1F1EC}\\x{1F1F9}|\\x{1F933}\\x{1F3FE}|\\x{1F6C0}\\x{1F3FF}|\\x{1F6C0}\\x{1F3FE}|\\x{1F6C0}\\x{1F3FD}|\\x{1F1EC}\\x{1F1F8}|\\x{1F1EC}\\x{1F1F7}|\\x{1F1EC}\\x{1F1FC}|\\x{1F1F2}\\x{1F1F5}|\\x{1F1F1}\\x{1F1F9}|\\x{1F1F5}\\x{1F1EC}|\\x{1F1F5}\\x{1F1FE}|\\x{1F1F5}\\x{1F1FC}|\\x{1F1F5}\\x{1F1F9}|\\x{1F1F5}\\x{1F1F8}|\\x{1F1F5}\\x{1F1F7}|\\x{1F1F5}\\x{1F1F3}|\\x{1F1F5}\\x{1F1F2}|\\x{1F1F5}\\x{1F1F1}|\\x{1F1F5}\\x{1F1F0}|\\x{1F1F5}\\x{1F1ED}|\\x{1F1F5}\\x{1F1EB}|\\x{1F1F7}\\x{1F1EA}|\\x{1F918}\\x{1F3FC}|\\x{1F918}\\x{1F3FB}|\\x{1F91C}\\x{1F3FB}|\\x{1F91C}\\x{1F3FC}|\\x{1F91C}\\x{1F3FD}|\\x{1F91C}\\x{1F3FE}|\\x{1F91C}\\x{1F3FF}|\\x{1F91E}\\x{1F3FB}|\\x{1F91E}\\x{1F3FC}|\\x{1F91E}\\x{1F3FD}|\\x{1F1F6}\\x{1F1E6}|\\x{1F1F7}\\x{1F1F4}|\\x{1F91E}\\x{1F3FF}|\\x{1F1F8}\\x{1F1F1}|\\x{1F1F8}\\x{1F1FF}|\\x{1F1F8}\\x{1F1FE}|\\x{1F1F8}\\x{1F1FD}|\\x{1F1F8}\\x{1F1FB}|\\x{1F1F8}\\x{1F1F9}|\\x{1F1F8}\\x{1F1F8}|\\x{1F1F8}\\x{1F1F7}|\\x{1F1F8}\\x{1F1F4}|\\x{1F1F8}\\x{1F1F3}|\\x{1F1F8}\\x{1F1F2}|\\x{1F1F8}\\x{1F1F0}|\\x{1F1F7}\\x{1F1F8}|\\x{1F1F8}\\x{1F1EF}|\\x{1F1F8}\\x{1F1EE}|\\x{1F1F8}\\x{1F1ED}|\\x{1F1F8}\\x{1F1EC}|\\x{1F1F8}\\x{1F1EA}|\\x{1F1F8}\\x{1F1E9}|\\x{1F1F8}\\x{1F1E8}|\\x{1F1F8}\\x{1F1E7}|\\x{1F1F8}\\x{1F1E6}|\\x{1F1F7}\\x{1F1FC}|\\x{1F1F7}\\x{1F1FA}|\\x{1F91E}\\x{1F3FE}|\\x{1F926}\\x{1F3FB}|\\x{1F1F1}\\x{1F1FA}|\\x{1F1F2}\\x{1F1ED}|\\x{1F1F2}\\x{1F1F6}|\\x{1F1F2}\\x{1F1F4}|\\x{1F1F2}\\x{1F1F3}|\\x{1F1F2}\\x{1F1F2}|\\x{1F1F2}\\x{1F1F1}|\\x{1F930}\\x{1F3FB}|\\x{1F930}\\x{1F3FC}|\\x{1F930}\\x{1F3FD}|\\x{1F6CC}\\x{1F3FF}|\\x{1F1F2}\\x{1F1F0}|\\x{1F1F2}\\x{1F1EC}|\\x{1F1F2}\\x{1F1F8}|\\x{1F1F2}\\x{1F1EB}|\\x{1F1F2}\\x{1F1EA}|\\x{1F6CC}\\x{1F3FE}|\\x{1F6CC}\\x{1F3FD}|\\x{1F6CC}\\x{1F3FC}|\\x{1F6CC}\\x{1F3FB}|\\x{1F1F2}\\x{1F1E9}|\\x{1F1F2}\\x{1F1E8}|\\x{1F1F2}\\x{1F1E6}|\\x{1F1F1}\\x{1F1FE}|\\x{1F1F1}\\x{1F1FB}|\\x{1F1F2}\\x{1F1F7}|\\x{1F1F2}\\x{1F1F9}|\\x{1F1F5}\\x{1F1EA}|\\x{1F926}\\x{1F3FD}|\\x{1F1F5}\\x{1F1E6}|\\x{1F1F4}\\x{1F1F2}|\\x{1F1F3}\\x{1F1FF}|\\x{1F1F3}\\x{1F1FA}|\\x{1F926}\\x{1F3FC}|\\x{1F1F3}\\x{1F1F7}|\\x{1F1F3}\\x{1F1F5}|\\x{1F1F3}\\x{1F1F4}|\\x{1F1F3}\\x{1F1F1}|\\x{1F1F3}\\x{1F1EE}|\\x{1F1F3}\\x{1F1EC}|\\x{1F1F2}\\x{1F1FA}|\\x{1F1F3}\\x{1F1EB}|\\x{1F1F3}\\x{1F1EA}|\\x{1F1F3}\\x{1F1E8}|\\x{1F1F3}\\x{1F1E6}|\\x{1F926}\\x{1F3FE}|\\x{1F1F2}\\x{1F1FF}|\\x{1F1F2}\\x{1F1FE}|\\x{1F1F2}\\x{1F1FD}|\\x{1F1F2}\\x{1F1FC}|\\x{1F1F2}\\x{1F1FB}|\\x{1F926}\\x{1F3FF}|\\x{1F6B6}\\x{1F3FF}|\\x{1F1E9}\\x{1F1EF}|\\x{1F6B6}\\x{1F3FE}|\\x{1F647}\\x{1F3FD}|\\x{1F64C}\\x{1F3FB}|\\x{1F64B}\\x{1F3FF}|\\x{1F1E8}\\x{1F1E8}|\\x{1F64B}\\x{1F3FE}|\\x{1F64B}\\x{1F3FD}|\\x{1F1E8}\\x{1F1E6}|\\x{1F64B}\\x{1F3FC}|\\x{1F64B}\\x{1F3FB}|\\x{1F647}\\x{1F3FF}|\\x{1F647}\\x{1F3FE}|\\x{1F647}\\x{1F3FC}|\\x{1F64C}\\x{1F3FD}|\\x{1F647}\\x{1F3FB}|\\x{1F646}\\x{1F3FF}|\\x{1F646}\\x{1F3FE}|\\x{1F646}\\x{1F3FD}|\\x{1F646}\\x{1F3FC}|\\x{1F646}\\x{1F3FB}|\\x{1F645}\\x{1F3FF}|\\x{1F645}\\x{1F3FE}|\\x{1F645}\\x{1F3FD}|\\x{1F645}\\x{1F3FC}|\\x{1F64C}\\x{1F3FC}|\\x{1F64C}\\x{1F3FE}|\\x{1F91B}\\x{1F3FB}|\\x{1F64F}\\x{1F3FD}|\\x{1F93D}\\x{1F3FD}|\\x{1F93D}\\x{1F3FE}|\\x{1F93D}\\x{1F3FF}|\\x{1F93E}\\x{1F3FB}|\\x{1F93E}\\x{1F3FC}|\\x{1F93E}\\x{1F3FD}|\\x{1F93E}\\x{1F3FE}|\\x{1F93E}\\x{1F3FF}|\\x{1F64F}\\x{1F3FF}|\\x{1F64F}\\x{1F3FE}|\\x{1F64F}\\x{1F3FC}|\\x{1F64C}\\x{1F3FF}|\\x{1F64F}\\x{1F3FB}|\\x{1F64E}\\x{1F3FF}|\\x{1F64E}\\x{1F3FE}|\\x{1F64E}\\x{1F3FD}|\\x{1F64E}\\x{1F3FC}|\\x{1F64E}\\x{1F3FB}|\\x{1F64D}\\x{1F3FF}|\\x{1F64D}\\x{1F3FE}|\\x{1F64D}\\x{1F3FD}|\\x{1F64D}\\x{1F3FC}|\\x{1F64D}\\x{1F3FB}|\\x{1F645}\\x{1F3FB}|\\x{1F91B}\\x{1F3FE}|\\x{1F93D}\\x{1F3FB}|\\x{1F1E6}\\x{1F1EC}|\\x{1F1E6}\\x{1F1FA}|\\x{1F1E6}\\x{1F1F9}|\\x{1F1E6}\\x{1F1F8}|\\x{1F91A}\\x{1F3FB}|\\x{1F1E6}\\x{1F1F7}|\\x{1F1E6}\\x{1F1F6}|\\x{1F1E6}\\x{1F1F4}|\\x{1F1E6}\\x{1F1F2}|\\x{1F1E6}\\x{1F1F1}|\\x{1F1E6}\\x{1F1EE}|\\x{1F1E6}\\x{1F1EB}|\\x{1F1E6}\\x{1F1FD}|\\x{1F1E6}\\x{1F1EA}|\\x{1F1E6}\\x{1F1E9}|\\x{1F91B}\\x{1F3FF}|\\x{1F919}\\x{1F3FF}|\\x{1F919}\\x{1F3FE}|\\x{1F919}\\x{1F3FD}|\\x{1F919}\\x{1F3FC}|\\x{1F919}\\x{1F3FB}|\\x{1F918}\\x{1F3FD}|\\x{1F1E6}\\x{1F1E8}|\\x{1F918}\\x{1F3FE}|\\x{1F1E6}\\x{1F1FC}|\\x{1F91A}\\x{1F3FC}|\\x{1F91A}\\x{1F3FF}|\\x{1F1E7}\\x{1F1F2}|\\x{1F1E7}\\x{1F1FF}|\\x{1F1E7}\\x{1F1FE}|\\x{1F1E7}\\x{1F1FC}|\\x{1F1E7}\\x{1F1FB}|\\x{1F1E7}\\x{1F1F9}|\\x{1F1E7}\\x{1F1F8}|\\x{1F1E7}\\x{1F1F7}|\\x{1F1E7}\\x{1F1F6}|\\x{1F1E7}\\x{1F1F4}|\\x{1F1E7}\\x{1F1F3}|\\x{1F1E7}\\x{1F1F1}|\\x{1F1E6}\\x{1F1FF}|\\x{1F91A}\\x{1F3FE}|\\x{1F1E7}\\x{1F1EF}|\\x{1F1E7}\\x{1F1EE}|\\x{1F1E7}\\x{1F1ED}|\\x{1F1E7}\\x{1F1EC}|\\x{1F1E7}\\x{1F1EB}|\\x{1F91A}\\x{1F3FD}|\\x{1F1E7}\\x{1F1EA}|\\x{1F1E7}\\x{1F1E9}|\\x{1F1E7}\\x{1F1E7}|\\x{1F1E7}\\x{1F1E6}|\\x{1F93D}\\x{1F3FC}|\\x{1F939}\\x{1F3FF}|\\x{1F6B6}\\x{1F3FD}|\\x{1F57A}\\x{1F3FD}|\\x{1F6B5}\\x{1F3FB}|\\x{1F575}\\x{1F3FE}|\\x{1F575}\\x{1F3FF}|\\x{1F1E9}\\x{1F1F2}|\\x{1F1E9}\\x{1F1F0}|\\x{1F1F9}\\x{1F1E8}|\\x{1F1E9}\\x{1F1EC}|\\x{1F1E9}\\x{1F1EA}|\\x{1F57A}\\x{1F3FB}|\\x{1F57A}\\x{1F3FC}|\\x{1F57A}\\x{1F3FE}|\\x{1F575}\\x{1F3FC}|\\x{1F57A}\\x{1F3FF}|\\x{1F1E8}\\x{1F1FF}|\\x{1F1E8}\\x{1F1FE}|\\x{1F1E8}\\x{1F1FD}|\\x{1F935}\\x{1F3FE}|\\x{1F1E8}\\x{1F1FC}|\\x{1F1E8}\\x{1F1FB}|\\x{1F1E8}\\x{1F1FA}|\\x{1F590}\\x{1F3FB}|\\x{1F590}\\x{1F3FC}|\\x{1F575}\\x{1F3FD}|\\x{1F575}\\x{1F3FB}|\\x{1F590}\\x{1F3FD}|\\x{1F1EA}\\x{1F1ED}|\\x{1F6B6}\\x{1F3FC}|\\x{1F6B6}\\x{1F3FB}|\\x{1F935}\\x{1F3FD}|\\x{1F6B5}\\x{1F3FF}|\\x{1F1EB}\\x{1F1EE}|\\x{1F1EA}\\x{1F1FA}|\\x{1F1EA}\\x{1F1F9}|\\x{1F1EA}\\x{1F1F8}|\\x{1F1EA}\\x{1F1F7}|\\x{1F6B5}\\x{1F3FE}|\\x{1F1EA}\\x{1F1EC}|\\x{1F1E9}\\x{1F1F4}|\\x{1F1EA}\\x{1F1EA}|\\x{1F1EA}\\x{1F1E8}|\\x{1F1EA}\\x{1F1E6}|\\x{1F6B5}\\x{1F3FD}|\\x{1F1E9}\\x{1F1FF}|\\x{1F574}\\x{1F3FB}|\\x{1F574}\\x{1F3FC}|\\x{1F574}\\x{1F3FD}|\\x{1F574}\\x{1F3FE}|\\x{1F6B5}\\x{1F3FC}|\\x{1F574}\\x{1F3FF}|\\x{1F6B4}\\x{1F3FF}|\\x{1F590}\\x{1F3FE}|\\x{1F939}\\x{1F3FE}|\\x{1F938}\\x{1F3FB}|\\x{1F936}\\x{1F3FB}|\\x{1F936}\\x{1F3FC}|\\x{1F936}\\x{1F3FD}|\\x{1F936}\\x{1F3FE}|\\x{1F936}\\x{1F3FF}|\\x{1F937}\\x{1F3FB}|\\x{1F937}\\x{1F3FC}|\\x{1F937}\\x{1F3FD}|\\x{1F937}\\x{1F3FE}|\\x{1F937}\\x{1F3FF}|\\x{1F938}\\x{1F3FC}|\\x{1F1E8}\\x{1F1E9}|\\x{1F938}\\x{1F3FD}|\\x{1F6A3}\\x{1F3FF}|\\x{1F6A3}\\x{1F3FE}|\\x{1F6A3}\\x{1F3FD}|\\x{1F6A3}\\x{1F3FC}|\\x{1F6A3}\\x{1F3FB}|\\x{1F938}\\x{1F3FE}|\\x{1F938}\\x{1F3FF}|\\x{1F939}\\x{1F3FB}|\\x{1F939}\\x{1F3FC}|\\x{1F939}\\x{1F3FD}|\\x{1F935}\\x{1F3FF}|\\x{1F1E8}\\x{1F1EB}|\\x{1F590}\\x{1F3FF}|\\x{1F596}\\x{1F3FC}|\\x{1F1E8}\\x{1F1F7}|\\x{1F595}\\x{1F3FB}|\\x{1F6B4}\\x{1F3FE}|\\x{1F595}\\x{1F3FC}|\\x{1F595}\\x{1F3FD}|\\x{1F595}\\x{1F3FE}|\\x{1F595}\\x{1F3FF}|\\x{1F1E8}\\x{1F1F5}|\\x{1F6B4}\\x{1F3FD}|\\x{1F596}\\x{1F3FB}|\\x{1F596}\\x{1F3FD}|\\x{1F1E8}\\x{1F1EC}|\\x{1F596}\\x{1F3FE}|\\x{1F596}\\x{1F3FF}|\\x{1F6B4}\\x{1F3FC}|\\x{1F1E8}\\x{1F1F4}|\\x{1F1E8}\\x{1F1F3}|\\x{1F1E8}\\x{1F1F2}|\\x{1F1E8}\\x{1F1F1}|\\x{1F1E8}\\x{1F1F0}|\\x{1F6B4}\\x{1F3FB}|\\x{1F1E8}\\x{1F1EE}|\\x{1F1E8}\\x{1F1ED}|\\x{1F1F9}\\x{1F1E6}|\\x{1F44A}\\x{1F3FF}|\\x{1F1F9}\\x{1F1E9}|\\x{1F44B}\\x{1F3FC}|\\x{1F44D}\\x{1F3FF}|\\x{1F44D}\\x{1F3FE}|\\x{1F44D}\\x{1F3FD}|\\x{1F44D}\\x{1F3FC}|\\x{1F44D}\\x{1F3FB}|\\x{1F44C}\\x{1F3FF}|\\x{1F44C}\\x{1F3FE}|\\x{1F44C}\\x{1F3FD}|\\x{1F44C}\\x{1F3FC}|\\x{1F44C}\\x{1F3FB}|\\x{1F44B}\\x{1F3FF}|\\x{1F44B}\\x{1F3FE}|\\x{1F44B}\\x{1F3FD}|\\x{1F44B}\\x{1F3FB}|\\x{1F44E}\\x{1F3FC}|\\x{1F91B}\\x{1F3FD}|\\x{1F44A}\\x{1F3FE}|\\x{1F44A}\\x{1F3FD}|\\x{1F44A}\\x{1F3FC}|\\x{1F44A}\\x{1F3FB}|\\x{1F449}\\x{1F3FF}|\\x{1F449}\\x{1F3FE}|\\x{1F449}\\x{1F3FD}|\\x{1F449}\\x{1F3FC}|\\x{1F449}\\x{1F3FB}|\\x{1F448}\\x{1F3FF}|\\x{1F448}\\x{1F3FE}|\\x{1F448}\\x{1F3FD}|\\x{1F44E}\\x{1F3FB}|\\x{1F44E}\\x{1F3FD}|\\x{1F448}\\x{1F3FB}|\\x{1F466}\\x{1F3FE}|\\x{1F469}\\x{1F3FC}|\\x{1F469}\\x{1F3FB}|\\x{1F468}\\x{1F3FF}|\\x{1F468}\\x{1F3FE}|\\x{1F468}\\x{1F3FD}|\\x{1F468}\\x{1F3FC}|\\x{1F468}\\x{1F3FB}|\\x{1F467}\\x{1F3FF}|\\x{1F467}\\x{1F3FE}|\\x{1F467}\\x{1F3FD}|\\x{1F467}\\x{1F3FC}|\\x{1F467}\\x{1F3FB}|\\x{1F466}\\x{1F3FF}|\\x{1F466}\\x{1F3FD}|\\x{1F44E}\\x{1F3FE}|\\x{1F466}\\x{1F3FC}|\\x{1F466}\\x{1F3FB}|\\x{1F450}\\x{1F3FF}|\\x{1F450}\\x{1F3FE}|\\x{1F450}\\x{1F3FD}|\\x{1F450}\\x{1F3FC}|\\x{1F450}\\x{1F3FB}|\\x{1F44F}\\x{1F3FF}|\\x{1F44F}\\x{1F3FE}|\\x{1F44F}\\x{1F3FD}|\\x{1F44F}\\x{1F3FC}|\\x{1F44F}\\x{1F3FB}|\\x{1F44E}\\x{1F3FF}|\\x{1F448}\\x{1F3FC}|\\x{1F447}\\x{1F3FF}|\\x{1F469}\\x{1F3FE}|\\x{1F3C3}\\x{1F3FE}|\\x{1F3CA}\\x{1F3FC}|\\x{1F3CA}\\x{1F3FB}|\\x{1F3C7}\\x{1F3FF}|\\x{1F3C7}\\x{1F3FE}|\\x{1F3C7}\\x{1F3FD}|\\x{1F3C7}\\x{1F3FC}|\\x{1F3C7}\\x{1F3FB}|\\x{1F3C4}\\x{1F3FF}|\\x{1F3C4}\\x{1F3FE}|\\x{1F3C4}\\x{1F3FD}|\\x{1F3C4}\\x{1F3FC}|\\x{1F3C4}\\x{1F3FB}|\\x{1F3C3}\\x{1F3FF}|\\x{1F3C3}\\x{1F3FD}|\\x{1F3CA}\\x{1F3FE}|\\x{1F3C3}\\x{1F3FC}|\\x{1F3C3}\\x{1F3FB}|\\x{1F3C2}\\x{1F3FF}|\\x{1F3C2}\\x{1F3FE}|\\x{1F3C2}\\x{1F3FD}|\\x{1F1F9}\\x{1F1EB}|\\x{1F3C2}\\x{1F3FC}|\\x{1F3C2}\\x{1F3FB}|\\x{1F385}\\x{1F3FF}|\\x{1F385}\\x{1F3FE}|\\x{1F385}\\x{1F3FD}|\\x{1F385}\\x{1F3FC}|\\x{1F385}\\x{1F3FB}|\\x{1F3CA}\\x{1F3FD}|\\x{1F3CA}\\x{1F3FF}|\\x{1F447}\\x{1F3FE}|\\x{1F442}\\x{1F3FF}|\\x{1F447}\\x{1F3FD}|\\x{1F447}\\x{1F3FC}|\\x{1F447}\\x{1F3FB}|\\x{1F446}\\x{1F3FF}|\\x{1F446}\\x{1F3FE}|\\x{1F446}\\x{1F3FD}|\\x{1F446}\\x{1F3FC}|\\x{1F446}\\x{1F3FB}|\\x{1F443}\\x{1F3FF}|\\x{1F443}\\x{1F3FE}|\\x{1F443}\\x{1F3FD}|\\x{1F443}\\x{1F3FC}|\\x{1F443}\\x{1F3FB}|\\x{1F442}\\x{1F3FE}|\\x{1F3CB}\\x{1F3FB}|\\x{1F442}\\x{1F3FD}|\\x{1F442}\\x{1F3FC}|\\x{1F442}\\x{1F3FB}|\\x{1F1F9}\\x{1F1ED}|\\x{1F3CC}\\x{1F3FF}|\\x{1F3CC}\\x{1F3FE}|\\x{1F3CC}\\x{1F3FD}|\\x{1F3CC}\\x{1F3FC}|\\x{1F3CC}\\x{1F3FB}|\\x{1F3CB}\\x{1F3FF}|\\x{1F3CB}\\x{1F3FE}|\\x{1F3CB}\\x{1F3FD}|\\x{1F3CB}\\x{1F3FC}|\\x{1F469}\\x{1F3FD}|\\x{1F91B}\\x{1F3FC}|\\x{1F469}\\x{1F3FF}|\\x{1F486}\\x{1F3FE}|\\x{1F1FC}\\x{1F1F8}|\\x{1F1FD}\\x{1F1F0}|\\x{1F1FE}\\x{1F1EA}|\\x{1F1FE}\\x{1F1F9}|\\x{1F1FF}\\x{1F1E6}|\\x{1F1FF}\\x{1F1F2}|\\x{1F1FF}\\x{1F1FC}|\\x{1F487}\\x{1F3FF}|\\x{1F487}\\x{1F3FE}|\\x{1F487}\\x{1F3FD}|\\x{1F487}\\x{1F3FC}|\\x{1F487}\\x{1F3FB}|\\x{1F486}\\x{1F3FF}|\\x{1F486}\\x{1F3FD}|\\x{1F1FB}\\x{1F1FA}|\\x{1F486}\\x{1F3FC}|\\x{1F486}\\x{1F3FB}|\\x{1F485}\\x{1F3FF}|\\x{1F485}\\x{1F3FE}|\\x{1F485}\\x{1F3FD}|\\x{1F485}\\x{1F3FC}|\\x{1F485}\\x{1F3FB}|\\x{1F483}\\x{1F3FF}|\\x{1F483}\\x{1F3FE}|\\x{1F483}\\x{1F3FD}|\\x{1F483}\\x{1F3FC}|\\x{1F483}\\x{1F3FB}|\\x{1F482}\\x{1F3FF}|\\x{1F1FC}\\x{1F1EB}|\\x{1F1FB}\\x{1F1F3}|\\x{1F482}\\x{1F3FD}|\\x{1F1FA}\\x{1F1EC}|\\x{1F46E}\\x{1F3FB}|\\x{1F1F9}\\x{1F1EC}|\\x{1F1F9}\\x{1F1F0}|\\x{1F1F9}\\x{1F1F1}|\\x{1F1F9}\\x{1F1F2}|\\x{1F1F9}\\x{1F1F3}|\\x{1F1F9}\\x{1F1F4}|\\x{1F1F9}\\x{1F1F7}|\\x{1F1F9}\\x{1F1F9}|\\x{1F1F9}\\x{1F1FB}|\\x{1F1F9}\\x{1F1FC}|\\x{1F1F9}\\x{1F1FF}|\\x{1F1FA}\\x{1F1E6}|\\x{1F1FA}\\x{1F1F2}|\\x{1F1FB}\\x{1F1EE}|\\x{1F1FA}\\x{1F1F3}|\\x{1F1FA}\\x{1F1F8}|\\x{1F1FA}\\x{1F1FE}|\\x{1F1FA}\\x{1F1FF}|\\x{1F1FB}\\x{1F1E6}|\\x{1F4AA}\\x{1F3FF}|\\x{1F4AA}\\x{1F3FE}|\\x{1F4AA}\\x{1F3FD}|\\x{1F4AA}\\x{1F3FC}|\\x{1F4AA}\\x{1F3FB}|\\x{1F1FB}\\x{1F1E8}|\\x{1F1FB}\\x{1F1EA}|\\x{1F1FB}\\x{1F1EC}|\\x{1F482}\\x{1F3FE}|\\x{1F1F9}\\x{1F1EF}|\\x{1F482}\\x{1F3FC}|\\x{1F472}\\x{1F3FC}|\\x{1F474}\\x{1F3FF}|\\x{1F474}\\x{1F3FE}|\\x{1F474}\\x{1F3FD}|\\x{1F474}\\x{1F3FC}|\\x{1F474}\\x{1F3FB}|\\x{1F473}\\x{1F3FF}|\\x{1F473}\\x{1F3FE}|\\x{1F473}\\x{1F3FD}|\\x{1F473}\\x{1F3FC}|\\x{1F482}\\x{1F3FB}|\\x{1F472}\\x{1F3FF}|\\x{1F472}\\x{1F3FE}|\\x{1F472}\\x{1F3FD}|\\x{1F472}\\x{1F3FB}|\\x{1F475}\\x{1F3FC}|\\x{1F471}\\x{1F3FF}|\\x{1F471}\\x{1F3FE}|\\x{1F471}\\x{1F3FD}|\\x{1F471}\\x{1F3FC}|\\x{1F471}\\x{1F3FB}|\\x{1F470}\\x{1F3FF}|\\x{1F470}\\x{1F3FE}|\\x{1F470}\\x{1F3FD}|\\x{1F470}\\x{1F3FC}|\\x{1F470}\\x{1F3FB}|\\x{1F46E}\\x{1F3FF}|\\x{1F46E}\\x{1F3FE}|\\x{1F46E}\\x{1F3FD}|\\x{1F46E}\\x{1F3FC}|\\x{1F475}\\x{1F3FB}|\\x{1F473}\\x{1F3FB}|\\x{1F475}\\x{1F3FD}|\\x{1F478}\\x{1F3FB}|\\x{1F481}\\x{1F3FF}|\\x{1F481}\\x{1F3FE}|\\x{1F481}\\x{1F3FD}|\\x{1F481}\\x{1F3FB}|\\x{1F47C}\\x{1F3FF}|\\x{1F47C}\\x{1F3FE}|\\x{1F47C}\\x{1F3FD}|\\x{1F47C}\\x{1F3FC}|\\x{1F47C}\\x{1F3FB}|\\x{1F478}\\x{1F3FF}|\\x{1F478}\\x{1F3FE}|\\x{1F478}\\x{1F3FD}|\\x{1F478}\\x{1F3FC}|\\x{1F481}\\x{1F3FC}|\\x{1F477}\\x{1F3FF}|\\x{1F477}\\x{1F3FD}|\\x{1F477}\\x{1F3FC}|\\x{1F477}\\x{1F3FB}|\\x{1F476}\\x{1F3FF}|\\x{1F476}\\x{1F3FE}|\\x{1F476}\\x{1F3FD}|\\x{1F476}\\x{1F3FC}|\\x{1F476}\\x{1F3FB}|\\x{1F477}\\x{1F3FE}|\\x{1F475}\\x{1F3FF}|\\x{1F475}\\x{1F3FE}|\\x{270D}\\x{1F3FD}|\\x{270C}\\x{1F3FF}|\\x{270D}\\x{1F3FB}|\\x{270D}\\x{1F3FC}|\\x{261D}\\x{1F3FD}|\\x{270D}\\x{1F3FE}|\\x{270D}\\x{1F3FF}|\\x{261D}\\x{1F3FF}|\\x{261D}\\x{1F3FE}|\\x{270C}\\x{1F3FD}|\\x{261D}\\x{1F3FC}|\\x{261D}\\x{1F3FB}|\\x{270C}\\x{1F3FE}|\\x{270B}\\x{1F3FC}|\\x{270C}\\x{1F3FC}|\\x{270C}\\x{1F3FB}|\\x{270B}\\x{1F3FF}|\\x{270B}\\x{1F3FE}|\\x{270B}\\x{1F3FD}|\\x{270B}\\x{1F3FB}|\\x{270A}\\x{1F3FF}|\\x{270A}\\x{1F3FE}|\\x{270A}\\x{1F3FD}|\\x{270A}\\x{1F3FC}|\\x{26F9}\\x{1F3FB}|\\x{270A}\\x{1F3FB}|\\x{26F9}\\x{1F3FC}|\\x{26F9}\\x{1F3FD}|\\x{1F004}\\x{FE0F}|\\x{26F9}\\x{1F3FF}|\\x{1F202}\\x{FE0F}|\\x{1F237}\\x{FE0F}|\\x{1F21A}\\x{FE0F}|\\x{1F22F}\\x{FE0F}|\\x{26F9}\\x{1F3FE}|\\x{1F170}\\x{FE0F}|\\x{1F3CB}\\x{FE0F}|\\x{1F171}\\x{FE0F}|\\x{1F17F}\\x{FE0F}|\\x{1F17E}\\x{FE0F}|\\x{1F575}\\x{FE0F}|\\x{1F3CC}\\x{FE0F}|\\x{1F3F3}\\x{FE0F}|\\x{269B}\\x{FE0F}|\\x{2699}\\x{FE0F}|\\x{269C}\\x{FE0F}|\\x{2697}\\x{FE0F}|\\x{2696}\\x{FE0F}|\\x{25AB}\\x{FE0F}|\\x{2694}\\x{FE0F}|\\x{2195}\\x{FE0F}|\\x{2196}\\x{FE0F}|\\x{26A1}\\x{FE0F}|\\x{2693}\\x{FE0F}|\\x{2197}\\x{FE0F}|\\x{267F}\\x{FE0F}|\\x{2198}\\x{FE0F}|\\x{267B}\\x{FE0F}|\\x{26A0}\\x{FE0F}|\\x{26BD}\\x{FE0F}|\\x{26AA}\\x{FE0F}|\\x{203C}\\x{FE0F}|\\x{26F9}\\x{FE0F}|\\x{26F5}\\x{FE0F}|\\x{26F3}\\x{FE0F}|\\x{26F2}\\x{FE0F}|\\x{26EA}\\x{FE0F}|\\x{26D4}\\x{FE0F}|\\x{00AE}\\x{FE0F}|\\x{2049}\\x{FE0F}|\\x{26AB}\\x{FE0F}|\\x{26C5}\\x{FE0F}|\\x{2122}\\x{FE0F}|\\x{2139}\\x{FE0F}|\\x{2194}\\x{FE0F}|\\x{26C4}\\x{FE0F}|\\x{26BE}\\x{FE0F}|\\x{26B1}\\x{FE0F}|\\x{26B0}\\x{FE0F}|\\x{2199}\\x{FE0F}|\\x{2666}\\x{FE0F}|\\x{2668}\\x{FE0F}|\\x{2611}\\x{FE0F}|\\x{21AA}\\x{FE0F}|\\x{231A}\\x{FE0F}|\\x{231B}\\x{FE0F}|\\x{2328}\\x{FE0F}|\\x{261D}\\x{FE0F}|\\x{2618}\\x{FE0F}|\\x{24C2}\\x{FE0F}|\\x{2615}\\x{FE0F}|\\x{2614}\\x{FE0F}|\\x{260E}\\x{FE0F}|\\x{2622}\\x{FE0F}|\\x{2604}\\x{FE0F}|\\x{2603}\\x{FE0F}|\\x{2602}\\x{FE0F}|\\x{2601}\\x{FE0F}|\\x{2600}\\x{FE0F}|\\x{25FE}\\x{FE0F}|\\x{25AA}\\x{FE0F}|\\x{25FC}\\x{FE0F}|\\x{25FB}\\x{FE0F}|\\x{25C0}\\x{FE0F}|\\x{2620}\\x{FE0F}|\\x{2623}\\x{FE0F}|\\x{25B6}\\x{FE0F}|\\x{264C}\\x{FE0F}|\\x{2665}\\x{FE0F}|\\x{2663}\\x{FE0F}|\\x{2660}\\x{FE0F}|\\x{2653}\\x{FE0F}|\\x{2652}\\x{FE0F}|\\x{2651}\\x{FE0F}|\\x{2650}\\x{FE0F}|\\x{264F}\\x{FE0F}|\\x{264E}\\x{FE0F}|\\x{264D}\\x{FE0F}|\\x{264B}\\x{FE0F}|\\x{2626}\\x{FE0F}|\\x{264A}\\x{FE0F}|\\x{2649}\\x{FE0F}|\\x{2648}\\x{FE0F}|\\x{263A}\\x{FE0F}|\\x{2639}\\x{FE0F}|\\x{2638}\\x{FE0F}|\\x{21A9}\\x{FE0F}|\\x{262F}\\x{FE0F}|\\x{262E}\\x{FE0F}|\\x{262A}\\x{FE0F}|\\x{25FD}\\x{FE0F}|\\x{2934}\\x{FE0F}|\\x{00A9}\\x{FE0F}|\\x{27A1}\\x{FE0F}|\\x{2B1C}\\x{FE0F}|\\x{2B1B}\\x{FE0F}|\\x{26FA}\\x{FE0F}|\\x{2B06}\\x{FE0F}|\\x{2B05}\\x{FE0F}|\\x{2935}\\x{FE0F}|\\x{2764}\\x{FE0F}|\\x{2B55}\\x{FE0F}|\\x{2763}\\x{FE0F}|\\x{2757}\\x{FE0F}|\\x{2747}\\x{FE0F}|\\x{2744}\\x{FE0F}|\\x{2734}\\x{FE0F}|\\x{2733}\\x{FE0F}|\\x{2B50}\\x{FE0F}|\\x{3030}\\x{FE0F}|\\x{271D}\\x{FE0F}|\\x{0033}\\x{20E3}|\\x{0039}\\x{20E3}|\\x{0038}\\x{20E3}|\\x{0037}\\x{20E3}|\\x{0036}\\x{20E3}|\\x{0035}\\x{20E3}|\\x{0034}\\x{20E3}|\\x{0032}\\x{20E3}|\\x{303D}\\x{FE0F}|\\x{0031}\\x{20E3}|\\x{0030}\\x{20E3}|\\x{002A}\\x{20E3}|\\x{0023}\\x{20E3}|\\x{3299}\\x{FE0F}|\\x{3297}\\x{FE0F}|\\x{2721}\\x{FE0F}|\\x{2B07}\\x{FE0F}|\\x{2716}\\x{FE0F}|\\x{2714}\\x{FE0F}|\\x{2712}\\x{FE0F}|\\x{26FD}\\x{FE0F}|\\x{2702}\\x{FE0F}|\\x{270F}\\x{FE0F}|\\x{270D}\\x{FE0F}|\\x{2708}\\x{FE0F}|\\x{270C}\\x{FE0F}|\\x{2709}\\x{FE0F}|\\x{1F988}|\\x{1F98B}|\\x{1F98A}|\\x{1F989}|\\x{1F91D}|\\x{1F91E}|\\x{1F920}|\\x{1F987}|\\x{1F986}|\\x{1F985}|\\x{1F984}|\\x{1F98D}|\\x{1F921}|\\x{1F98C}|\\x{1F91C}|\\x{1F98E}|\\x{1F98F}|\\x{1F990}|\\x{1F991}|\\x{1F9C0}|\\x{1F923}|\\x{1F942}|\\x{1F941}|\\x{1F940}|\\x{1F93E}|\\x{1F93D}|\\x{1F938}|\\x{1F93C}|\\x{1F93A}|\\x{1F3EE}|\\x{1F922}|\\x{1F983}|\\x{1F924}|\\x{1F95A}|\\x{1F94A}|\\x{1F95B}|\\x{1F94B}|\\x{1F950}|\\x{1F951}|\\x{1F952}|\\x{1F959}|\\x{1F949}|\\x{1F958}|\\x{1F957}|\\x{1F934}|\\x{1F953}|\\x{1F954}|\\x{1F935}|\\x{1F956}|\\x{1F933}|\\x{1F936}|\\x{1F925}|\\x{1F927}|\\x{1F926}|\\x{1F955}|\\x{1F982}|\\x{1F981}|\\x{1F980}|\\x{1F95E}|\\x{1F930}|\\x{1F948}|\\x{1F95D}|\\x{1F937}|\\x{1F943}|\\x{1F944}|\\x{1F945}|\\x{1F95C}|\\x{1F947}|\\x{1F939}|\\x{1F615}|\\x{1F91B}|\\x{1F400}|\\x{1F40A}|\\x{1F409}|\\x{1F408}|\\x{1F407}|\\x{1F406}|\\x{1F405}|\\x{1F404}|\\x{1F403}|\\x{1F402}|\\x{1F401}|\\x{1F3FF}|\\x{1F40C}|\\x{1F3FE}|\\x{1F3FD}|\\x{1F3FC}|\\x{1F3FB}|\\x{1F3FA}|\\x{1F3F9}|\\x{1F3F8}|\\x{1F3F7}|\\x{1F3F5}|\\x{1F3F4}|\\x{1F40B}|\\x{1F40D}|\\x{1F3F0}|\\x{1F41B}|\\x{1F425}|\\x{1F424}|\\x{1F423}|\\x{1F422}|\\x{1F421}|\\x{1F420}|\\x{1F41F}|\\x{1F41E}|\\x{1F41D}|\\x{1F41C}|\\x{1F41A}|\\x{1F40E}|\\x{1F419}|\\x{1F418}|\\x{1F417}|\\x{1F416}|\\x{1F415}|\\x{1F414}|\\x{1F413}|\\x{1F412}|\\x{1F411}|\\x{1F410}|\\x{1F40F}|\\x{1F3F3}|\\x{1F3EF}|\\x{1F427}|\\x{1F3C7}|\\x{1F3D1}|\\x{1F3D0}|\\x{1F3CF}|\\x{1F3CE}|\\x{1F3CD}|\\x{1F3CC}|\\x{1F3CB}|\\x{1F3CA}|\\x{1F3C9}|\\x{1F3C8}|\\x{1F3C6}|\\x{1F3D3}|\\x{1F3C5}|\\x{1F3C4}|\\x{1F3C3}|\\x{1F3C2}|\\x{1F3C1}|\\x{1F3C0}|\\x{1F3BF}|\\x{1F3BE}|\\x{1F3BD}|\\x{1F3BC}|\\x{1F3D2}|\\x{1F3D4}|\\x{1F3ED}|\\x{1F3E2}|\\x{1F3EC}|\\x{1F3EB}|\\x{1F3EA}|\\x{1F3E9}|\\x{1F3E8}|\\x{1F3E7}|\\x{1F3E6}|\\x{1F3E5}|\\x{1F3E4}|\\x{1F3E3}|\\x{1F3E1}|\\x{1F3D5}|\\x{1F3E0}|\\x{1F3DF}|\\x{1F3DE}|\\x{1F3DD}|\\x{1F3DC}|\\x{1F3DB}|\\x{1F3DA}|\\x{1F3D9}|\\x{1F3D8}|\\x{1F3D7}|\\x{1F3D6}|\\x{1F426}|\\x{1F428}|\\x{1F3BA}|\\x{1F46B}|\\x{1F475}|\\x{1F474}|\\x{1F473}|\\x{1F472}|\\x{1F471}|\\x{1F470}|\\x{1F46F}|\\x{1F46E}|\\x{1F46D}|\\x{1F46C}|\\x{1F46A}|\\x{1F477}|\\x{1F469}|\\x{1F468}|\\x{1F467}|\\x{1F466}|\\x{1F465}|\\x{1F464}|\\x{1F463}|\\x{1F462}|\\x{1F461}|\\x{1F460}|\\x{1F476}|\\x{1F478}|\\x{1F45E}|\\x{1F486}|\\x{1F490}|\\x{1F48F}|\\x{1F48E}|\\x{1F48D}|\\x{1F48C}|\\x{1F48B}|\\x{1F48A}|\\x{1F489}|\\x{1F488}|\\x{1F487}|\\x{1F485}|\\x{1F479}|\\x{1F484}|\\x{1F483}|\\x{1F482}|\\x{1F481}|\\x{1F480}|\\x{1F47F}|\\x{1F47E}|\\x{1F47D}|\\x{1F47C}|\\x{1F47B}|\\x{1F47A}|\\x{1F45F}|\\x{1F45D}|\\x{1F429}|\\x{1F436}|\\x{1F91A}|\\x{1F43F}|\\x{1F43E}|\\x{1F43D}|\\x{1F43C}|\\x{1F43B}|\\x{1F43A}|\\x{1F439}|\\x{1F438}|\\x{1F437}|\\x{1F435}|\\x{1F442}|\\x{1F434}|\\x{1F433}|\\x{1F432}|\\x{1F431}|\\x{1F430}|\\x{1F42F}|\\x{1F42E}|\\x{1F42D}|\\x{1F42C}|\\x{1F42B}|\\x{1F42A}|\\x{1F441}|\\x{1F443}|\\x{1F45C}|\\x{1F451}|\\x{1F45B}|\\x{1F45A}|\\x{1F459}|\\x{1F458}|\\x{1F457}|\\x{1F456}|\\x{1F455}|\\x{1F454}|\\x{1F453}|\\x{1F452}|\\x{1F450}|\\x{1F444}|\\x{1F44F}|\\x{1F44E}|\\x{1F44D}|\\x{1F44C}|\\x{1F44B}|\\x{1F44A}|\\x{1F449}|\\x{1F448}|\\x{1F447}|\\x{1F446}|\\x{1F445}|\\x{1F3BB}|\\x{1F3B9}|\\x{1F492}|\\x{1F320}|\\x{1F32C}|\\x{1F32B}|\\x{1F32A}|\\x{1F329}|\\x{1F328}|\\x{1F327}|\\x{1F326}|\\x{1F325}|\\x{1F324}|\\x{1F321}|\\x{1F31F}|\\x{1F32E}|\\x{1F31E}|\\x{1F31D}|\\x{1F31C}|\\x{1F31B}|\\x{1F31A}|\\x{1F319}|\\x{1F318}|\\x{1F317}|\\x{1F316}|\\x{1F315}|\\x{1F32D}|\\x{1F32F}|\\x{1F313}|\\x{1F33D}|\\x{1F347}|\\x{1F346}|\\x{1F345}|\\x{1F344}|\\x{1F343}|\\x{1F342}|\\x{1F341}|\\x{1F340}|\\x{1F33F}|\\x{1F33E}|\\x{1F33C}|\\x{1F330}|\\x{1F33B}|\\x{1F33A}|\\x{1F339}|\\x{1F338}|\\x{1F337}|\\x{1F336}|\\x{1F335}|\\x{1F334}|\\x{1F333}|\\x{1F332}|\\x{1F331}|\\x{1F314}|\\x{1F312}|\\x{1F349}|\\x{1F195}|\\x{1F232}|\\x{1F22F}|\\x{1F21A}|\\x{1F202}|\\x{1F201}|\\x{1F19A}|\\x{1F199}|\\x{1F198}|\\x{1F197}|\\x{1F196}|\\x{1F194}|\\x{1F234}|\\x{1F193}|\\x{1F192}|\\x{1F191}|\\x{1F18E}|\\x{1F17F}|\\x{1F17E}|\\x{1F171}|\\x{1F170}|\\x{1F0CF}|\\x{1F004}|\\x{1F233}|\\x{1F235}|\\x{1F311}|\\x{1F306}|\\x{1F310}|\\x{1F30F}|\\x{1F30E}|\\x{1F30D}|\\x{1F30C}|\\x{1F30B}|\\x{1F30A}|\\x{1F309}|\\x{1F308}|\\x{1F307}|\\x{1F305}|\\x{1F236}|\\x{1F304}|\\x{1F303}|\\x{1F302}|\\x{1F301}|\\x{1F300}|\\x{1F251}|\\x{1F250}|\\x{1F23A}|\\x{1F239}|\\x{1F238}|\\x{1F237}|\\x{1F348}|\\x{1F34A}|\\x{1F3B8}|\\x{1F38D}|\\x{1F39A}|\\x{1F399}|\\x{1F397}|\\x{1F396}|\\x{1F393}|\\x{1F392}|\\x{1F391}|\\x{1F390}|\\x{1F38F}|\\x{1F38E}|\\x{1F38C}|\\x{1F39E}|\\x{1F38B}|\\x{1F38A}|\\x{1F389}|\\x{1F388}|\\x{1F387}|\\x{1F386}|\\x{1F385}|\\x{1F384}|\\x{1F383}|\\x{1F382}|\\x{1F39B}|\\x{1F39F}|\\x{1F380}|\\x{1F3AD}|\\x{1F3B7}|\\x{1F3B6}|\\x{1F3B5}|\\x{1F3B4}|\\x{1F3B3}|\\x{1F3B2}|\\x{1F3B1}|\\x{1F3B0}|\\x{1F3AF}|\\x{1F3AE}|\\x{1F3AC}|\\x{1F3A0}|\\x{1F3AB}|\\x{1F3AA}|\\x{1F3A9}|\\x{1F3A8}|\\x{1F3A7}|\\x{1F3A6}|\\x{1F3A5}|\\x{1F3A4}|\\x{1F3A3}|\\x{1F3A2}|\\x{1F3A1}|\\x{1F381}|\\x{1F37F}|\\x{1F34B}|\\x{1F358}|\\x{1F362}|\\x{1F361}|\\x{1F360}|\\x{1F35F}|\\x{1F35E}|\\x{1F35D}|\\x{1F35C}|\\x{1F35B}|\\x{1F35A}|\\x{1F359}|\\x{1F357}|\\x{1F364}|\\x{1F356}|\\x{1F355}|\\x{1F354}|\\x{1F353}|\\x{1F352}|\\x{1F351}|\\x{1F350}|\\x{1F34F}|\\x{1F34E}|\\x{1F34D}|\\x{1F34C}|\\x{1F363}|\\x{1F365}|\\x{1F37E}|\\x{1F373}|\\x{1F37D}|\\x{1F37C}|\\x{1F37B}|\\x{1F37A}|\\x{1F379}|\\x{1F378}|\\x{1F377}|\\x{1F376}|\\x{1F375}|\\x{1F374}|\\x{1F372}|\\x{1F366}|\\x{1F371}|\\x{1F370}|\\x{1F36F}|\\x{1F36E}|\\x{1F36D}|\\x{1F36C}|\\x{1F36B}|\\x{1F36A}|\\x{1F369}|\\x{1F368}|\\x{1F367}|\\x{1F491}|\\x{1F440}|\\x{1F493}|\\x{1F625}|\\x{1F62F}|\\x{1F62E}|\\x{1F62D}|\\x{1F62C}|\\x{1F62B}|\\x{1F62A}|\\x{1F629}|\\x{1F628}|\\x{1F627}|\\x{1F626}|\\x{1F624}|\\x{1F631}|\\x{1F623}|\\x{1F622}|\\x{1F621}|\\x{1F620}|\\x{1F61F}|\\x{1F61E}|\\x{1F61D}|\\x{1F61C}|\\x{1F61B}|\\x{1F61A}|\\x{1F630}|\\x{1F632}|\\x{1F618}|\\x{1F640}|\\x{1F64A}|\\x{1F649}|\\x{1F648}|\\x{1F647}|\\x{1F646}|\\x{1F645}|\\x{1F644}|\\x{1F643}|\\x{1F642}|\\x{1F641}|\\x{1F63F}|\\x{1F633}|\\x{1F63E}|\\x{1F63D}|\\x{1F63C}|\\x{1F63B}|\\x{1F63A}|\\x{1F639}|\\x{1F638}|\\x{1F637}|\\x{1F636}|\\x{1F494}|\\x{1F634}|\\x{1F619}|\\x{1F617}|\\x{1F64C}|\\x{1F5D1}|\\x{1F5F3}|\\x{1F5EF}|\\x{1F5E8}|\\x{1F5E3}|\\x{1F5E1}|\\x{1F5DE}|\\x{1F5DD}|\\x{1F5DC}|\\x{1F5D3}|\\x{1F5D2}|\\x{1F5C4}|\\x{1F5FB}|\\x{1F5C3}|\\x{1F5C2}|\\x{1F5BC}|\\x{1F5B2}|\\x{1F5B1}|\\x{1F5A8}|\\x{1F5A5}|\\x{1F5A4}|\\x{1F596}|\\x{1F595}|\\x{1F5FA}|\\x{1F5FC}|\\x{1F616}|\\x{1F60A}|\\x{1F614}|\\x{1F613}|\\x{1F612}|\\x{1F611}|\\x{1F610}|\\x{1F60F}|\\x{1F60E}|\\x{1F60D}|\\x{1F60C}|\\x{1F60B}|\\x{1F609}|\\x{1F5FD}|\\x{1F608}|\\x{1F607}|\\x{1F606}|\\x{1F605}|\\x{1F604}|\\x{1F603}|\\x{1F602}|\\x{1F601}|\\x{1F600}|\\x{1F5FF}|\\x{1F5FE}|\\x{1F64B}|\\x{1F64D}|\\x{1F58D}|\\x{1F6C0}|\\x{1F6CF}|\\x{1F6CE}|\\x{1F6CD}|\\x{1F6CC}|\\x{1F6CB}|\\x{1F6C5}|\\x{1F6C4}|\\x{1F6C3}|\\x{1F6C2}|\\x{1F6C1}|\\x{1F6BF}|\\x{1F6D1}|\\x{1F6BE}|\\x{1F6BD}|\\x{1F6BC}|\\x{1F6BB}|\\x{1F6BA}|\\x{1F6B9}|\\x{1F6B8}|\\x{1F6B7}|\\x{1F6B6}|\\x{1F6B5}|\\x{1F6D0}|\\x{1F6D2}|\\x{1F6B3}|\\x{1F6F6}|\\x{1F919}|\\x{1F918}|\\x{1F917}|\\x{1F916}|\\x{1F915}|\\x{1F914}|\\x{1F913}|\\x{1F912}|\\x{1F911}|\\x{1F910}|\\x{1F6F5}|\\x{1F6E0}|\\x{1F6F4}|\\x{1F6F3}|\\x{1F6F0}|\\x{1F6EC}|\\x{1F6EB}|\\x{1F6E9}|\\x{1F6E5}|\\x{1F6E4}|\\x{1F6E3}|\\x{1F6E2}|\\x{1F6E1}|\\x{1F6B4}|\\x{1F6B2}|\\x{1F64E}|\\x{1F68B}|\\x{1F695}|\\x{1F694}|\\x{1F693}|\\x{1F692}|\\x{1F691}|\\x{1F690}|\\x{1F68F}|\\x{1F68E}|\\x{1F68D}|\\x{1F68C}|\\x{1F68A}|\\x{1F697}|\\x{1F689}|\\x{1F688}|\\x{1F687}|\\x{1F686}|\\x{1F685}|\\x{1F684}|\\x{1F683}|\\x{1F682}|\\x{1F681}|\\x{1F680}|\\x{1F64F}|\\x{1F696}|\\x{1F698}|\\x{1F6B1}|\\x{1F6A6}|\\x{1F6B0}|\\x{1F6AF}|\\x{1F6AE}|\\x{1F6AD}|\\x{1F6AC}|\\x{1F6AB}|\\x{1F6AA}|\\x{1F6A9}|\\x{1F6A8}|\\x{1F6A7}|\\x{1F6A5}|\\x{1F699}|\\x{1F6A4}|\\x{1F6A3}|\\x{1F6A2}|\\x{1F6A1}|\\x{1F6A0}|\\x{1F69F}|\\x{1F69E}|\\x{1F69D}|\\x{1F69C}|\\x{1F69B}|\\x{1F69A}|\\x{1F590}|\\x{1F635}|\\x{1F58C}|\\x{1F4D6}|\\x{1F4E0}|\\x{1F4DF}|\\x{1F4DE}|\\x{1F4DD}|\\x{1F4DC}|\\x{1F4DB}|\\x{1F4DA}|\\x{1F4D9}|\\x{1F4D8}|\\x{1F4D7}|\\x{1F4D5}|\\x{1F4E2}|\\x{1F4D4}|\\x{1F4D3}|\\x{1F4D2}|\\x{1F4D1}|\\x{1F4D0}|\\x{1F4CF}|\\x{1F4CE}|\\x{1F4CD}|\\x{1F4CC}|\\x{1F4CB}|\\x{1F4E1}|\\x{1F4E3}|\\x{1F4C9}|\\x{1F4F1}|\\x{1F4FB}|\\x{1F4FA}|\\x{1F4F9}|\\x{1F4F8}|\\x{1F4F7}|\\x{1F4F6}|\\x{1F4F5}|\\x{1F4F4}|\\x{1F4F3}|\\x{1F4F2}|\\x{1F4F0}|\\x{1F4E4}|\\x{1F4EF}|\\x{1F4EE}|\\x{1F4ED}|\\x{1F4EC}|\\x{1F4EB}|\\x{1F4EA}|\\x{1F4E9}|\\x{1F4E8}|\\x{1F4E7}|\\x{1F4E6}|\\x{1F4E5}|\\x{1F4CA}|\\x{1F4C8}|\\x{1F4FD}|\\x{1F4A1}|\\x{1F58B}|\\x{1F4AA}|\\x{1F4A9}|\\x{1F4A8}|\\x{1F4A7}|\\x{1F4A6}|\\x{1F4A5}|\\x{1F4A4}|\\x{1F4A3}|\\x{1F4A2}|\\x{1F4A0}|\\x{1F4AD}|\\x{1F49F}|\\x{1F49E}|\\x{1F49D}|\\x{1F49C}|\\x{1F49B}|\\x{1F49A}|\\x{1F499}|\\x{1F498}|\\x{1F497}|\\x{1F496}|\\x{1F495}|\\x{1F4AC}|\\x{1F4AE}|\\x{1F4C7}|\\x{1F4BC}|\\x{1F4C6}|\\x{1F4C5}|\\x{1F4C4}|\\x{1F4C3}|\\x{1F4C2}|\\x{1F4C1}|\\x{1F4C0}|\\x{1F4BF}|\\x{1F4BE}|\\x{1F4BD}|\\x{1F4BB}|\\x{1F4AF}|\\x{1F4BA}|\\x{1F4B9}|\\x{1F4B8}|\\x{1F4B7}|\\x{1F4B6}|\\x{1F4B5}|\\x{1F4B4}|\\x{1F4B3}|\\x{1F4B2}|\\x{1F4B1}|\\x{1F4B0}|\\x{1F4FC}|\\x{1F4AB}|\\x{1F4FF}|\\x{1F54D}|\\x{1F558}|\\x{1F557}|\\x{1F556}|\\x{1F555}|\\x{1F554}|\\x{1F553}|\\x{1F552}|\\x{1F551}|\\x{1F550}|\\x{1F54E}|\\x{1F54C}|\\x{1F55A}|\\x{1F54B}|\\x{1F54A}|\\x{1F549}|\\x{1F53D}|\\x{1F53C}|\\x{1F53B}|\\x{1F53A}|\\x{1F539}|\\x{1F538}|\\x{1F537}|\\x{1F559}|\\x{1F55B}|\\x{1F535}|\\x{1F573}|\\x{1F500}|\\x{1F58A}|\\x{1F587}|\\x{1F57A}|\\x{1F579}|\\x{1F578}|\\x{1F577}|\\x{1F576}|\\x{1F575}|\\x{1F574}|\\x{1F570}|\\x{1F55C}|\\x{1F567}|\\x{1F566}|\\x{1F565}|\\x{1F564}|\\x{1F563}|\\x{1F562}|\\x{1F561}|\\x{1F560}|\\x{1F55F}|\\x{1F55E}|\\x{1F55D}|\\x{1F536}|\\x{1F56F}|\\x{1F534}|\\x{1F50D}|\\x{1F517}|\\x{1F516}|\\x{1F515}|\\x{1F514}|\\x{1F513}|\\x{1F512}|\\x{1F511}|\\x{1F510}|\\x{1F50F}|\\x{1F50E}|\\x{1F50C}|\\x{1F519}|\\x{1F50B}|\\x{1F50A}|\\x{1F509}|\\x{1F508}|\\x{1F506}|\\x{1F505}|\\x{1F504}|\\x{1F503}|\\x{1F502}|\\x{1F533}|\\x{1F501}|\\x{1F518}|\\x{1F507}|\\x{1F51A}|\\x{1F527}|\\x{1F531}|\\x{1F51B}|\\x{1F532}|\\x{1F530}|\\x{1F52F}|\\x{1F52E}|\\x{1F52C}|\\x{1F52B}|\\x{1F52A}|\\x{1F529}|\\x{1F528}|\\x{1F52D}|\\x{1F51D}|\\x{1F51C}|\\x{1F51E}|\\x{1F526}|\\x{1F51F}|\\x{1F521}|\\x{1F520}|\\x{1F522}|\\x{1F523}|\\x{1F524}|\\x{1F525}|\\x{262F}|\\x{2620}|\\x{262E}|\\x{262A}|\\x{2626}|\\x{2623}|\\x{2622}|\\x{2602}|\\x{2614}|\\x{261D}|\\x{2618}|\\x{2615}|\\x{2611}|\\x{260E}|\\x{2604}|\\x{2639}|\\x{2603}|\\x{2638}|\\x{2650}|\\x{263A}|\\x{2651}|\\x{2668}|\\x{2600}|\\x{2666}|\\x{2665}|\\x{2663}|\\x{2660}|\\x{2653}|\\x{2652}|\\x{264F}|\\x{2640}|\\x{264E}|\\x{264D}|\\x{264C}|\\x{264B}|\\x{264A}|\\x{2649}|\\x{2648}|\\x{2642}|\\x{2601}|\\x{2328}|\\x{25FE}|\\x{2197}|\\x{23CF}|\\x{231B}|\\x{231A}|\\x{21AA}|\\x{21A9}|\\x{2199}|\\x{2198}|\\x{2196}|\\x{23EA}|\\x{2195}|\\x{2194}|\\x{2139}|\\x{2122}|\\x{2049}|\\x{203C}|\\x{00AE}|\\x{267F}|\\x{23E9}|\\x{23EB}|\\x{25FD}|\\x{23FA}|\\x{25FC}|\\x{25FB}|\\x{25C0}|\\x{25B6}|\\x{25AB}|\\x{25AA}|\\x{24C2}|\\x{23F9}|\\x{23EC}|\\x{23F8}|\\x{23F3}|\\x{23F2}|\\x{23F1}|\\x{23F0}|\\x{23EF}|\\x{23EE}|\\x{23ED}|\\x{267B}|\\x{2728}|\\x{2692}|\\x{2744}|\\x{2757}|\\x{2755}|\\x{2754}|\\x{2753}|\\x{274E}|\\x{274C}|\\x{2747}|\\x{2734}|\\x{2764}|\\x{2733}|\\x{2721}|\\x{271D}|\\x{2716}|\\x{2714}|\\x{2712}|\\x{270F}|\\x{270D}|\\x{2763}|\\x{2795}|\\x{270B}|\\x{2B1B}|\\x{3299}|\\x{3297}|\\x{303D}|\\x{3030}|\\x{2B55}|\\x{2B50}|\\x{2B1C}|\\x{2B07}|\\x{2796}|\\x{2B06}|\\x{2B05}|\\x{2935}|\\x{2934}|\\x{27BF}|\\x{27B0}|\\x{27A1}|\\x{2797}|\\x{270C}|\\x{270A}|\\x{2693}|\\x{26AA}|\\x{26C5}|\\x{26C4}|\\x{26BE}|\\x{26BD}|\\x{26B1}|\\x{26B0}|\\x{26AB}|\\x{26A1}|\\x{26CE}|\\x{26A0}|\\x{269C}|\\x{269B}|\\x{2699}|\\x{2697}|\\x{2696}|\\x{2695}|\\x{2694}|\\x{26C8}|\\x{26CF}|\\x{2709}|\\x{26F5}|\\x{2708}|\\x{2705}|\\x{2702}|\\x{26FD}|\\x{26FA}|\\x{26F9}|\\x{26F8}|\\x{26F7}|\\x{26F4}|\\x{26D1}|\\x{26F3}|\\x{26F2}|\\x{26F1}|\\x{26F0}|\\x{26EA}|\\x{26E9}|\\x{26D4}|\\x{26D3}|\\x{00A9}/u";
    function entity($matches) { return '&#'.hexdec(bin2hex(mb_convert_encoding("$matches[0]", 'UTF-32', 'UTF-8'))).';'; }
    return preg_replace_callback($emoji_pattern, 'entity', $str);
  }*/

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
      $profileData = array("email"=> $user['email'], "firstname"=> $user['firstname'], "lastname"=> $user['lastname'],"username"=> $user['nickname'],"signature"=> $user['signature'], "birthdate"=> $user['birthdate'],"image"=> $user['image'], "country"=> $user['country']); //complete with birthdate and country
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
  
