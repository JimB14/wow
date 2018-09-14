<?php

function userIsLoggedIn() {

    if (isset($_POST['action']) && $_POST['action'] === 'login') {

        if (!isset($_POST['email']) || $_POST['email'] === '' || !isset($_POST['password']) or $_POST['password'] === '') {

            $GLOBALS['loginError'] = 'Please fill in both fields';
            return FALSE;
        }
        
        // Sanitize user password and store in $password variable
        $password = htmlspecialchars($_POST['password']);

        // Sanitize user email and store in $email variable
        $email = htmlspecialchars($_POST['email']);
        
        /*
          // Test to see login $variable values
          echo '$password: ' . $password . '<br>';
          echo '$email: ' . $_POST['email'] . '<br>';
         */

        // Check with boolean function if user is in database and execute if / else
        if (databaseContainsUser($email, $password)) {

            session_start();
            $_SESSION['loggedIn'] = TRUE;
            $_SESSION['email'] = $email;
            $_SESSION['password'] = $password;
            return TRUE;
        } 
        else {
            session_start();
            unset($_SESSION['loggedIn']);
            unset($_SESSION['email']);
            unset($_SESSION['password']);
            unset($_SESSION['name']);
            $GLOBALS['loginError'] = 'The specified email address or password was incorrect.';
            notify_failed_login();
            return FALSE;
        }
    }

    // - - - - - - - - - -  Log out functionality  - - - - - - - - - - - - //
    if (isset($_GET['goto']) && $_GET['goto'] === 'logout') {
        
        // Start session to retrieve $_SESSION['name'] of user logged in
        session_start();       
        
        // Store user name in GLOBALS variable for use in notify_logout()
        $GLOBALS['username'] = $_SESSION['name'];         
        
        // Send logout email
        notify_logout();       
        
        session_start();
        unset($_SESSION['loggedIn']);
        unset($_SESSION['email']);
        unset($_SESSION['password']);
        unset($_SESSION['name']);       
        header('Location: ' . '..');
        exit();
    }

    // If already logged in, use SESSION stored $email and $password
    session_start();
    if (isset($_SESSION['loggedIn'])) {
        return databaseContainsUser($_SESSION['email'], $_SESSION['password']);
    }         
}

// End userIsLoggedIn()


/* - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -  */

// $email and $user_password from login form
function databaseContainsUser($email, $user_password) {

    /*
      // Test
      echo 'from function - $email => ' . $_POST['email'] . '<br>';
      echo 'from function - $user_password => ' . $user_password . '<br>';
      echo '$email variable from  databaseContainsUser function:  => ' . $email . '<br>';
     */

    include 'includes/dbconnect.php';
    
    // Assign queried table name to variable
    $table = 'user';

    try {
        $sql = "SELECT * FROM $table
                WHERE email = :email";
        $s = $db->prepare($sql);
        $s->bindValue(':email', $email);
        $s->execute();

        // store row results in $result
        $result = $s->fetch(PDO::FETCH_ASSOC);

        // store name and id in session variables
        $_SESSION['name'] = $result['name'];
        $_SESSION['id'] = $result['id']; // user ID from user table         
    } 
    catch (PDOException $e) {
        $error = 'Error searching for user.' . $e->getMessage();
        include 'error.html.php';
        exit();
    }

    /*
      // Test
      echo 'after function - $user_password => ' . $user_password . '<br>';
      echo '$result[\'password\']: ' . $result['password']. '<br>';
     */

    if (count($result) > 0 && password_verify($user_password, $result['password'])) {
        return TRUE;
    } else {
        return FALSE;
    }
}

// End databaseContainsUser()


/*
  function sanitize($data){
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
  }
  /* - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - */

function notify_login($email) {

    include 'includes/dbconnect.php';

    try {
        $sql = "SELECT name FROM user
                WHERE email = :email";
        $s = $db->prepare($sql);
        $s->bindValue(':email', $_SESSION['email']);
        $s->execute();
    } 
    catch (PDOException $e) {
        $error = 'Error fetching user data from database.' . $e->getMessage();
        include 'error.html.php';
        exit();
    }

    $result = $s->fetch(PDO::FETCH_ASSOC);
    $name = $result['name'];

    // Prepare mail
    // Recipients
    $jim = 'jim.burns14@gmail.com';
    $client= 'womenofworship3@gmail.com';
    
    // To
    $to = $client;

    // From
    $from = 'LogIn@mail.com';

    // Subject
    $subject = 'LogIn notice';

    // Message
    $message = '
        <html>
        <body>
        <p>Email notification: User  <span style="color:#0000ff"> "' . $name . '"</span>  has logged on @ http://'. $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'] . '.</p>  
        </body>
        </html>';

    // To send HTML mail, the Content-type header must be set
    $headers = 'MIME-Version: 1.0' . "\r\n";
    $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

    // Additional headers
    $headers .= 'To: ' . "\r\n";
    $headers .= 'From: ' . $from . "\r\n";
    $headers .= 'Cc: ' . "\r\n";
    $headers .= 'Bcc: ' . $jim . "\r\n";

    // Mail it
    mail($to, $subject, $message, $headers);
}

/* - - - - - - - - - - - - - - - - - - - - - - - - */
function notify_logout() {
    
    // Assign value of logged in user to variable (for email below)
    if(isset($GLOBALS['username'])){
        $name = $GLOBALS['username'];
    } else {
        $name = $_SESSION['name'];
    }
    
    /* Test 
    echo '$name = ' . $name;
    exit();
    */
    
    // Prepare mail
 
    // Recipients
    $jim = 'jim.burns14@gmail.com';
    $client= 'womenofworship3@gmail.com';
    
    // To
    $to = $client;

    // From
    $from = 'LogOut@mail.com';

    // Subject
    $subject = 'LogOut notice';

    // Message
    $message = '
        <html>
        <body>
        <p>Email notification: User  <span style="color:#0000ff"> "' . $name . '"</span>  has logged out @ http://'. $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'] . '.</p>  
        </body>
        </html>';

    // To send HTML mail, the Content-type header must be set
    $headers = 'MIME-Version: 1.0' . "\r\n";
    $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

    // Additional headers
    $headers .= 'To: ' . "\r\n";
    $headers .= 'From: ' . $from . "\r\n";
    $headers .= 'Cc: ' . "\r\n";
    $headers .= 'Bcc: ' . $jim . "\r\n";

    // Mail it
    mail($to, $subject, $message, $headers);
}

/* - - - - - - - - - - - - - - - - - - - - - - - - */
function notify_failed_login() {
    
    // Prepare mail
    // Recipients
    $jim = 'jim.burns14@gmail.com';
    $client= 'womenofworship3@gmail.com';
    
    // To
    $to = $client;

    // From
    $from = 'LogInAttempt@mail.com';

    // Subject
    $subject = 'Failed login';

    // Message
    $message = '
        <html>
        <body>
        <p>Email notification: Failed attempt to log on @ http://'. $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'] . '</p> 
        </body>
        </html>';

    // To send HTML mail, the Content-type header must be set
    $headers = 'MIME-Version: 1.0' . "\r\n";
    $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

    // Additional headers
    $headers .= 'To: ' . "\r\n";
    $headers .= 'From: ' . $from . "\r\n";
    $headers .= 'Cc: ' . "\r\n";
    $headers .= 'Bcc: ' . $jim . "\r\n";

    // Mail it
    mail($to, $subject, $message, $headers); 
}