<?php

session_start();

// Check if cart exists; if not, initialize SESSION cart array
if(!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = array();
}

// If cart has content, count elements to display in navbar
if (isset($_SESSION['cart'])) {

    $session_cart_count = count($_SESSION['cart']);
}

/*  - - - - - - - - - - - - - - -    User clicks Page Menu Items   - - - - - - - - - - - - - - - -  */
//if(isset($_GET['menu_id']) && $_GET['menu_id'] === '6'){
if(isset($_GET['get_page']) && $_GET['id'] === '6'){

    header("Location: contact.php");
    exit();
}


/*  - - - - - - - - - - - - - - -    User clicks Page Menu Items   - - - - - - - - - - - - - - - -  */
//if(isset($_GET['menu_id']) && $_GET['menu_id'] === '8'){
if(isset($_GET['get_page']) && $_GET['id'] === '8'){

    header("Location: video.php");
    exit();
}


/*  - - - - - - - - - - - - - - -    User clicks "Shop"   - - - - - - - - - - - - - - - -  */

// Retrieve products and categories from database tables and display @products.html.php
if(isset($_GET['get_page']) && $_GET['id'] === '7'){

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
                'inscription' => $row['inscription'],
                'description' => $row['description'],
                'size' => $row['size'],
                'image'  => $row['image'],
                'price' => $row['price'],
                'quantity' => $row['quantity'],
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


/* - - - - - - - - -  Filter results to display by product category  - - - - - - - - - - - - - -   */

if(isset($_POST['action']) && $_POST['action'] === 'sort_products'){

    // Cut name from end of string
    $category_name = substr($_POST['category'], 1);

    // Cut id from beginning of string
    $category_id = substr($_POST['category'], 0, 1 );

    // Refresh same page if "all" selected ('a' after substr above)
    if(isset($category_id) && $category_id === 'a'){
        header('Location: index.php?get_page=shop&id=7');
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
                    'inscription' => $row['inscription'],
                    'description' => $row['description'],
                    'size' => $row['size'],
                    'image'  => $row['image'],
                    'price' => $row['price'],
                    'quantity' => $row['quantity'],
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



/*  - - - - - - - -    User clicks "Gallery"   - - - - - -- - - - - - - -  */

if(isset($_GET['get_page']) && $_GET['id'] === '3'){

    // Assign queried table name to variable
    $table = 'gallery';

    // Connect to database
    include 'includes/dbconnect.php';

    try {
        $sql = "SELECT * FROM $table ORDER BY upload_date DESC";
        $s = $db->prepare($sql);
        $s->execute();

        // Store results in $images array
        while($row = $s->fetch(PDO::FETCH_ASSOC)){
            $images[] = array(
                'id' => $row['id'],
                'image' => $row['image'],
                'thumbnail' => $row['thumbnail'],
                'title' => $row['title'],
                'alt' => $row['alt']
            );
        }

        // Store number of images in variable
        $gallery_count = count($images);
    }
    catch (PDOException $e) {
        $errMsg = 'Error fetching images: ' . $e->getMessage();
        include 'includes/error.html.php';
        exit();
    }

    // Close database connection
    $db = null;

    include 'gallery.html.php';
    exit();
}








/* - - - - - - - - - - - -  SELECT button clicked  - - - - - - - -  - - - - - - - - - -   */

if(isset($_POST['action']) && $_POST['action'] === 'get_product_details'){

    // Get values from href and sanitize
    $id = htmlspecialchars($_POST['id']);

    // Assign queried table name to variable
    $table = 'products';

    // Connect to database
    include 'includes/dbconnect.php';

    try {
        $sql = "SELECT * FROM $table
                WHERE id = :id";
        $s = $db->prepare($sql);
        $s->bindValue(':id', $id);
        $s->execute();

        // Store single row result in variable using fetch method
        $item = $s->fetch(PDO::FETCH_ASSOC);

        // Assign value to title tag
        $title = $item['name'];
    }
    catch (PDOException $e) {
        $errMsg = 'Error fetching product data: ' . $e->getMessage();
        include 'error.html.php';
        exit();
    }

    include 'product-details.html.php';
    exit();
}




/* - - - - - - - - - - - - ADD item to $_SESSION['cart'] - - - - - - - -  - - - - - - - - - -   */

if(isset($_POST['action']) && $_POST['action'] === 'add_to_cart'){

    // Get id of selection
    if(isset($_POST['id'])){

        // Get values from href and sanitize
        $id = htmlspecialchars($_POST['id']);
        $category_id = htmlspecialchars($_POST['category_id']);
        $category_name = htmlspecialchars($_POST['category_name']);
        $name = htmlspecialchars($_POST['name']);
        $inscription = htmlspecialchars($_POST['inscription']);
        $description = htmlspecialchars($_POST['description']);
//      if(isset($_POST['size'])){$size = htmlspecialchars($_POST['size']);}
        $size = htmlspecialchars($_POST['size']);
        $image = htmlspecialchars($_POST['image']);
        $price = htmlspecialchars($_POST['price']);
        $quantity = 1;

//        echo '$id => ' . $id . '<br>';
//        echo '$category_id => ' . $category_id . '<br>';
//        echo '$category_name => ' . $category_name . '<br>';
//        echo '$name => ' . $name . '<br>';
//        echo '$inscription => ' . $inscription . '<br>';
//        echo '$description => ' . $description . '<br>';
//        if(isset($size)){echo '$size => ' . $size . '<br>';}
//        echo '$image => ' . $image . '<br>';
//        echo '$price => ' . $price . '<br>';
//        echo '$quantity => ' . $quantity . '<br>';
//        exit();

        // Check if item already in cart
        if(isset($_SESSION['cart'][$id]))
        {
            $link = '<a href="index.php?goto=store">Return to shopping.</a>';
            $errMsg = 'Item already in cart!';
            include 'includes/error.html.php';
            exit();
        }
        else
        {
            // Assign new data to array
            $newitem = [
                'id'          => $id,
                'name'        => $name,
                'size'        => $size,
                'inscription' => $inscription,
                'quantity'    => $quantity
            ];
        }

        // echo '<pre>';
        // print_r($newitem);
        // echo '</pre>';
        // exit();

        // Add $newitem array content to $_SESSION['cart'] array
        $_SESSION['cart'][$id] = $newitem;

        // echo '<pre>';
        // print_r($_SESSION['cart'][$id]);
        // echo '</pre>';
        // exit();

        // Get count of items in cart
        $session_cart_count = count($_SESSION['cart']);

        // echo $session_cart_count;
        // exit();

        // echo '<pre>';
        // print_r($_SESSION['cart'][$id]);
        // echo '</pre>';
        // exit();

        // Create success message to display @cart.html.php
        $success_message = $quantity . ' ' . $name . ' was added to the cart!';


        /* - - -  Retrieve product data to display @products.html.php included below  - - - */

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
                    'inscription' => $row['inscription'],
                    'size' => $row['size'],
                    'image'  => $row['image'],
                    'price' => $row['price'],
                    'quantity' => $row['quantity'],
                    'inventory' => $row['inventory']
                );
            }
        }
        catch(PDOException $e) {
            $errMsg = 'Error fetching data: ' . $e->getMessage();
            include 'error.html.php';
            exit();
        }

        // echo '<pre>';
        // print_r($_SESSION['cart'][$id]);
        // echo '</pre>';
        // exit();

        // echo '<pre>';
        // print_r($products);
        // echo '</pre>';
        // exit();

        // echo '<pre>';
        // print_r($_SESSION['cart'][$id]);
        // echo '</pre>';
        // exit();

        // echo '<pre>';
        // print_r($_SESSION['cart']);
        // echo '</pre>';
        // exit();

        /*
        if(!empty($_SESSION['cart']))
        {
            echo "Cart not empty";
        }
        else
        {
            echo "Cart empty";
        }

        if(empty($_SESSION['cart'][$id]))
        {
            echo '<br>Cart $id empty';
        }
        else
        {
            echo '<br>Cart $id not empty';
        }
        exit();
        */

        include 'products.html.php';
        exit();
    }
}




