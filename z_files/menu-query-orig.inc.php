<?php
    // Connect to database
    include 'includes/dbconnect.php';    

    // Create variables for use in SQL
    $ministries = 'ministries';
    $about = 'about';
    
    // Get items for Ministries menu 
    try{      
        $sql2 = "SELECT page_id, page_name, menu_id 
                FROM pages
                WHERE menu_id = '$ministries'";
         $s2 = $db->prepare($sql2);
         $s2->execute(); 

         while($row = $s2->fetch(PDO::FETCH_ASSOC)){
             $ministries_menu[] = array(
                 'page_id' => $row['page_id'],
                 'page_name' => $row['page_name'],
                 'menu_id' => $row['menu_id']
             );
         }
      
     
        // Get items for About menu drop-down    
        $sql3 = "SELECT page_id, page_name, menu_id
                FROM pages
                WHERE menu_id = '$about'";
         $s3 = $db->prepare($sql3);
         $s3->execute(); 

         while($row = $s3->fetch(PDO::FETCH_ASSOC)){
             $about_menu[] = array(
                 'page_id' => $row['page_id'],
                 'page_name' => $row['page_name'],
                 'menu_id' => $row['menu_id']
             );
         }       
     } 
     catch (PDOException $e) {
         $errMsg  = 'Error fetching data for menus from database: ' . $e->getMessage();
         include 'includes/error.html.php';
         exit();
     }