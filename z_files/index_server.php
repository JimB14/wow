<?php

/*  - - - - - - - -    User clicks "Store"   - - - - - -- - - - - - - -  */
if(isset($_GET['goto']) && $_GET['goto'] === 'store'){

    session_start();

    // Check if cart exists; if not, initialize SESSION cart array
    if(!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = array();
    }    
    include 'includes/dbconnect.php';
    $table = 'products';
    
    try{    
        $sql = "SELECT * FROM $table ORDER BY category_id";  // if inventory field is used, add "WHERE inventory > 0" to not display items that cannot be shipped
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

        $product_count = count($products);
    }
    catch(PDOException $e){
        $errMsg = 'Error fetching data: ' . $e->getMessage();
        include 'error.html.php';
        exit();
    }
    
    
    
    try{    
        $sql2 = "SELECT * FROM category";
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
    
    
    
    try{
        // select products in the cart
        $sql = "SELECT p.id, p.name, p.thumbnail, p.price, ci.quantity, ci.quantity * p.price AS subtotal  
                FROM cart_items ci
                INNER JOIN products p
                ON p.id = ci.product_id";
        $s = $db->prepare($sql);
        $s->execute();       
    } 
    catch (PDOException $e) {
        $errMsg = 'Error fetching cart data: ' . $e->getMessage();
        include 'includes/error.html.php';
        exit();
    }
    
    // count number of rows returned
    $num = $s->rowCount();
    
    if ($num > 0) {
        
        while($row = $s->fetch(PDO::FETCH_ASSOC)){
            $cart_items[] = array(
                'id' => $row['id'],
                'thumbnail' => $row['thumbnail'],
                'name' => $row['name'],
                'price' => $row['price'],
                'quantity' => $row['quantity'],
                'subtotal' => $row['price'] * $row['quantity'],
                'total' => ''
            );   
        } 
        
            // Loop through array for total
            $total = '';
            foreach($cart_items as $cart){
            $total += $cart['quantity'] * $cart['price'];
        }
    }   
    include 'products.html.php';
    exit();  
}


/* - - - - - - - - -  Filter results - - - - - - - - - - - - - - - - - - -   */

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
    
        include 'includes/dbconnect.php';
        $table = 'products';

        try{    
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

            $product_count = count($products);
        }
        catch(PDOException $e){
            $errMsg = 'Error fetching data: ' . $e->getMessage();
            include 'includes/error.html.php';
            exit();
        }


        try{    
            $sql = "SELECT * FROM category";
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
}

/* - - - - - - - - - - - - Add to Cart - - - - - - - -  - - - - - - - - - -   */

if(isset($_GET['action']) && $_GET['action'] === 'add_to_cart'){
    
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

    // using ternary operator  
    /*
    $id = isset($_GET['id']) ?  $_GET['id'] : die;
    $name = isset($_GET['name']) ?  $_GET['name'] : die;
    $quantity  = isset($_GET['quantity']) ?  $_GET['quantity'] : die;
    $user_id = 1;
    $created=date('Y-m-d H:i:s');
    */

    // Check if item already in cart_items
    try {
        $sql = "SELECT * FROM cart_items
                WHERE product_id = :product_id";
        $s = $db->prepare($sql);
        $s->bindValue(':product_id', $id);
        $s->execute();
    }
    catch (PDOException $e) {
        $errMsg =  'Error fetching data: ' . $e->getMessage();
        include 'includes/error.html.php';
        exit();
    }

    $rows = $s->fetchAll();
    $num = count($rows);

    if($num > 0 ) {
            $errMsg = 'Item already in cart.';
            include 'includes/error.html.php';
            exit();
    }
    else {

        try{
            // insert item into cart_items table
            $sql = "INSERT INTO cart_items SET
                    product_id = :product_id, 
                    quantity = :quantity, 
                    user_id = :user_id, 
                    created = :created";
            $s = $db->prepare($sql);
            $s->bindValue(':product_id', $id);
            $s->bindValue(':quantity', $quantity);
            $s->bindValue(':user_id', $user_id);
            $s->bindValue(':created', $created);

            // if database insert succeeded
            if($s->execute()){
                $success_message = "$quantity $name item successfully added to your shopping cart!";  
            }
            else {
                $failure_message = "Unable to add item to shopping cart. Please try again.";
            }
            
        } 
        catch (PDOException $e) {
            $errMsg = ' Error inserting data into database: ' . $e->getMessage();
            include 'includes/error.html.php';
            exit();
        }

    

        // query DB to retrieve products
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
        

    
        try {
            $sql = "SELECT * FROM cart_items";
            $s = $db->prepare($sql);
            $s->execute();
            
            $rows = $s->fetchAll();
            $num = count($rows);
        } 
        catch (PDOException $e) {
            $errMsg = 'Error retrieving data: ' . $e->getMessage();
            include 'includes/error.html.php';
            exit();
        }

    }

    include 'products.html.php';
    exit();
}


/* - - - - - - - - - - - - Go to Cart - - - - - - - - - - - - - - - - - - - -   */
if(isset($_GET['goto']) && $_GET['goto'] === 'cart'){

    if(!isset($_SESSION)) {session_start();}
    
    include 'includes/dbconnect.php';
    
    try{
        // select products in the cart
        $sql = "SELECT p.id, p.name, p.thumbnail, p.price, ci.quantity, ci.quantity * p.price AS subtotal  
                FROM cart_items ci
                INNER JOIN products p
                ON p.id = ci.product_id";
        $s = $db->prepare($sql);
        $s->execute();       
    } 
    catch (PDOException $e) {
        $errMsg = 'Error fetching cart data: ' . $e->getMessage();
        include 'includes/error.html.php';
        exit();
    }
    
    // count number of rows returned
    $num = $s->rowCount();
    
    if ($num > 0) {
        
        while($row = $s->fetch(PDO::FETCH_ASSOC)){
            $cart_items[] = array(
                'id' => $row['id'],
                'thumbnail' => $row['thumbnail'],
                'name' => $row['name'],
                'price' => $row['price'],
                'quantity' => $row['quantity'],
                'subtotal' => $row['price'] * $row['quantity'],
                'total' => ''
            );   
        } 
        
        // Loop through array for total
        $total = '';
        foreach($cart_items as $cart){
            $total += $cart['quantity'] * $cart['price'];
        }
    }
    else {
        $errMsg = 'Your Shopping Cart is empty. Click "Store" in the menu above to shop.';
        include 'includes/error.html.php';
        exit();
    }
    
    include 'cart.html.php';
    exit();
}


/* - - - - - - - - - - - - Delete item from cart - - - - - - - - - - - - - - - -   */
if(isset($_GET['action']) && $_GET['action'] === 'delete_item'){
    
    $id = htmlspecialchars($_GET['id']);
    $name = htmlspecialchars($_GET['name']);
    $table = 'cart_items';
    
    //echo '$id = ' . $id . '<br>';
    //echo '$name =' . $name . '<br>';
    
    include 'includes/dbconnect.php';
    
    try {
        $sql = "DELETE FROM $table
                WHERE product_id = :id";
        $s = $db->prepare($sql);
        $s->bindValue(':id', $id);
        if($s->execute()){
            $success_delete_message = 'Item deleted successfully!';
        }
        else {
            $failure_delete_message = 'Unable to delete item.';
            exit();
        }       
    } 
    catch (PDOException $e) {
        $errMsg = 'Error deleting item: ' . $e->getMessage();
        include 'includes/error.html.php';
        exit();       
    }
    
    // query database and display update cart contents
    try{
        // select products in the cart
        $sql = "SELECT p.id, p.name, p.thumbnail, p.price, ci.quantity, ci.quantity * p.price AS subtotal  
                FROM cart_items ci
                INNER JOIN products p
                ON p.id = ci.product_id";
        $s = $db->prepare($sql);
        $s->execute();       
    } 
    catch (PDOException $e) {
        $errMsg = 'Error fetching cart data: ' . $e->getMessage();
        include 'includes/error.html.php';
        exit();
    }
    
    // count number of rows returned
    $num = $s->rowCount();
    
    if ($num > 0) {
        
        while($row = $s->fetch(PDO::FETCH_ASSOC)){
            $cart_items[] = array(
                'id' => $row['id'],
                'thumbnail' => $row['thumbnail'],
                'name' => $row['name'],
                'price' => $row['price'],
                'quantity' => $row['quantity'],
                'subtotal' => $row['price'] * $row['quantity']
            );
        }
        
        // Loop through array for total
        $total = '';
        foreach($cart_items as $cart){
            $total += $cart['quantity'] * $cart['price'];
        }
    }
    else {
        header('Location: .');
        exit();
    }
    
    include 'cart.html.php';
    exit();
}



/* - - - - - - - - - - - - Update item quantity in cart  - - - - - - -- - - - - - -   */
if(isset($_GET['action']) && $_GET['action'] === 'update_quantity'){
    
    $new_quantity = htmlspecialchars($_GET['new_quantity']);
    $product_id = htmlspecialchars($_GET['product_id']);
    $name = htmlspecialchars($_GET['product_name']);
    
    include 'includes/dbconnect.php';
    $table = 'cart_items';
    
    try{
        $sql = "UPDATE $table SET
                quantity = :quantity
                WHERE product_id = :product_id";
        $s = $db->prepare($sql);
        $s->bindValue(':quantity', $new_quantity);
        $s->bindValue(':product_id', $product_id);
        if($s->execute()){
            $success_update_quantity_message = 'Item quantity updated successfully!';
        }
        else {
            $failure_update_quantity_message = 'Unable to update quantity.';
            exit();
        }
    } 
    catch (PDOException $e) {
        $errMsg = 'Error updating quantity: ' . $e->getMessage();
        include 'includes/error.html.php';
        exit();
    }
    
    
    // query database and display update cart contents
    try{
        // select products in the cart
        $sql = "SELECT p.id, p.name, p.thumbnail, p.price, ci.quantity, ci.quantity * p.price AS subtotal  
                FROM cart_items ci
                INNER JOIN products p
                ON p.id = ci.product_id";
        $s = $db->prepare($sql);
        $s->execute();       
    } 
    catch (PDOException $e) {
        $errMsg = 'Error fetching cart data: ' . $e->getMessage();
        include 'includes/error.html.php';
        exit();
    }
    
    // count number of rows returned
    $num = $s->rowCount();
    
    if ($num > 0) {
        
        while($row = $s->fetch(PDO::FETCH_ASSOC)){
            $cart_items[] = array(
                'id' => $row['id'],
                'thumbnail' => $row['thumbnail'],
                'name' => $row['name'],
                'price' => $row['price'],
                'quantity' => $row['quantity'],
                'subtotal' => $row['price'] * $row['quantity']
            );
        }
        
        // Loop through array for total
        $total = '';
        foreach($cart_items as $cart){
            $total += $cart['quantity'] * $cart['price'];
        }
    }
    else {
        $errMsg = 'Your Shopping Cart is empty';
        exit();
    }
       
    include 'cart.html.php';
    exit();
}



/* - - - - - - - - - - - -  EMPTY CART  - - - - -  - - - - - - - - - - -   */
if(isset($_GET['action']) && $_GET['action'] === 'empty_cart'){
    
    $table = 'cart_items';
    include 'includes/dbconnect.php';
    
    try{
        $sql = "DELETE FROM $table WHERE id >= 1";
        $s = $db->prepare($sql);
        $s->execute();
        
    } 
    catch (PDOException $e) {
        $errMsg = 'Error deleting cart contents: ' . $e->getMessage();
        include 'includes/error.html.php';
        exit();
    } 
    
    header('Location: .');
    exit();
}



/*----------- Default  ------------------*/

if(!isset($num)){
    
    include 'main.html.php';
    
}
else {
    
    include 'includes/dbconnect.php';

        try{
            // select products in the cart
            $sql = "SELECT p.id, p.name, p.thumbnail, p.price, ci.quantity, ci.quantity * p.price AS subtotal  
                    FROM cart_items ci
                    INNER JOIN products p
                    ON p.id = ci.product_id";
            $s = $db->prepare($sql);
            $s->execute();       
        } 
        catch (PDOException $e) {
            $errMsg = 'Error fetching cart data: ' . $e->getMessage();
            include 'includes/error.html.php';
            exit();
        }

        // count number of rows returned
        $num = $s->rowCount();

        if ($num > 0) {

            while($row = $s->fetch(PDO::FETCH_ASSOC)){
                $cart_items[] = array(
                    'id' => $row['id'],
                    'thumbnail' => $row['thumbnail'],
                    'name' => $row['name'],
                    'price' => $row['price'],
                    'quantity' => $row['quantity'],
                    'subtotal' => $row['price'] * $row['quantity'],
                    'total' => ''
                );   
            } 

            // Loop through array for total
            $total = '';
            foreach($cart_items as $cart){
                $total += $cart['quantity'] * $cart['price'];
            }
        }        
        
        include 'main.html.php';
        exit();    
}