/* - - - - - - - - - - - - - - - User clicks Cart icon - - - - - - - - - - - - - - - - - - - -   */
if(isset($_GET['goto']) && $_GET['goto'] === 'cart'){

    if(empty($_SESSION['cart']))
    {
        //echo "the cart is empty"; exit();
        $link = '<a href="?get_page=shop&amp;id=7">Shop Now.</a>';
        $errMsg = 'Your shopping cart is empty.';
        include 'includes/error.html.php';
        exit();
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
                'inscription' => $row['inscription'],
                'description' => $row['description'],
                'size' => $row['size'],
                'image'  => $row['image'],
                'price' => $row['price'],
                'quantity' => $row['quantity'],
                'inventory' => $row['inventory']
            );
        }
    }
    catch(PDOException $e) {
        $errMsg = 'Error fetching data: ' . $e->getMessage();
        include 'error.html.php';
        exit();
    }


    // Create cart array to store items from $_SESSION['cart'] and products table
    $cart = array();

    // Initialize variable with a value = 0 to store cart total
    $total = 0;
    $subtotal = 0;

     // Check for matching IDs in SESSION['cart'] and $parts array
    foreach($_SESSION['cart'] as $item) {
        foreach($products as $product){
            if($product['id'] == $item['id']){

                // Create new array with IDs from $_SESSION['cart'] that match IDs from products table
                // !important $product['field'] values from Database matched against ID; $item['field'] values (e.g. 'size' and 'quantity' from SESSION['cart']
                $new_array = array(
                    'id' => $product['id'],
                    'name' => $product['name'],
                    'image'  => $product['image'],
                    'inscription' => $product['inscription'],
                    'size'  => $item['size'],  // !!! this field (note $item instead of $product) is from $_SESSION['cart'] array
                    'price' => $product['price'],
                    'quantity' => $item['quantity'],  // !!! this field (note $item instead of $product) is from $_SESSION['cart'] array
                    'subtotal' => $product['price'] * $item['quantity']
                );

                // Add data from $new_array array to $cart array with key = ID
                $cart[$item['id']] = $new_array;

                $total += $new_array['price'] * $new_array['quantity'];
                $cart_count = count($new_array);
                break;
            }
        }
    }

    /*  - - - - - - - -   PayPal   - - - - - - - - -  */

    // Create array for PayPal checkout
    $paypal_cart = array();

    // Initialize variable with a value = 0 to store cart total
    $total = 0;

    // Initialize counters
    $i = 1; $j = 1; $k = 1; $l = 1;

     // Check for matching IDs in SESSION['cart'] and $parts array
    foreach($_SESSION['cart'] as $item){
        foreach($products as $product){
            if($product['id'] == $item['id']){

                // Create new array with IDs from $_SESSION['cart'] that match IDs from products table
                $paypal_array = array(
                    'id' => $product['id'],
                    'name' => $product['name'],
                    'size' => $item['size'],   // this field (note $item instead of $product) is from $_SESSION['cart'] array
                    'inscription' => $product['inscription'],
                    'price' => $product['price'],
                    'quantity' => $item['quantity']  // this field (note $item instead of $product) is from $_SESSION['cart'] array
                );

                // Add data from $new_array array to $cart array with key = ID
                $paypal_cart[$item['id']] = $paypal_array;

                $total += $paypal_array['price'] * $paypal_array['quantity'];
                break;
            }
        }
    }

    include 'cart.html.php';
    exit();
}




