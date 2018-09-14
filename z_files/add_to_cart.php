<?php
// connect to database
include 'includes/dbconnect.php';
 
// get product details and save in new variables
if(isset($_GET['id'])) {
	$id = htmlspecialchars($_GET['id']);
}
else{
	echo 'id not set';
	exit();
}
if (isset($_GET['name'])) {
	$name = htmlspecialchars($_GET['name']);
}
else{
	echo 'name not set';
	exit();
}
if (isset($_GET['quantity'])) {
	$quantity = htmlspecialchars($_GET['quantity']);
}
else{
	echo 'quantity not set';
	exit();
}

	
$user_id = 1;
$created=date('Y-m-d H:i:s');

echo $id . '<br>';
echo $name . '<br>';
echo $quantity . '<br>';
echo $user_id . '<br>';
echo $created . '<br>';


// using ternary operator  
/*
$id = isset($_GET['id']) ?  $_GET['id'] : die;
$name = isset($_GET['name']) ?  $_GET['name'] : die;
$quantity  = isset($_GET['quantity']) ?  $_GET['quantity'] : die;
$user_id = 1;
$created=date('Y-m-d H:i:s');
*/
 
// insert query
$query = "INSERT INTO cart_items SET
        product_id = :product_id, 
        quantity = :quantity, 
        user_id = :user_id, 
        created = :created";
 
// prepare query
$stmt = $db->prepare($query);
 
// bind values
$stmt->bindParam(':product_id', $id);
$stmt->bindParam(':quantity', $quantity);
$stmt->bindParam(':user_id', $user_id);
$stmt->bindParam(':created', $created);
 
// if database insert succeeded
if($stmt->execute()){
    $success_message = "$name added to cart.";
    
    //header('Location: index.php?goto=store&action=added&id=' . $id . '&name=' . $name);
}
 
// if database insert failed
else{
     $failure_message = "Unable to add item to cart. Please try again.";
    //header('Location: index.php?goto=store&action=failed&id=' . $id . '&name=' . $name);
}
 
?>