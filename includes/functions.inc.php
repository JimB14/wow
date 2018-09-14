<?php

function display_products(){
    
    include 'dbconnect.php';
    $table = 'products';
    
    try{    
        $sql = "SELECT * FROM $table ORDER BY category_id";
        $s = $db->prepare($sql);
        $s->execute();

        while($row = $s->fetch(PDO::FETCH_ASSOC)){
            $products[] = array(
                'id' => $row['id'],
                'category_id' => $row['category_id'],
                'category_name' => $row['category_name'],
                'name' => $row['name'],
                'description' => $row['description'],
                'size' => $row['size'],
                'thumbnail'  => $row['thumbnail'],
                'image'  => $row['image'],
                'price' => $row['price'],
                'inventory' => $row['inventory']
            );
        }
    }
    catch(PDOException $e){
        $errMsg = 'Error fetching data: ' . $e->getMessage();
        include 'error.html.php';
        exit();
    } 
    
    $table = 'category';
    
    try{    
        $sql = "SELECT * FROM $table";
        $s = $db->prepare($sql);
        $s->execute();

        while($row = $s->fetch(PDO::FETCH_ASSOC)){
            $categories[] = array(
                'id' => $row['id'],
                'name' => $row['name'],
            );
        }
    }
    catch(PDOException $e){
        $errMsg = 'Error fetching data: ' . $e->getMessage();
        include 'error.html.php';
        exit();
    }
    
    include 'products.html.php';
    exit();
}