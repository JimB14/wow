<?php


function paypal_items() {

	// Create cart array to store items from $_SESSION['cart'] and products table 
	$paypal_items = array();

	// Initialize variable with a value = 0 to store cart total
	$total = 0;
	$i = 0;

	 // Check for matching IDs in SESSION['cart'] and $parts array
	foreach($_SESSION['cart'] as $item){
	    foreach($products as $product){                      
	        if($product['id'] == $item['id']){
	        	$i++;

	            // Create new array with IDs from $_SESSION['cart'] that match IDs from products table
	            $new_array = array(     
	                'id' => $product['id'].'_'.$i,
	                'name' => $product['name'].'_'.$i,
	                'price' => $product['price'].'_'.$i,
	                'quantity' => $item['quantity'].'_'.$i  // this field (note $item instead of $row) is from $_SESSION['cart'] array
	            );

	            // Add data from $new_array array to $cart array with key = ID
	            $paypal_items[$item['id']] = $new_array;
	            
	            $total += $new_array['price'] * $new_array['quantity'];
	            break;
	        }
	    }
	}


}


?>
