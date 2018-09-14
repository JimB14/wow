<?php


/*  - - - - - - - -    User clicks "Store"   - - - - - -- - - - - - - -  */

// Retrieve products and categories from database tables and display @products.html.php
if(isset($_GET['goto']) && $_GET['goto'] === 'store'){

    session_start();

    // Check if cart exists; if not, initialize SESSION cart array
    if(!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = array();
    }
    
    // Connect to database
    include 'includes/dbconnect.php';

    // Assign queried table to variable
    $table = 'products';
    
    try {    
        $sql = "SELECT * FROM $table ORDER BY category_id";  // if inventory field is used, add "WHERE inventory > 0" to not display items that cannot be shipped
        $s = $db->prepare($sql);
        $s->execute();

        // Store results in $products array
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

        // Get count of products in array
        $product_count = count($products);
    }
    catch(PDOException $e) {
        $errMsg = 'Error fetching data: ' . $e->getMessage();
        include 'error.html.php';
        exit();
    }
    
    

    // Assign queried table to variable
    $table2 = 'category';

    // Retrieve categories
    try {    
        $sql2 = "SELECT * FROM $table2";
        $s2 = $db->prepare($sql);
        $s2->execute();

        while($row = $s2->fetch(PDO::FETCH_ASSOC)){
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
       
    // Display retrieved data @products.html.php
    include 'products.html.php';
    exit();  
}


/* - - - - - - - - -  Filter results to display by product category  - - - - - - - - - - - - - - - - - - -   */

if(isset($_POST['action']) && $_POST['action'] === 'sort_products'){
    
    // Cut name from end of string
    $category_name = substr($_POST['category'], 1); 
    
    // Cut id from beginning of string
    $category_id = substr($_POST['category'], 0, 1 );
    
    // Refresh same page if "all" selected ('a' after substr above)
    if(isset($category_id) && $category_id === 'a'){
        header('Location: index.php?goto=store');
        exit();
    }
    else {
        
        // Connect to database
        include 'includes/dbconnect.php';

        // Assign queried table name to variable
        $table = 'products';

        // Query products table for products in selected category
        try {    
            $sql = "SELECT * FROM $table 
                    WHERE category_id = :category_id";
            $s = $db->prepare($sql);
            $s->bindValue(':category_id', $category_id);
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

            // Get count of products in this category
            $product_count = count($products);
        }
        catch(PDOException $e) {
            $errMsg = 'Error fetching data: ' . $e->getMessage();
            include 'includes/error.html.php';
            exit();
        }


        // Query category table for categories
        try{    
            $sql = "SELECT * FROM category";
            $s = $db->prepare($sql);
            $s->execute();

            // Store categories in array
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

        // Display retrieved data @products.html.php
        include 'products.html.php';
        exit();
    }
}








/* - - - - - - - - - - - - Add to Cart - - - - - - - -  - - - - - - - - - -   */

if(isset($_GET['action']) && $_GET['action'] === 'add_to_cart'){

    // Check if cart exists; if not, initialize SESSION cart array
    if(!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = array();
    }

    // Get id of selection and append to the end of SESSION cart array
    if(isset($_GET['id'])) {

        // sanitize URL
        $id = htmlspecialchars($_GET['id']);

        // Checks if item is already in array, if TRUE display error message. Resource: http://php.net/manual/en/function.array-key-exists.php
        if(array_key_exists($id, $_SESSION['cart'])){
            $errMsg = 'Item already in cart!';
            include 'includes/error.html.php';
            exit();
        }   

        // If array_key_exists returns FALSE, item not in array, so add item to array
        else {
            // Add item to the end of the $_SESSION['cart'] array; refresh same page
            $_SESSION['cart'][] = $id;

            // Create success message to display @cart.html.php
            $success_message = 'Item successfully added to cart!';
            header('Location: ?goto=cart');
            exit();
        }
    }
}

    


/* - - - - - - - - - - - - - - - User clicks Cart icon - - - - - - - - - - - - - - - - - - - -   */

if(isset($_GET['goto']) && $_GET['goto'] === 'cart'){

    // Create array to store items from $_SESSION['cart'] 
    $cart = array();

    // Initialize variable with a value = 0 to store cart total
    $total = 0;

    // Loop through $_SESSION['cart'] array (contains user selections) as $id: results = $id['id'], $id['category_id'], $id['category_name'], etc.
    foreach ($_SESSION['cart'] as $id) {

        // Loop through $products array (contains all products from products table) as $product to get $product['id']
        foreach ($products as $product) {
            if($product['id'] == $id){
                $cart = $product[];
                $total += $product['price'];
                break;
            }
        }

    }

    include 'cart.html.php';
    exit();
}






/* - - - - - - - - - - - - Update item quantity in cart  - - - - - - -- - - - - - -   */

if(isset($_GET['action']) && $_GET['action'] === 'update_quantity'){
    
    $new_quantity = htmlspecialchars($_GET['new_quantity']);
    $product_id = htmlspecialchars($_GET['product_id']);
    $name = htmlspecialchars($_GET['product_name']);
    
    
    
    
       
    include 'cart.html.php';
    exit();
}



/* - - - - - - - - - - - - DELETE item from cart - - - - - - - - - - - - - - - -   */

if(isset($_GET['action']) && $_GET['action'] === 'delete_item'){
    
    $id = htmlspecialchars($_GET['id']);

    // Empty $_SESSION['cart'] array
    unset($_SESSION['cart'][$id]); 
    
    header('Location: ?goto=cart');
    exit();
}



/* - - - - - - - - - - - -  EMPTY CART  - - - - -  - - - - - - - - - - -   */

if(isset($_GET['action']) && $_GET['action'] === 'empty_cart'){
    
    // Empty $_SESSION['cart'] array
    unset($_SESSION['cart']); 
    
    header('Location: ?goto=cart');
    exit();
}



/*----------- Default  ------------------*/
             
include 'main.html.php';