/* - - - - - - - - - - - - Update item quantity in cart  - - - - - - -- - - - - - -   */

if(isset($_GET['action']) && $_GET['action'] === 'update_quantity'){

    // Retrieve, sanitize and store GET variables in new variables
    $new_quantity = htmlspecialchars($_GET['new_quantity']);
    $id = htmlspecialchars($_GET['id']);
    $name = htmlspecialchars($_GET['name']);

    // Update quantity of item in $_SESSION['cart']
    /*
    $_SESSION['cart'][$id] = array(
        'id' => $id,
        'name' => $name,
        'quantity' => $new_quantity
    );  */


    // Update quantity in SESSION['cart'][$id]
    $_SESSION['cart'][$id]['quantity'] = $new_quantity;

    /*
    // Display to test
    echo '<pre>';
    echo '$_SESSION[\'cart\']: ' . '<br>';
    print_r($_SESSION['cart'][$id]);
    echo '</pre>';
    */

    header('Location: index.php?goto=cart&new_quantity='.$new_quantity.'&name='.$name.'&id='.$id);
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

/* - - - - - - - - - - - - - - - User clicks Blog - - - - - - - - - - - - - - - - - - - -   */
if(isset($_GET['get_page']) && $_GET['id'] === '5'){

    include 'includes/dbconnect.php';

    // Retrieve category titles for menu
    try{
        $sql = "SELECT * FROM categories";
        $s = $db->prepare($sql);
        $s->execute();

        while($row = $s->fetch(PDO::FETCH_ASSOC)){
            $categories[] = array(
                'cat_id' => $row['cat_id'],
                'cat_title' => $row['cat_title']
            );
        }
    }
    catch (PDOException $e) {
        $errMsg = 'Unable to retrieve data from database' . $e->getMessage();
        include 'includes/error.html.php';
        exit();
    }



    // Retrieve posts for blog.html.php and order by RAND
    try {
        $sql = "SELECT post_id, post_category_id, post_title, post_date, post_author, post_keywords, post_image, post_content, cat_title
                FROM posts
                INNER JOIN categories
                ON post_category_id = cat_id
                ORDER BY RAND() LIMIT 0,5";
        $s = $db->prepare($sql);
        $s->execute();

        while($row = $s->fetch(PDO::FETCH_ASSOC)){
            $posts[] = array(
                'post_id' => $row['post_id'],
                'post_category_id' => $row['post_category_id'],
                'post_title' => $row['post_title'],
                'post_date' => $row['post_date'],
                'post_author' => $row['post_author'],
                'post_keywords' => $row['post_keywords'],
                'post_image' => $row['post_image'],
                'post_content' => substr($row['post_content'], 0,240),  //http://php.net/manual/en/function.substr.php
                'cat_title' => $row['cat_title'],
            );
        }
    }
    catch (PDOException $e) {
        $errMsg = 'Error fetching posts: ' . $e->getMessage();
        include 'includes/error.html.php';
        exit();
    }


    // Retrieve posts and order by most recent for sidebar
    try {
        $sql = "SELECT post_id, post_title, post_date, post_author, post_image, cat_title
                FROM posts
                INNER JOIN categories
                ON post_category_id = cat_id
                ORDER BY 1 DESC LIMIT 0,4";
        $s = $db->prepare($sql);
        $s->execute();

        while($row = $s->fetch(PDO::FETCH_ASSOC)){
            $recent_posts[] = array(
                'post_id' => $row['post_id'],
                'post_title' => $row['post_title'],
                'post_date' => $row['post_date'],
                'post_author' => $row['post_author'],
                'post_image' => $row['post_image'],
                'cat_title' => $row['cat_title'],
            );
        }
    }
    catch (PDOException $e) {
        $errMsg = 'Error fetching posts: ' . $e->getMessage();
        include 'includes/error.html.php';
        exit();
    }

    include 'blog.html.php';
    exit();
}



/* - - - - - - - - - - - - - - - User clicks "Events" - - - - - - - - - - - - - - - - - - - -   */
if(isset($_GET['get_page']) && $_GET['id'] === '4'){


    // Assign queried table name to variable
    $table = 'events';

    // Connect to database
    include 'includes/dbconnect.php';

    // Retrieve data for specified page
    try{
        $sql = "SELECT * FROM $table ORDER BY event_date";
        $s = $db->prepare($sql);
        $s->execute();

        while($row = $s->fetch(PDO::FETCH_ASSOC)){
            $events[] = array(
                'event_id' => $row['event_id'],
                'event_title' => $row['event_title'],
                'event_date' => $row['event_date'],
                'event_location' => $row['event_location'],
                'event_description' => $row['event_description'],
                'event_image' => $row['event_image']
            );
        }
    }
    catch (PDOException $e) {
        $errMsg = 'Unable to retrieve data from database' . $e->getMessage();
        include 'includes/error.html.php';
        exit();
    }

    include 'events.html.php';
    exit();
}


/*------------------  View a single event  ----------------------*/

if(isset($_GET['getevent'])){

    // Get event id from GET variable
    $event_id = htmlspecialchars($_GET['getevent']);

    // Assign queried table to variable
    $table = 'events';

    // Connect to database
    include 'includes/dbconnect.php';

    try {
        $sql = "SELECT *
                FROM $table
                WHERE event_id = :event_id";
        $s = $db->prepare($sql);
        $s->bindValue(':event_id',$event_id);
        $s->execute();

        while($row = $s->fetch(PDO::FETCH_ASSOC)){
            $events[] = array(
                'event_id' => $row['event_id'],
                'event_title' => $row['event_title'],
                'event_date' => $row['event_date'],
                'event_location' => $row['event_location'],
                'event_description' => $row['event_description'],
                'event_image' => $row['event_image']
            );
        }
    }
    catch (PDOException $e) {
        $errMsg = 'Error fetching event: ' . $e->getMessage();
        include 'includes/error.html.php';
        exit();
    }

     // Close database connection
    $db = null;

    include 'single-event.html.php';
    exit();
}





/* - - - - - - - - - - - - - - -  Search   - - - - - - - - - - - - - - - - - - - - */
if(isset($_GET['action']) && $_GET['action'] === 'search'){

    // Connect to database
    include 'includes/dbconnect.php';

    // Retrieve category titles for menu
    try {
        $sql = "SELECT * FROM categories";
        $s = $db->prepare($sql);
        $s->execute();

        while($row = $s->fetch(PDO::FETCH_ASSOC)){
            $categories[] = array(
                'cat_id' => $row['cat_id'],
                'cat_title' => $row['cat_title']
            );
        }
    }
    catch (PDOException $e) {
        $errMsg = 'Unable to retrieve data from database' . $e->getMessage();
        include 'includes/error.html.php';
        exit();
    }

    // Check if input box is empty
    if( empty($_GET['search_query']) ){

        $errMsg = 'Please enter data to search.';
        include 'includes/error.html.php';
        exit();
    }
    else {

        // Sanitize user data
        $search = htmlspecialchars($_GET['search_query']);

        // Store $search content into $_SESSIONS['search'] for conditional logic use below in Add item conditional statement
        $_SESSION['search'] = $search;

        // Remove comment to test
        //echo '$search: ' . $search;
    }

    // Query keywords entered into search box
    try {
        $sql = "SELECT post_id, post_category_id, post_title, post_date, post_author, post_keywords, post_image, post_content, cat_title
                FROM posts
                INNER JOIN categories
                ON post_category_id = cat_id
                WHERE post_content LIKE '%$search%'
                OR post_title LIKE '%$search%'
                OR post_author LIKE '%$search%'
                OR post_keywords LIKE '%$search'";     //"SELECT * FROM parts WHERE id LIKE %$search% OR description LIKE %$search% OR part_number LIKE %$search%";
        $s = $db->prepare($sql);
        $s->execute();
    }
    catch (PDOException $e) {
        $errMsg = 'Error fetching data' . $e->getMessage();
        include 'includes/error.html.php';
        exit();
    }

     if($s->rowCount() < 1){
            $errMsg = 'Sorry, no match found for: ' . $_SESSION['search'];
            include 'includes/error.html.php';
            exit();
    }
    else {

        if($s->rowCount() > 0){
            while($row = $s->fetch(PDO::FETCH_ASSOC)){
                $posts[] = array(
                    'post_id' => $row['post_id'],
                    'post_category_id' => $row['post_category_id'],
                    'post_title' => $row['post_title'],
                    'post_date' => $row['post_date'],
                    'post_author' => $row['post_author'],
                    'post_keywords' => $row['post_keywords'],
                    'post_image' => $row['post_image'],
                    'post_content' => substr($row['post_content'], 0,280),  //http://php.net/manual/en/function.substr.php
                    'cat_title' => $row['cat_title'],
                );
            }
        }
    }

     // Retrieve posts and order by most recent for sidebar
    try {
        $sql = "SELECT post_id, post_title, post_date, post_author, post_image, cat_title
                FROM posts
                INNER JOIN categories
                ON post_category_id = cat_id
                ORDER BY 1 DESC LIMIT 0,5";
        $s = $db->prepare($sql);
        $s->execute();

        while($row = $s->fetch(PDO::FETCH_ASSOC)){
            $recent_posts[] = array(
                'post_id' => $row['post_id'],
                'post_title' => $row['post_title'],
                'post_date' => $row['post_date'],
                'post_author' => $row['post_author'],
                'post_image' => $row['post_image'],
                'cat_title' => $row['cat_title'],
            );
        }
    }
    catch (PDOException $e) {
        $errMsg = 'Error fetching posts: ' . $e->getMessage();
        include 'includes/error.html.php';
        exit();
    }

    // Close database connection
    $db = null;

    include 'results.html.php';
    exit();
}

/*-------------------------  Submit comment    -------------------------------*/

if(isset($_POST['action']) && $_POST['action'] === 'submit_comment'){

    // Must query database to populate category fields for menu in header.php;
    // this is required because if there's an error, error.html.php is included
    include 'includes/dbconnect.php';
    include 'includes/helper.php';

    // Retrieve category titles for menu
    try {
        $sql = "SELECT * FROM categories";
        $s = $db->prepare($sql);
        $s->execute();

        while($row = $s->fetch(PDO::FETCH_ASSOC)){
            $categories[] = array(
                'cat_id' => $row['cat_id'],
                'cat_title' => $row['cat_title']
            );
        }
    }
    catch (PDOException $e) {
        $errMsg = 'Unable to retrieve data from database' . $e->getMessage();
        include 'includes/error.html.php';
        exit();
    }

    $post_id = sanitize($_POST['post_id']);
    $comment_name = sanitize($_POST['name']);
    $comment_email = sanitize($_POST['email']);
    $comment_text = strip_tags($_POST['comment']);
    $status = 'unapproved';

    // Validate user data
    if( empty($comment_name) ||  empty($comment_email) || empty($comment_text) ){
        $errMsg = 'Please fill in all fields.';
        include 'includes/error.html.php';
        exit();
    }
    else {

        $table = 'comments';
        $location = 'index.php?getpost=' . $post_id;

        // Insert comments into database
        try {
            $sql = "INSERT INTO $table SET
                    post_id = :post_id,
                    comment_name = :comment_name,
                    comment_email = :comment_email,
                    comment_text = :comment_text,
                    status = :status";
            $s = $db->prepare($sql);
            $s->bindValue(':post_id', $post_id);
            $s->bindValue(':comment_name', $comment_name);
            $s->bindValue(':comment_email', $comment_email);
            $s->bindValue(':comment_text', $comment_text);
            $s->bindValue(':status', $status);
            if($s->execute()){
                echo "<script>alert('Your comment was submitted. It will be published pending approval.')</script>";
                echo "<script>window.location.href = '.'</script>";
            }
        }
        catch (PDOException $e) {
            $errMsg = 'Error connecting to database: ' . $e->getMessage();
            include 'includes/error.html.php';
            exit();
        }

        // Close database connection
        $db = null;

        // Exit
        exit();
    }
}

/*  - - - - - - - - - - View posts by Category - - - - - - - - - - - - - - - - - - - */

if(isset($_GET['cat_id'])){

    $post_category_id = htmlspecialchars($_GET['cat_id']);
    $_SESSION['category_id'] = $post_category_id;
    $table = 'posts';
    include 'includes/dbconnect.php';

    // Retrieve posts by category
    try {
        $sql = "SELECT post_id, post_category_id, post_title, post_date, post_author, post_keywords, post_image, post_content, cat_title
                FROM $table
                INNER JOIN categories
                ON post_category_id = cat_id
                WHERE post_category_id = :post_category_id ORDER BY post_date DESC";
        $s = $db->prepare($sql);
        $s->bindValue(':post_category_id',$post_category_id);
        $s->execute();

        while($row = $s->fetch(PDO::FETCH_ASSOC)){
            $posts[] = array(
                'post_id' => $row['post_id'],
                'post_category_id' => $row['post_category_id'],
                'post_title' => $row['post_title'],
                'post_date' => $row['post_date'],
                'post_author' => $row['post_author'],
                'post_keywords' => $row['post_keywords'],
                'post_image' => $row['post_image'],
                'post_content' => substr($row['post_content'],0,200),
                'cat_title' => $row['cat_title'],
            );
        }
    }
    catch (PDOException $e) {
        $errMsg = 'Error fetching post: ' . $e->getMessage();
        include 'includes/error.html.php';
        exit();
    }

    if(isset($posts)){
        $cat_post_count = count($posts);
    }

    // Retrieve category titles for menu
    try {
        $sql = "SELECT * FROM categories";
        $s = $db->prepare($sql);
        $s->execute();

        while($row = $s->fetch(PDO::FETCH_ASSOC)){
            $categories[] = array(
                'cat_id' => $row['cat_id'],
                'cat_title' => $row['cat_title']
            );
        }
    }
    catch (PDOException $e) {
        $errMsg = 'Unable to retrieve data from database' . $e->getMessage();
        include 'includes/error.html.php';
        exit();
    }


    // Retrieve posts and order by most recent for sidebar
    try {
        $sql = "SELECT post_id, post_title, post_date, post_author, post_image, cat_title
                FROM posts
                INNER JOIN categories
                ON post_category_id = cat_id
                ORDER BY 1 DESC LIMIT 0,5";
        $s = $db->prepare($sql);
        $s->execute();

        while($row = $s->fetch(PDO::FETCH_ASSOC)){
            $recent_posts[] = array(
                'post_id' => $row['post_id'],
                'post_title' => $row['post_title'],
                'post_date' => $row['post_date'],
                'post_author' => $row['post_author'],
                'post_image' => $row['post_image'],
                'cat_title' => $row['cat_title'],
            );
        }
    }
    catch (PDOException $e) {
        $errMsg = 'Error fetching posts: ' . $e->getMessage();
        include 'includes/error.html.php';
        exit();
    }

    // Close database connection
    $db = null;

    include 'category-post.html.php';
    exit();
}

/*------------------  View a single post  ----------------------*/

if(isset($_GET['getpost'])){

    $post_id = htmlspecialchars($_GET['getpost']);
    $table = 'posts';
    $status = 'approved'; // for use below
    include 'includes/dbconnect.php';

    try {
        $sql = "SELECT post_id, post_category_id, post_title, post_date, post_author, post_keywords, post_image, post_content, cat_title
                FROM $table
                INNER JOIN categories
                ON post_category_id = cat_id
                WHERE post_id = :post_id";
        $s = $db->prepare($sql);
        $s->bindValue(':post_id',$post_id);
        $s->execute();

        while($row = $s->fetch(PDO::FETCH_ASSOC)){
            $posts[] = array(
                'post_id' => $row['post_id'],
                'post_category_id' => $row['post_category_id'],
                'post_title' => $row['post_title'],
                'post_date' => $row['post_date'],
                'post_author' => $row['post_author'],
                'post_keywords' => $row['post_keywords'],
                'post_image' => $row['post_image'],
                'post_content' => $row['post_content'],
                'cat_title' => $row['cat_title'],
            );
        }
    }
    catch (PDOException $e) {
        $errMsg = 'Error fetching post: ' . $e->getMessage();
        include 'includes/error.html.php';
        exit();
    }

    // Retrieve category titles for menu
    try {
        $sql = "SELECT * FROM categories";
        $s = $db->prepare($sql);
        $s->execute();

        while($row = $s->fetch(PDO::FETCH_ASSOC)){
            $categories[] = array(
                'cat_id' => $row['cat_id'],
                'cat_title' => $row['cat_title']
            );
        }
    }
    catch (PDOException $e) {
        $errMsg = 'Unable to retrieve data from database' . $e->getMessage();
        include 'includes/error.html.php';
        exit();
    }


    // Retrieve posts and order by most recent for sidebar
    try {
        $sql = "SELECT post_id, post_title, post_date, post_author, post_image, cat_title
                FROM posts
                INNER JOIN categories
                ON post_category_id = cat_id
                ORDER BY 1 DESC LIMIT 0,5";
        $s = $db->prepare($sql);
        $s->execute();

        while($row = $s->fetch(PDO::FETCH_ASSOC)){
            $recent_posts[] = array(
                'post_id' => $row['post_id'],
                'post_title' => $row['post_title'],
                'post_date' => $row['post_date'],
                'post_author' => $row['post_author'],
                'post_image' => $row['post_image'],
                'cat_title' => $row['cat_title'],
            );
        }
    }
    catch (PDOException $e) {
        $errMsg = 'Error fetching posts: ' . $e->getMessage();
        include 'includes/error.html.php';
        exit();
    }

    // Display comments that are approved
    try {
        $sql = "SELECT * FROM comments
                WHERE post_id = :post_id AND status = :status
                ORDER BY comment_id DESC LIMIT 0,15";
        $s = $db->prepare($sql);
        $s->bindValue(':post_id', $post_id);
        $s->bindValue(':status', $status);
        $s->execute();

        // Declare comments array
        $comments = array();

        while($row = $s->fetch(PDO::FETCH_ASSOC)){
            $comments[] = array(
                'comment_id' => $row['comment_id'],
                'post_id' => $row['post_id'],
                'comment_date' => $row['comment_date'],
                'comment_name' => $row['comment_name'],
                'comment_email' => $row['comment_email'],
                'comment_text' => $row['comment_text'],
                'status' => $row['status'],
            );
        }
        // Check if there are any comments; if true, get count & store in variable $comment_count
        if(count($comments) > 0){
            $comment_count = count($comments);
        }
    }
    catch (PDOException $e) {
        $errMsg = 'Error fetching posts: ' . $e->getMessage();
        include 'includes/error.html.php';
        exit();
    }

    // Close database connection
    $db = null;

    include 'single-post.html.php';
    exit();
}


/*  - - - - - - -  - - - - - -  Select page   - - - - - - - - - - - - - - */
if(isset($_GET['get_page'])){

    // Get page id, page name & menu name from dynamic GET variable
    $page_id = $_GET['id'];
    $page_name = $_GET['get_page'];

    // Assign queried table to variable
    $table = 'pages';

    // Connect to database
    include 'includes/dbconnect.php';

    // Get data for selected page
    try {
        $sql = "SELECT * FROM pages
                WHERE page_id = :page_id";
         $s = $db->prepare($sql);
         $s->bindValue(':page_id', $page_id);
         $s->execute();

         while($row = $s->fetch(PDO::FETCH_ASSOC)){
             $page[] = array(
                 'page_id' => $row['page_id'],
                 'page_name' => $row['page_name'],
                 'page_image' => $row['page_image'],
                 'page_content' => $row['page_content'],
                 'main_menu_id' => $row['main_menu_id']
             );
         }
    }
    catch (PDOException $e) {
        $errMsg  = 'Error fetching data from database: ' . $e->getMessage();
        include 'includes/error.html.php';
        exit();
    }

     // Disconnect
     $db = NULL;

     // Loop thru page array for Leaders page (unique page)
     foreach($page as $item){
         if($item['page_id'] == '19'){
             header("Location: leaders.php");
             exit();
         }
         else{
            include 'page.html.php';
            exit();
         }
     }
}

 /*
 echo '<pre>';
 print_r($intercessory);
 echo '</pre>';
 exit();
*/


/*  - - - - - - -  - - - - - -  DEFAULT   - - - - - - - - - - - - - - */
// Connect to database
include 'includes/dbconnect.php';

// Assign queried table name to variable
$table = 'pages';

// Assign page_id
$page_id = '1';

try {
    $sql = "SELECT * FROM $table
            WHERE page_id = :page_id";
    $s = $db->prepare($sql);
    $s->bindValue(':page_id', $page_id);
    $s->execute();

    // Store single column results in array
    $home_page = $s->fetch(PDO::FETCH_ASSOC);
}
catch (PDOException $e) {
   $errMsg  = 'Error fetching data from database: ' . $e->getMessage();
    include 'includes/error.html.php';
    exit();
}

include 'main.html.php';
