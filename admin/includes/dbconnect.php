<?php

//DB configuration Constants - published website
/*
$dsn = 'mysql:host=localhost;dbname=pamska5_wow';
$username = 'pamska5_jburns14';
$password = 'Hopehope1!';
*/

/*
$dsn = 'mysql:host=womenofworshipuscom.ipagemysql.com;dbname=wow';
$username = 'jburns814';
$password = 'Hopehope1!';
*/
 

//DB configuration Constants - local
$dsn = 'mysql:host=127.0.0.1;dbname=wow';
$username = 'root';
$password = '';
 

// PDO Database Connection
try {  
    $db = new PDO($dsn, $username, $password); 
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    //echo "<p style='color:red;'>Connected to database!</p>";     
} 
catch(PDOException $e) {
    $errMsg = 'Unable to connect to the database. Try again later. ' . $e->getMessage();
    include 'error.html.php';
exit();
}