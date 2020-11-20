
      <?php
         $dbhost = 'remotemysql.com:3306';
         $dbuser = 'Q2qsa8HqT2';
         $dbpass = 'vkN1eNSWhe';
         $conn = mysqli_connect($dbhost, $dbuser, $dbpass);
         
         if(! $conn ) {
            die('Could not connect: ' . mysqli_error());
         }
         echo 'Successfully connected';
         mysqli_close($conn);
      ?>

