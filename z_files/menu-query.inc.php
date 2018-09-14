<?php

// Connect to database
include 'includes/dbconnect.php';

// Assign queried tabel name to variable
$table = 'pages';

try {
   
    $sql = "SELECT * FROM $table
            WHERE menu_id = 'about'";
    $s = $db->prepare($sql);
    $s->execute();
    
    while($row = $s->fetch(PDO::FETCH_ASSOC)){
        $about_menu[] = array(
            'page_id' => $row['page_id'],
            'page_name' => $row['page_name'],
            'menu_id' => $row['menu_id']
        );
    }
    
    
    $sql = "SELECT * FROM $table
            WHERE menu_id = 'ministries'";
    $s = $db->prepare($sql);
    $s->execute();
    
    while($row = $s->fetch(PDO::FETCH_ASSOC)){
        $ministries_menu[] = array(
            'page_id' => $row['page_id'],
            'page_name' => $row['page_name'],
            'menu_id' => $row['menu_id']
        );
    }
    
    $sql = "SELECT * FROM menu";
    $s = $db->prepare($sql);
    $s->execute();
    
    while($row = $s->fetch(PDO::FETCH_ASSOC)){
        $menu[] = array(
            'menu_id' => $row['menu_id'],
            'menu_name' => $row['menu_name']
        );
    }
            
} 
catch (PDOException $e) {
    $errMsg = 'Error fetching menu data from database: ' . $e->getMessage();
    include 'includes/error.html.php';
    exit();
}