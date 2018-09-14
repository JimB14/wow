<?php
@session_start;
$server = htmlspecialchars($_SERVER['SERVER_NAME']);
$page_id = 'admin';
$title = 'Admin | WoW';
$description = 'Admin panel';
include 'includes/helper.php';
include 'includes/header.php';
?>

<div class="container-fluid">
    <img id="admin-bg" src="images/diagonal-grid-pattern.png">
    
        <div class="row">
            <div class="col-md-12 col-sm-12">
                <p style="margin:0px;">
                    <span class="glyphicon glyphicon-user pull-left"></span><span class="blue"> &nbsp;<?php if(isset($_SESSION['name'])){echo htmlspecialchars($_SESSION['name']);} else {echo htmlspecialchars($_SESSION['email']);} ?></span>
                    <span class="blue pull-right"><?php echo date('M d, Y'); ?></span>
                </p>                 
            </div>
            
            <div class="col-md-12 col-sm-12">
                <h1 class="text-center" style="margin-bottom:5px;"><?php if(isset($page_title)) {echo htmlspecialchars($page_title);} ?></h1>                 
            </div>

            <div class="col-md-2 col-sm-3">
                
                <?php include 'includes/sidebar-left.inc.php'; ?>
                
            </div><!-- // .col-md-2  -->

            <div class="col-md-10 col-sm-9">
                
                <!-- - - - - - - - - - - - - - - - - -  Create New Post  - - - - - - - - - - - - - - - - - -->
                <?php
                if (isset($_GET['goto']) && $_GET['goto'] === 'newpost') {

                    $page_title = 'Create new post';
                    
                    include 'includes/dbconnect.php';
                    $table = 'categories';

                    try {
                        $sql = "SELECT * FROM $table";
                        $s = $db->prepare($sql);
                        $s->execute();

                        while ($row = $s->fetch(PDO::FETCH_ASSOC)) {
                            $categories[] = array(
                                'cat_id' => $row['cat_id'],
                                'cat_title' => $row['cat_title']
                            );
                        }
                    } catch (PDOException $e) {
                        $errMsg = 'Unable to retrieve data from database' . $e->getMessage();
                        include 'includes/error.html.php';
                        exit();
                    }

                    // Close database connection
                    $db = null;                 

                    $included_title = 'New post';
                    include 'add-new-post-form.html.php';
                    exit();
                };
                ?>


                <!-- - - - - - - - - - - - - - - - - -  View All Posts    - - - - - - - - - - - - - - - - - -->
                <?php
                if (isset($_GET['goto']) && $_GET['goto'] === 'view_posts') {

                    $page_title = 'Posts';
                    $table = 'posts';

                    include 'includes/dbconnect.php';

                    try {
                        $sql = "SELECT * FROM $table
                                ORDER BY post_id DESC";
                        $s = $db->prepare($sql);
                        $s->execute();

                        while ($row = $s->fetch(PDO::FETCH_ASSOC)) {
                            $posts[] = array(
                                'post_id' => $row['post_id'],
                                'post_category_id' => $row['post_category_id'],
                                'post_title' => $row['post_title'],
                                'post_date' => $row['post_date'],
                                'post_author' => $row['post_author'],
                                'post_keywords' => $row['post_keywords'],
                                'post_image' => $row['post_image'],
                                'post_content' => $row['post_content']
                            );
                        }

                        $post_count = count($posts);
                        
                    } catch (PDOException $e) {
                        
                        $errMsg = 'Error fetching posts:' . $e->getMessage();
                        include 'includes/error.html.php';
                        exit();
                    }                   

                    // Close database connection
                    $db = null;

                    include 'view-posts.html.php';
                    exit();
                };
                ?>
                
                
                <!-- - - - - - - - - - - - - - - - - -  Edit Post    - - - - - - - - - - - - - - - - - -->
                <?php
                if (isset($_GET['edit_post'])){
                    
                    // Set variables
                    $page_title = 'Edit post';
                    $table = 'posts';
                    
                    // Retrieve post_id  value and store in $post_id variable
                    $post_id = sanitize($_GET['edit_post']);
                    
                    // Connect to database
                    include 'includes/dbconnect.php';
                    
                    // Query database for post data of specified id
                    try {
                        $sql = "SELECT post_id, post_category_id, post_title, post_date, post_author, post_keywords, post_image, post_content, cat_title
                                FROM $table
                                INNER JOIN categories
                                ON post_category_id = cat_id
                                WHERE post_id = :post_id";
                        $s = $db->prepare($sql);
                        $s->bindValue(':post_id', $post_id);
                        $s->execute();
                        
                        // Store results in $posts array
                        while ($row = $s->fetch(PDO::FETCH_ASSOC)){
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
                        $errMsg  = 'Error fetching data: ' . $e->getMessage();
                        include 'includes/error.html.php';
                        exit();
                    }
                    
                    // Close database connection
                    $db = null;
                    
                    // Include form to display results for editing
                    include 'edit-post-form.html.php';
                    exit();
                }              
                ?>
                
                
                <!-- - - - - - - - - - - - - - - - - -  Create new post category    - - - - - - - - - - - - - - - - - -->
                <?php
                if (isset($_GET['goto']) && $_GET['goto'] === 'create_category') {
                    
                    $page_title = 'Add new post category';
                    
                    include 'includes/dbconnect.php';
                    $table = 'categories';

                    try {
                        $sql = "SELECT * FROM $table";
                        $s = $db->prepare($sql);
                        $s->execute();

                        while ($row = $s->fetch(PDO::FETCH_ASSOC)) {
                            $categories[] = array(
                                'cat_id' => $row['cat_id'],
                                'cat_title' => $row['cat_title']
                            );
                        }
                    } catch (PDOException $e) {
                        $errMsg = 'Unable to retrieve data from database' . $e->getMessage();
                        include 'includes/error.html.php';
                        exit();
                    }

                    // Close database connection
                    $db = null;
                    

                    include 'add-new-post-category-form.html.php';
                    exit();                   
                }                
                ?>
                
                
                <!-- - - - - - - - - - - - - - - - - -  View post categories   - - - - - - - - - - - - - - - - - -->
                <?php
                if (isset($_GET['goto']) && $_GET['goto'] === 'view_categories') {                   
                    
                    $page_title = 'Post Categories';
                    $table = 'categories';
                    
                    // Connect to database
                    include 'includes/dbconnect.php';                   
                    
                    try {
                        $sql = "SELECT * FROM $table";
                        $s = $db->prepare($sql);
                        $s->execute();

                        while ($row = $s->fetch(PDO::FETCH_ASSOC)) {
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

                    // Close database connection
                    $db = null;
                  
                    include 'view-post-categories.html.php';
                    exit();
                }
                ?>
                
                
                <!-- - - - - - - - - - - - - - - - - -  Edit Post Category    - - - - - - - - - - - - - - - - - -->
                <?php
                if (isset($_GET['edit_category'])){

                    // Set variables
                    $page_title = 'Edit post category title (name)';
                    $table = 'categories';

                    // Retrieve post_id  value and store in $post_id variable
                    $cat_id = sanitize($_GET['edit_category']);

                    // Connect to database
                    include 'includes/dbconnect.php';

                    // Query database for post data of specified id
                    try {
                        $sql = "SELECT * FROM $table
                                WHERE cat_id = :cat_id";
                        $s = $db->prepare($sql);
                        $s->bindValue(':cat_id', $cat_id);
                        $s->execute();

                        // Store results in $posts array
                        while ($row = $s->fetch(PDO::FETCH_ASSOC)){
                            $categories[] = array(
                                'cat_id' => $row['cat_id'],  
                                'cat_title' => $row['cat_title']
                            );
                        }
                    } 
                    catch (PDOException $e) {
                        $errMsg  = 'Error fetching data: ' . $e->getMessage();
                        include 'includes/error.html.php';
                        exit();
                    }

                    // Close database connection
                    $db = null;

                    // Include form to display results for editing
                    include 'edit-post-category-form.html.php';
                    exit();
                } 
                ?> 
                
                
                <!-- - - - - - - - - - - - - - - - - -  View Post Comments   - - - - - - - - - - - - - - - - - -->
                <?php
                if (isset($_GET['goto']) && $_GET['goto'] === 'view_comments') {                   
                    
                    $page_title = 'Post Comments';
                    $table = 'comments';
                    
                    // Connect to database
                    include 'includes/dbconnect.php';                   
                    
                    try {
                        $sql = "SELECT * FROM $table ORDER BY comment_id DESC, post_id";
                        $s = $db->prepare($sql);
                        $s->execute();

                        while ($row = $s->fetch(PDO::FETCH_ASSOC)) {
                            $comments[] = array(
                                'comment_id' => $row['comment_id'],
                                'post_id' => $row['post_id'],
                                'comment_date' => $row['comment_date'],
                                'comment_name' => $row['comment_name'],
                                'comment_email' => $row['comment_email'],
                                'comment_text' => substr($row['comment_text'], 0, 50),
                                'status' => $row['status']
                            );
                        }
                    } 
                    catch (PDOException $e) {
                        $errMsg = 'Unable to retrieve data from database' . $e->getMessage();
                        include 'includes/error.html.php';
                        exit();
                    }

                    // Close database connection
                    $db = null;
                  
                    include 'view-post-comments.html.php';
                    exit();
                }
                ?>
                
                
                <!-- - - - - - - - - - - - - - - - - -  Edit Post Comments    - - - - - - - - - - - - - - - - - -->
                <?php
                if (isset($_GET['edit_comment'])){

                    // Set variables
                    $page_title = 'Edit post comments';
                    $table = 'comments';

                    // Retrieve post_id  value and store in $post_id variable
                    $comment_id = sanitize($_GET['edit_comment']);

                    // Connect to database
                    include 'includes/dbconnect.php';

                    // Query database for post data of specified id
                    try {
                        $sql = "SELECT * FROM $table
                                WHERE comment_id = :comment_id";
                        $s = $db->prepare($sql);
                        $s->bindValue(':comment_id', $comment_id);
                        $s->execute();

                        // Store results in $posts array
                        while ($row = $s->fetch(PDO::FETCH_ASSOC)){
                            $comments[] = array(
                                'comment_id' => $row['comment_id'],
                                'post_id' => $row['post_id'],  
                                'comment_date' => $row['comment_date'],
                                'comment_name' => $row['comment_name'],  
                                'comment_email' => $row['comment_email'],
                                'comment_text' => $row['comment_text'],  
                                'status' => $row['status']
                            );
                        }
                    } 
                    catch (PDOException $e) {
                        $errMsg  = 'Error fetching data: ' . $e->getMessage();
                        include 'includes/error.html.php';
                        exit();
                    }

                    // Close database connection
                    $db = null;

                    // Include form to display results for editing
                    include 'edit-comments-form.html.php';
                    exit();
                } 
                ?> 
                
                
                
                <!-- - - - - - - - - - - - - - - - - -   Add new gallery image    - - - - - - - - - - - - - - - - -  -->
                <?php
                if (isset($_GET['goto']) && $_GET['goto'] === 'add_image'){
                    
                    // Set page title to variable
                    $page_title = 'Add new gallery image';                  

                    include 'add-new-gallery-image-form.html.php';
                    exit();
                }
                ?>
                
                
                <!-- - - - - - - - - - - - - - - - - - Insert new gallery image  - - - - - - - - - - - - - - - - - -->
                <?php
                // Turn on error reporting for debugging
                error_reporting( E_ALL );
                ini_set( 'display_errors', 1 );
                
                if(isset($_POST['action']) && $_POST['action'] === 'add_new_gallery_image'){
                    
                    // Image handling code resource (Adam Khoury):  https://www.youtube.com/watch?v=wHveLsmAjYE&app=desktop
                    
                    // Access $_FILES global array for uploaded file
                    $file_name = $_FILES['image']['name'];
                    $file_tmp_loc = $_FILES['image']['tmp_name'];
                    $file_type = $_FILES['image']['type'];
                    $file_size = $_FILES['image']['size'];
                    $file_err_msg = $_FILES['image']['error'];
                    
                    // Separate file name into an array by the dot
                    $kaboom = explode(".", $file_name);
                    
                    // Assign last element of array to file_extension variable (in case file has more than one dot)
                    $file_extension = end($kaboom);
                    
                    $title = sanitize($_POST['title']);
                    $alt = sanitize($_POST['alt']);
                    
                    /* - - - - -  Error handling  - - - - - - */
                    
                    // Check if file selected
                    if(!$file_tmp_loc){
                        $errMsg = 'Please select image file to upload.';
                        include 'includes/error.html.php';
                        exit();
                    }
                    // Check if file size < 2 MB
                    elseif($file_size > 2097152){
                        unlink($file_tmp_loc);
                        $errMsg = 'File must be less than 2 Megabytes to upload.';
                        include 'includes/error.html.php';
                        exit();
                    }
                    // Check if file is gif, jpg or png
                    elseif(!preg_match("/\.(gif|jpg|png)$/i", $file_name)){
                        unlink($file_tmp_loc);
                        $errMsg = 'Image must be gif, jpg or png to upload.';
                        include 'includes/error.html.php';
                        exit();
                    }
                    // Check for any errors
                    elseif($file_err_msg == 1){
                        $errMsg = 'Error uploading file. Please try again.';
                        include 'includes/error.html.php';
                        exit();
                    }
                    
                    // Upload file to server into designated folder
                    $move_result = move_uploaded_file($file_tmp_loc, "uploaded_gallery_images/$file_name");
                    
                    // Check for boolean result of move_uploaded_file()                   
                    if ($move_result != true) {
                        unlink($file_tmp_loc);
                        $errMsg = 'File not uploaded. Please try again.';
                        include 'includes/error.html.php';
                        exit();
                    } 
                    
                    /*  - - - - - - - -  Image Re-sizing   - - - - - - - - - -  */
                    
                    include_once 'includes/image-resizing.inc.php';
                    $target_file = "uploaded_gallery_images/$file_name";
                    $resized_file = "uploaded_gallery_images/thumb_$file_name";
                    $wmax = 75;
                    $hmax = 75;
                    image_resize($target_file, $resized_file, $wmax, $hmax, $file_extension);
                    
                    $thumbnail = "thumb_$file_name";
                    
                    /* - - - - - - - - - - Insert image file path into database  - - - - - - - - - - - - - - */
                    // Connect to database
                    include 'includes/dbconnect.php';

                    // Assign queried table name to variable
                    $table = 'gallery';

                    try {
                        $sql = "INSERT INTO $table SET
                                image = :image,
                                thumbnail = :thumbnail,
                                title = :title,
                                alt = :alt";
                        $s = $db->prepare($sql);
                        $s->bindValue(':image', $file_name);
                        $s->bindValue(':thumbnail', $thumbnail);
                        $s->bindValue(':title', $title);
                        $s->bindValue(':alt', $alt);
                        if( $s->execute() ){
                            echo "<script>alert('Image successfully added!')</script>";
                            echo "<script>window.location.href = 'index.php?goto=add_image'</script>";                              
                        } 
                    }
                    catch (PDOException $e) {
                        $errMsg = 'Error inserting data into database: ' . $e->getMessage();
                        include 'includes/error.html.php';
                        exit();
                    }

                    // Close database connection
                    $db = null;

                    //header('Location: .');
                    exit();
                }                               
                ?>
                
                
                <!-- - - - - - - - - - - - - - - - - -  View Gallery Images  - - - - - - - - - - - - - - - - - -->
                <?php
                if(isset($_GET['goto']) && $_GET['goto'] === 'view_gallery_images'){
                    
                    // Assign queried table name to variable
                    $table = 'gallery';
                    $page_title = 'View gallery images';

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
                                'alt' => $row['alt'],
                                'upload_date' => $row['upload_date']
                            );
                        }                       
                    } 
                    catch (PDOException $e) {
                        $errMsg = 'Error fetching images: ' . $e->getMessage();
                        include 'includes/error.html.php';
                        exit();
                    }
                    
                    // Store number of images in variable
                        if(!empty($images)){
                            $gallery_count = count($images);
                        }

                    // Close database connection
                    $db = null;

                    include 'view-gallery.html.php';
                    exit();
                }
                ?>
                
                <!-- - - - - - - - - - - - - - - - - -  Edit gallery image  - - - - - - - - - - - - - - - - -  -->
                <?php        
                if(isset($_GET['edit_gallery_image'])){
                    
                    $id = htmlspecialchars($_GET['edit_gallery_image']);
                    
                    $table = 'gallery';
                    $page_title = 'Edit gallery images';
                    
                    // Connect to database
                    include 'includes/dbconnect.php';

                    try {
                        $sql = "SELECT * FROM $table
                                WHERE id = :id";
                        $s = $db->prepare($sql);
                        $s->bindValue(':id', $id);
                        $s->execute();

                        // Store results in $images array
                        while($row = $s->fetch(PDO::FETCH_ASSOC)){
                            $images[] = array(
                                'id' => $row['id'],
                                'image' => $row['image'],
                                'thumbnail' => $row['thumbnail'],
                                'title' => $row['title'],
                                'alt' => $row['alt'],
                                'upload_date' => $row['upload_date']
                            );
                        }
                    } 
                    catch (PDOException $e) {
                        $errMsg = 'Error fetching images: ' . $e->getMessage();
                        include 'includes/error.html.php';
                        exit();
                    }

                    // Close database connection
                    $db = null;
                                        
                    include 'edit-gallery-image-form.html.php';
                    exit();
                }                              
                ?>
                
                <!-- - - - - - - - - - - - - - - - - -  Update gallery image  - - - - - - - - - - - - - - - - -  -->
                <?php
                if(isset($_POST['action']) && $_POST['action'] === 'update_gallery_image'){
                    
                    // Sanitize and post values
                    $id = sanitize($_POST['id']);
                    $title = sanitize($_POST['title']);
                    $alt = sanitize($_POST['alt']);

                    // Set queried table name to variable
                    $table = 'gallery';

                    // Connect to database
                    include 'includes/dbconnect.php';

                    try {
                        $sql = "UPDATE $table SET
                               title = :title,
                               alt = :alt
                               WHERE id = :id";
                        $s = $db->prepare($sql);
                        $s->bindValue(':id', $id);
                        $s->bindValue(':title', $title);
                        $s->bindValue(':alt', $alt);
                        if( $s->execute() ){
                            echo "<script>alert('Image successfully updated!')</script>";
                            echo "<script>window.location.href = 'index.php?goto=view_gallery_images'</script>"; //http://stackoverflow.com/questions/4813879/window-open-target-self-v-window-location-href
                        } 
                    }
                    catch (PDOException $e) {
                        $errMsg = 'Error updating database:' . $e->getMessage();
                        include 'includes/error.html.php';
                        exit();
                    }

                    // Close database connection
                    $db = null;

                    // Exit
                    exit(); 
                }              
                ?>
                
                <!-- - - - - - - - - - - - - - - - - -  Delete gallery image  - - - - - - - - - - - - - - - - -  -->
                <?php
                if(isset($_GET['delete_gallery_image'])){
                    
                    // Get image id from GET variable
                    $id = sanitize($_GET['delete_gallery_image']);
                    $image = sanitize($_GET['image']);
                    $thumbnail = sanitize($_GET['thumbnail']);
                    
                    
                    if(isset($server) && $server === 'localhost'){
                        // Execute if server is localhost 
                        $image = $_SERVER['DOCUMENT_ROOT'].'/WomenOfWorshipUS.com/admin/uploaded_gallery_images/' . $image;
                        $thumbnail = $_SERVER['DOCUMENT_ROOT'].'/WomenOfWorshipUS.com/admin/uploaded_gallery_images/' . $thumbnail;
                    }
                    else {
                        // Execute if server is not localhost
                        $image = $_SERVER['DOCUMENT_ROOT'].'/admin/uploaded_gallery_images/' . $image;
                        $thumbnail = $_SERVER['DOCUMENT_ROOT'].'/admin/uploaded_gallery_images/' . $thumbnail;
                    }
                    
                    /*
                    // Testing
                    echo '$image: ' . $image . '<br>';
                    echo '$thumbnail: ' . $thumbnail . '<br>';
                    echo '$server: ' . $server;
                    exit();
                    */
                    
                    // Check if image and thumbnail exist; if true delete images
                    if(file_exists($image)){
                        unlink($image);
                    }
                    if(file_exists($thumbnail)){
                        unlink($thumbnail);
                    }                   
                    
                    // Set queried table name to variable
                    $table = 'gallery';

                    // Connect to database
                    include 'includes/dbconnect.php';                 
                    
                    // Delete gallery image data from database
                    try{
                        $sql = "DELETE FROM $table
                                WHERE id = :id";
                        $s = $db->prepare($sql);
                        $s->bindValue(':id', $id);
                        if( $s->execute() ){
                            echo "<script>alert('Image successfully deleted!')</script>";
                            echo "<script>window.location.href = 'index.php?goto=view_gallery_images'</script>"; //http://stackoverflow.com/questions/4813879/window-open-target-self-v-window-location-href
                        }                        
                    } 
                    catch (PDOException $e) {
                        $errMsg = 'Error deleting image: ' . $e->getMessage();
                        include 'includes/error.html.php';
                        exit();
                    }
                    
                    exit(); 
                }
                ?>
                
                
<!-- - - - - - - - - - - - - - - - - - - - - -  STORE  - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -  -->
                
                <!--- - - - - - - - - - - - - - - - -   Add product    - - - - - - - - - - - - - - - - -  -->
                <?php
                if (isset($_GET['goto']) && $_GET['goto'] === 'add_product'){
                    
                    // Set page title to variable
                    $page_title = 'Add new product'; 
                    
                    include 'includes/dbconnect.php';
                    $table = 'category';

                    try {
                        $sql = "SELECT * FROM $table";
                        $s = $db->prepare($sql);
                        $s->execute();

                        while ($row = $s->fetch(PDO::FETCH_ASSOC)) {
                            $categories[] = array(
                                'id' => $row['id'],
                                'name' => $row['name']
                            );
                        }
                    } catch (PDOException $e) {
                        $errMsg = 'Unable to retrieve data from database' . $e->getMessage();
                        include 'includes/error.html.php';
                        exit();
                    }

                    // Close database connection
                    $db = null;  

                    include 'add-new-product-form.html.php';
                    exit();
                }
                ?>
                
                

                <!-- - - - - - - - - - - - - - - - - - Insert new product into database  - - - - - - - - - - - - - - - - - -->
                <?php
                if (isset($_POST['action']) && $_POST['action'] === 'insert_product') {

                    //include 'includes/helper.php';
                    $errMsg[] = array();

                    $category_id = sanitize($_POST['category_id']);
                    $category_name = sanitize($_POST['category_name']);
                    $name = sanitize($_POST['name']);
                    $inscription = sanitize($_POST['inscription']);
                    $description = sanitize($_POST['description']);
                    $size = sanitize($_POST['size']);
                    $product_image = $_FILES['product_image']['name'];
                    $product_image_tmp = $_FILES['product_image']['tmp_name'];
                    $price = sanitize($_POST['price']);

                    // Check if category selected
                    if(empty($category_id)){
                        $errMsg = 'You must select a product category. Please try again.';
                        include 'includes/error.html.php';
                        exit();
                    }
                    
                    // Check if image file selected
                    if(empty($_FILES['product_image']['name'])){
                        $errMsg = 'You must select an image file for upload. Please try again.';
                        include 'includes/error.html.php';
                        exit();
                    }
                    
                    // Move uploaded file to assigned folder (here "uploaded_product_images") http://php.net/manual/en/function.move-uploaded-file.php
                    move_uploaded_file($product_image_tmp, "uploaded_product_images/$product_image");

                    include 'includes/dbconnect.php';
                    $table = 'products';

                    try {
                        $sql = "INSERT INTO $table SET
                                category_id = :category_id,
                                category_name = :category_name,
                                name = :name,
                                inscription = :inscription,
                                description = :description,
                                size = :size,
                                image = :image,
                                price = :price";

                        $s = $db->prepare($sql);
                        $s->bindValue(':category_id', $category_id);
                        $s->bindValue(':category_name', $category_name);
                        $s->bindValue(':name', $name);
                        $s->bindValue(':inscription', $inscription);
                        $s->bindValue(':description', $description);
                        $s->bindValue(':size', $size);
                        $s->bindValue(':image', $product_image);
                        $s->bindValue(':price', $price);
                        if( $s->execute() ){
                            echo "<script>alert('New product added!')</script>";
                            echo "<script>window.location.href = 'index.php?goto=add_product'</script>";
                        } 
                    }
                    catch (PDOException $e) {
                        $errMsg = 'Error inserting data into database: ' . $e->getMessage();
                        include 'includes/error.html.php';
                        exit();
                    }

                    // Close database connection
                    $db = null;

                    //header('Location: .');
                    exit();
                } 
                ?>
                
                
                <!-- - - - - - - - - - - - - - - - - -  Edit product  - - - - - - - - - - - - - - - - -  -->
                <?php        
                if(isset($_GET['edit_product'])){
                    
                    $id = htmlspecialchars($_GET['edit_product']);
                    
                    $table = 'products';
                    $page_title = 'Edit product';
                    
                    // Connect to database
                    include 'includes/dbconnect.php';

                    try {
                        $sql = "SELECT * FROM $table
                                WHERE id = :id";
                        $s = $db->prepare($sql);
                        $s->bindValue(':id', $id);
                        $s->execute();

                        // Store results in $images array
                        while($row = $s->fetch(PDO::FETCH_ASSOC)){
                            $products[] = array(
                                'id' => $row['id'],
                                'category_id' => $row['category_id'],
                                'category_name' => $row['category_name'],
                                'name' => $row['name'],
                                'inscription' => $row['inscription'],
                                'description' => $row['description'],
                                'size' => $row['size'],
                                'image' => $row['image'],
                                'price' => $row['price']
                            );
                        }
                    } 
                    catch (PDOException $e) {
                        $errMsg = 'Error fetching images: ' . $e->getMessage();
                        include 'includes/error.html.php';
                        exit();
                    }

                    // Close database connection
                    $db = null;
                                        
                    include 'edit-product-form.html.php';
                    exit();
                }                              
                ?>
                
                
                <!-- - - - - - - - - - - - - - - - - -  Update product  - - - - - - - - - - - - - - - - -  -->
                <?php
                if(isset($_POST['action']) && $_POST['action'] === 'update_product'){
                    
                    // Sanitize and post values
                    $id = sanitize($_POST['id']);
                    $category_id = sanitize($_POST['category_id']);
                    $name = sanitize($_POST['name']);
                    $inscription = sanitize($_POST['inscription']);
                    $description = sanitize($_POST['description']);
                    $size = sanitize($_POST['size']);
                    $product_image = $_FILES['product_image']['name'];
                    $product_image_tmp = $_FILES['product_image']['tmp_name'];
                    $price = sanitize($_POST['price']);
                    
                    // Move uploaded file to assigned folder (here "uploaded_product_images") http://php.net/manual/en/function.move-uploaded-file.php
                    move_uploaded_file($product_image_tmp, "uploaded_product_images/$product_image");

                    // Set queried table name to variable
                    $table = 'products';

                    // Connect to database
                    include 'includes/dbconnect.php';

                    try {
                        $sql = "UPDATE $table SET
                                category_id = :category_id,
                                name = :name,
                                inscription = :inscription,
                                description = :description,
                                size = :size,
                                image = :image,
                                price = :price
                                WHERE id = :id";
                        $s = $db->prepare($sql);
                        $s->bindValue(':id', $id);
                        $s->bindValue(':category_id', $category_id);
                        //$s->bindValue(':category_name', $category_name);
                        $s->bindValue(':name', $name);
                        $s->bindValue(':inscription', $inscription);
                        $s->bindValue(':description', $description);
                        $s->bindValue(':size', $size);
                        $s->bindValue(':image', $product_image);
                        $s->bindValue(':price', $price);
                        if( $s->execute() ){
                            echo "<script>alert('Product successfully updated!')</script>";
                            echo "<script>window.location.href = 'index.php?goto=view_products'</script>";
                        }  
                    }
                    catch (PDOException $e) {
                        $errMsg = 'Error updating database:' . $e->getMessage();
                        include 'includes/error.html.php';
                        exit();
                    }

                    // Close database connection
                    $db = null;

                    // Exit
                    exit(); 
                }              
                ?>
                
                
                <!-- - - - - - - - - - - - - - - - - -  Delete product  - - - - - - - - - - - - - - - - -  -->
                <?php
                if(isset($_GET['delete_product'])){
                    
                    // Get image id from GET variable
                    $id = sanitize($_GET['delete_product']);
                    $image = sanitize($_GET['image']);
                    
                    if(isset($server) && $server === 'localhost'){
                        // Execute if server is localhost 
                        $image = $_SERVER['DOCUMENT_ROOT'].'/WomenOfWorshipUS.com/admin/uploaded_product_images/' . $image;
                    }
                    else {
                        // Execute if server is not localhost
                        $image = $_SERVER['DOCUMENT_ROOT'].'/admin/uploaded_product_images/' . $image;
                    }
                    
                    /*
                    // Testing
                    echo '$image: ' . $image . '<br>';
                    echo '$server: ' . $server;
                    exit();
                    */
                    
                    // Check if image and thumbnail exist; if true delete images
                    if(file_exists($image)){
                        unlink($image);
                    }
      
                                                       
                    // Set queried table name to variable
                    $table = 'products';

                    // Connect to database
                    include 'includes/dbconnect.php';
                    
                    try{
                        $sql = "DELETE FROM $table
                                WHERE id = :id";
                        $s = $db->prepare($sql);
                        $s->bindValue(':id', $id);
                        if( $s->execute() ){
                            echo "<script>alert('Product successfully deleted!')</script>";
                            echo "<script>window.location.href = 'index.php?goto=view_products'</script>"; //http://stackoverflow.com/questions/4813879/window-open-target-self-v-window-location-href
                        }                        
                    } 
                    catch (PDOException $e) {
                        $errMsg = 'Error deleting image: ' . $e->getMessage();
                        include 'includes/error.html.php';
                        exit();
                    }
                    
                    exit(); 
                }
                ?>
                
                
                
                
                <!-- - - - - - - - - - - - - - - - - -  View products   - - - - - - - - - - - - - - - - - -->
                <?php
                if (isset($_GET['goto']) && $_GET['goto'] === 'view_products') {                   
                    
                    $page_title = 'Products';
                    $table = 'products';
                    
                    // Connect to database
                    include 'includes/dbconnect.php';                   
                    
                    try {
                        $sql = "SELECT * FROM $table ORDER BY category_id";
                        $s = $db->prepare($sql);
                        $s->execute();

                        while ($row = $s->fetch(PDO::FETCH_ASSOC)) {
                            $products[] = array(
                                'id' => $row['id'],
                                'category_id' => $row['category_id'],
                                'category_name' => $row['category_name'],
                                'name' => $row['name'],
                                'inscription' => $row['inscription'],
                                'description' => $row['description'],
                                'size' => $row['size'],
                                'image' => $row['image'],
                                'price' => $row['price']                             
                            );
                        }
                    } 
                    catch (PDOException $e) {
                        $errMsg = 'Unable to retrieve data from database' . $e->getMessage();
                        include 'includes/error.html.php';
                        exit();
                    }

                    // Close database connection
                    $db = null;
                  
                    include 'view-products.html.php';
                    exit();
                }
                ?>
                
                
                
                <!-- - - - - - - - - - - - - - - - - -  Create new product category    - - - - - - - - - - - - - - - - - -->
                <?php
                if (isset($_GET['goto']) && $_GET['goto'] === 'add_product_category') {
                    
                    $page_title = 'Add new product category';
                    
                    include 'includes/dbconnect.php';
                    $table = 'category';

                    try {
                        $sql = "SELECT * FROM $table";
                        $s = $db->prepare($sql);
                        $s->execute();

                        while ($row = $s->fetch(PDO::FETCH_ASSOC)) {
                            $categories[] = array(
                                'id' => $row['id'],
                                'name' => $row['name']
                            );
                        }
                    } catch (PDOException $e) {
                        $errMsg = 'Unable to retrieve data from database' . $e->getMessage();
                        include 'includes/error.html.php';
                        exit();
                    }

                    // Close database connection
                    $db = null;
                    

                    include 'add-new-product-category-form.html.php';
                    exit();                   
                }                
                ?>
                
                
                <!-- - - - - - - - - - - - - - - - - -  Insert new product category  - - - - - - - - - - - - - - - - - -->
                <?php               
                if (isset($_POST['action']) && $_POST['action'] === 'add_new_product_category') {

                    $table = 'category';

                    // Sanitize and store user data in variable
                    $new_product_category_name = sanitize($_POST['new_product_category']);

                    // Connect to database
                    include 'includes/dbconnect.php';

                    // Insert new category into database
                    try {
                        $sql = "INSERT INTO $table SET
                                name = :name";
                        $s = $db->prepare($sql);
                        $s->bindValue(':name', $new_product_category_name);
                        if($s->execute()){
                            echo "<script>alert('New product category added!')</script>";
                            echo "<script>window.location.href = 'index.php?goto=view_product_categories'</script>";  //http://stackoverflow.com/questions/4813879/window-open-target-self-v-window-location-href
                        }
                    } 
                    catch (PDOException $e) {
                        $errMsg  = 'Error adding data to database: ' . $e->getMessage();
                        include 'includes/error.html.php';
                        exit();
                    }

                    // Close database connection
                    $db = null;

                    // Exit
                    exit();   
                }
                ?>
                
                
                <!-- - - - - - - - - - - - - - - - - -  View Product Categories  - - - - - - - - - - - - - - - - - -->
                <?php
                if(isset($_GET['goto']) && $_GET['goto'] === 'view_product_categories'){
                    
                    // Assign queried table name to variable
                    $table = 'category';
                    $page_title = 'View product categories';

                    // Connect to database
                    include 'includes/dbconnect.php';

                    try {
                        $sql = "SELECT * FROM $table";
                        $s = $db->prepare($sql);
                        $s->execute();

                        // Store results in $images array
                        while($row = $s->fetch(PDO::FETCH_ASSOC)){
                            $categories[] = array(
                                'id' => $row['id'],
                                'name' => $row['name']
                            );
                        }                       
                    } 
                    catch (PDOException $e) {
                        $errMsg = 'Error fetching images: ' . $e->getMessage();
                        include 'includes/error.html.php';
                        exit();
                    }
                    
                    // Store number of images in variable
                        if(!empty($images)){
                            $gallery_count = count($images);
                        }

                    // Close database connection
                    $db = null;

                    include 'view-product-categories.html.php';
                    exit();
                }
                ?>
                
                
                <!-- - - - - - - - - - - - - - - - - -  Edit product category  - - - - - - - - - - - - - - - - -  -->
                <?php        
                if(isset($_GET['edit_product_category'])){
                    
                    $id = htmlspecialchars($_GET['edit_product_category']);
                    
                    $table = 'category';
                    $page_title = 'Edit product category';
                    
                    // Connect to database
                    include 'includes/dbconnect.php';

                    try {
                        $sql = "SELECT * FROM $table
                                WHERE id = :id";
                        $s = $db->prepare($sql);
                        $s->bindValue(':id', $id);
                        $s->execute();

                        // Store results in $images array
                        while($row = $s->fetch(PDO::FETCH_ASSOC)){
                            $categories[] = array(
                                'id' => $row['id'],
                                'name' => $row['name']
                            );
                        }
                    } 
                    catch (PDOException $e) {
                        $errMsg = 'Error fetching images: ' . $e->getMessage();
                        include 'includes/error.html.php';
                        exit();
                    }

                    // Close database connection
                    $db = null;
                                        
                    include 'edit-product-category-form.html.php';
                    exit();
                }                              
                ?>
                
                
                <!-- - - - - - - - - - - - - - - - - - Update product category  - - - - - - - - - - - - - - - - - -->
                <?php
                if (isset($_POST['action']) && $_POST['action'] === 'update_product_category') {
 

                    // Sanitize and post values
                    $id = sanitize($_POST['id']);
                    $name = sanitize($_POST['name']);

                    // Check if fields have input  
                    if(empty($name)){
                        $errMsg = '*Please fill in the category title field.';
                        include 'includes/error.html.php';
                        exit();
                    } 
                    else {

                        // Set queried table name to variable
                        $table = 'category';

                        // Connect to database
                        include 'includes/dbconnect.php';

                        try {
                            $sql = "UPDATE $table SET
                                   name = :name
                                   WHERE id = :id";
                            $s = $db->prepare($sql);
                            $s->bindValue(':id', $id);
                            $s->bindValue(':name', $name);
                            if( $s->execute() ){
                                echo "<script>alert('Product category title successfully updated!')</script>";
                                echo "<script>window.location.href = 'index.php?goto=view_product_categories'</script>"; //http://stackoverflow.com/questions/4813879/window-open-target-self-v-window-location-href
                            } 
                        }
                        catch (PDOException $e) {
                            $errMsg = 'Error updating database:' . $e->getMessage();
                            include 'includes/error.html.php';
                            exit();
                        }

                        // Close database connection
                        $db = null;

                        // Exit
                        exit(); 
                    }
                }                             
                ?>
                
                
                <!-- - - - - - - - - - - - - - - - - -  Delete Product Category    - - - - - - - - - - - - - - - - -  -->
                <?php
                if (isset($_GET['delete_product_category'])){

                    // Set variables
                    $title = 'Delete Product Category';
                    $table = 'category';                  

                    // Retrieve post_id  value and store in $post_id variable
                    $id = htmlspecialchars($_GET['delete_product_category']);                                     

                    // Connect to database
                    include 'includes/dbconnect.php';

                    // Query database for post data of specified id
                    try {
                        $sql = "DELETE FROM $table
                                WHERE id = :id";
                        $s = $db->prepare($sql);
                        $s->bindValue(':id', $id);
                        if($s->execute()){
                            echo "<script>alert('Product category deleted!')</script>";
                            echo "<script>window.location.href = 'index.php?goto=view_product_categories'</script>";  //http://stackoverflow.com/questions/4813879/window-open-target-self-v-window-location-href
                        }
                    } 
                    catch (PDOException $e) {
                        $errMsg  = 'Error deleting category: ' . $e->getMessage();
                        include 'includes/error.html.php';
                        exit();
                    }

                    // Close database connection
                    $db = null;

                    // Exit
                    exit();   
                }              
                ?>
                
                

                <!-- - - - - - - - - - - - - - - - - -  View Pages  - - - - - - - - - - - - - - - - - -->
                <?php
                if(isset($_GET['goto']) && $_GET['goto'] === 'view_pages'){
                    
                    // Assign queried table name to variable
                    $table = 'pages';
                    $page_title = 'View pages';

                    // Connect to database
                    include 'includes/dbconnect.php';

                    try {
                        $sql = "SELECT * FROM $table";
                        $s = $db->prepare($sql);
                        $s->execute();

                        // Store results in $pages array
                        while($row = $s->fetch(PDO::FETCH_ASSOC)){
                            $pages[] = array(
                                'page_id' => $row['page_id'],
                                'page_name' => $row['page_name'],
                                'page_image' => $row['page_image'],
                                'page_content' => $row['page_content'],
                                'main_menu_name' => $row['main_menu_name'],
                                'main_menu_id' => $row['main_menu_id']
                            );
                        }                        
                    } 
                    catch (PDOException $e) {
                        $errMsg = 'Error fetching images: ' . $e->getMessage();
                        include 'includes/error.html.php';
                        exit();
                    }
                    
                    // Store number of images in variable
                        if(!empty($pages)){
                            $pages_count = count($pages);
                        }

                    // Close database connection
                    $db = null;

                    include 'view-pages.html.php';
                    exit();
                }
                ?>
                
                <!-- - - - - - - - - - - - - - - - - -  Add page  - - - - - - - - - - - - - - - - - -->
                <?php
                if(isset($_GET['goto']) && $_GET['goto'] === 'add_page'){
                    
                    // Assign queried table name to variable
                    $table = 'main_menu';
                    $page_title = 'Add new page';
                    
                    // Connect to database
                    include 'includes/dbconnect.php';
                    
                    try {
                        $sql = "SELECT * FROM $table
                                WHERE main_menu_id < '3'";
                        
                        $s = $db->prepare($sql);
                        $s->execute();
                        
                        while($row = $s->fetch(PDO::FETCH_ASSOC)){
                            $menu[] = array(
                                'main_menu_id' => $row['main_menu_id'],
                                'main_menu_name' => $row['main_menu_name']
                            );
                        }
                    } 
                    catch (PDOException $e) {
                        $errMsg = 'Error fetching menu items: ' . $e->getMessage();
                        include 'includes/error.html.php';
                        exit();
                    }
                   
                    include 'add-new-page-form.html.php';
                    exit();
                }

                ?>
                
                
                <!-- - - - - - - - - - - - - - - - - -  Insert page content  - - - - - - - - - - - - - - - - - -->
                <?php
                if(isset($_POST['action']) && $_POST['action'] === 'insert_page_content'){
                                                                                                 
                    // Clean post data and store in variables
                    $page_name = sanitize($_POST['page_name']);
                    
                    // Do not use htmlspecialchars or htmlout filters when posting content b/c it brings HTML tags 
                    $page_content = $_POST['page_content'];
                    $main_menu_name = sanitize($_POST['$main_menu_name']);
                    $main_menu_id = sanitize($_POST['main_menu_id']);
                    
                    
                    // Access $_FILES global array for uploaded file
                    $page_image = $_FILES['page_image']['name'];
                    $page_image_tmp = $_FILES['page_image']['tmp_name'];
                    $file_type = $_FILES['page_image']['type'];
                    $file_size = $_FILES['page_image']['size'];
                    $file_err_msg = $_FILES['page_image']['error'];
                    
                    
                    // Check if image selected for upload
                    if(isset($page_image) && $page_image != ''){

                        // Separate file name into an array by the dot
                        $kaboom = explode(".", $page_image);

                        // Assign last element of array to file_extension variable (in case file has more than one dot)
                        $file_extension = end($kaboom);
               
                    
                        /* - - - - -  Error handling  - - - - - - */

                        // Check if file size < 2 MB
                        if($file_size > 2097152){
                            unlink($page_image_tmp);
                            $errMsg = 'File must be less than 2 Megabytes to upload.';
                            include 'includes/error.html.php';
                            exit();
                        }
                        // Check if file is gif, jpg or png
                        elseif(!preg_match("/\.(gif|jpg|png)$/i", $page_image)){
                            unlink($page_image_tmp);
                            $errMsg = 'Image must be gif, jpg or png to upload.';
                            include 'includes/error.html.php';
                            exit();
                        }
                        // Check for any errors
                        elseif($file_err_msg == 1){
                            $errMsg = 'Error uploading file. Please try again.';
                            include 'includes/error.html.php';
                            exit();
                        }                   
                    
                        // Assign queried table name to variable
                        $table = 'pages';

                        // Connect to database
                        include 'includes/dbconnect.php';

                        // Move uploaded file to assigned folder (here "uploaded_images") http://php.net/manual/en/function.move-uploaded-file.php
                            $move_result = move_uploaded_file($page_image_tmp, "uploaded_page_images/$page_image");

                        // Check for boolean result of move_uploaded_file()                   
                        if ($move_result != true) {
                            unlink($page_image_tmp);
                            $errMsg = 'File not uploaded. Please try again.';
                            include 'includes/error.html.php';
                            exit();
                        }                   
                    
                        try {
                            $sql = "INSERT INTO $table SET
                                    page_name = :page_name,
                                    page_image = :page_image,
                                    page_content = :page_content,
                                    main_menu_name = :main_menu_name,
                                    main_menu_id = :main_menu_id";

                            $s = $db->prepare($sql);
                            $s->bindValue(':page_name', $page_name);
                            $s->bindValue(':page_image', $page_image);
                            $s->bindValue(':page_content', $page_content);
                            $s->bindValue(':main_menu_name', $main_menu_name);
                            $s->bindValue(':main_menu_id', $main_menu_id);
                            if( $s->execute() ){
                                echo "<script>alert('New page created!')</script>";
                                echo "<script>window.location.href = 'index.php?goto=view_pages'</script>";
                            }
                        }
                        catch (PDOException $e) {
                            $errMsg = 'Error inserting data into database: ' . $e->getMessage();
                            include 'includes/error.html.php';
                            exit();
                        }
                    } 
                    else {
                        
                        // Assign queried table name to variable
                        $table = 'pages';

                        // Connect to database
                        include 'includes/dbconnect.php';
                        
                        try {
                            $sql = "INSERT INTO $table SET
                                    page_name = :page_name,
                                    page_image = :page_image,
                                    page_content = :page_content,
                                    main_menu_name = :main_menu_name,
                                    main_menu_id = :main_menu_id";

                            $s = $db->prepare($sql);
                            $s->bindValue(':page_name', $page_name);
                            $s->bindValue(':page_image', NULL);
                            $s->bindValue(':page_content', $page_content);
                            $s->bindValue(':main_menu_name', $main_menu_name);
                            $s->bindValue(':main_menu_id', $main_menu_id);
                            if( $s->execute() ){
                                echo "<script>alert('New page created!')</script>";
                                echo "<script>window.location.href = 'index.php?goto=view_pages'</script>";
                            }
                        }
                        catch (PDOException $e) {
                            $errMsg = 'Error inserting data into database: ' . $e->getMessage();
                            include 'includes/error.html.php';
                            exit();
                        }
                    }
                    
                    // Close database connection
                    $db = null;
                    exit();
                }                   
                ?>
                
                
                <!-- - - - - - - - - - - - - - - - - -  Edit page  - - - - - - - - - - - - - - - - -  -->
                <?php        
                if(isset($_GET['edit_page'])){
                    
                    $page_id = htmlspecialchars($_GET['edit_page']);
                    
                    $table = 'pages';
                    $page_title = 'Edit page';
                    
                    // Connect to database
                    include 'includes/dbconnect.php';

                    try {
                        $sql = "SELECT * FROM $table
                                WHERE page_id = :page_id";
                        $s = $db->prepare($sql);
                        $s->bindValue(':page_id', $page_id);
                        $s->execute();

                        // Store results in $images array
                        while($row = $s->fetch(PDO::FETCH_ASSOC)){
                            $pages[] = array(
                                'page_id' => $row['page_id'],
                                'page_name' => $row['page_name'],
                                'page_image' => $row['page_image'],
                                'page_content' => $row['page_content'],
                                'main_menu_name' => $row['main_menu_name'],
                                'main_menu_id' => $row['main_menu_id']
                            );
                        }
                    } 
                    catch (PDOException $e) {
                        $errMsg = 'Error fetching images: ' . $e->getMessage();
                        include 'includes/error.html.php';
                        exit();
                    }

                    // Close database connection
                    $db = null;
                                        
                    include 'edit-page-form.html.php';
                    exit();
                }                              
                ?>
                
                
                <!-- - - - - - - - - - - - - - - - - - Update page  - - - - - - - - - - - - - - - - - -->
                <?php
                if (isset($_POST['action']) && $_POST['action'] === 'update_page') {
                    
                    // Retrieve form data, clean and store in variables
                    $page_id = sanitize($_POST['page_id']);
                    $page_name = sanitize($_POST['page_name']);                    
                    $page_content = $_POST['page_content'];  // Do not use htmlspecialchars or htmlout filters when posting content b/c it brings HTML tags 
                    $main_menu_name = sanitize($_POST['main_menu_name']);
                    $main_menu_id = sanitize($_POST['main_menu_id']);
                    
                    // Access $_FILES global array for uploaded file
                    $page_image = $_FILES['page_image']['name'];
                    $page_image_tmp = $_FILES['page_image']['tmp_name'];
                    $file_type = $_FILES['page_image']['type'];
                    $file_size = $_FILES['page_image']['size'];
                    $file_err_msg = $_FILES['page_image']['error'];
                    
                    
                    // Check if image selected for upload
                    if(isset($page_image) && $page_image != ''){

                        // Separate file name into an array by the dot
                        $kaboom = explode(".", $page_image);

                        // Assign last element of array to file_extension variable (in case file has more than one dot)
                        $file_extension = end($kaboom);
               
                    
                        /* - - - - -  Error handling  - - - - - - */

                        // Check if file size < 2 MB
                        if($file_size > 2097152){
                            unlink($page_image_tmp);
                            $errMsg = 'File must be less than 2 Megabytes to upload.';
                            include 'includes/error.html.php';
                            exit();
                        }
                        // Check if file is gif, jpg or png
                        elseif(!preg_match("/\.(gif|jpg|png)$/i", $page_image)){
                            unlink($page_image_tmp);
                            $errMsg = 'Image must be gif, jpg or png to upload.';
                            include 'includes/error.html.php';
                            exit();
                        }
                        // Check for any errors
                        elseif($file_err_msg == 1){
                            $errMsg = 'Error uploading file. Please try again.';
                            include 'includes/error.html.php';
                            exit();
                        }                   
                    
                        // Assign queried table name to variable
                        $table = 'pages';

                        // Connect to database
                        include 'includes/dbconnect.php';

                        // Move uploaded file to assigned folder (here "uploaded_images") http://php.net/manual/en/function.move-uploaded-file.php
                            $move_result = move_uploaded_file($page_image_tmp, "uploaded_page_images/$page_image");

                        // Check for boolean result of move_uploaded_file()                   
                        if ($move_result != true) {
                            unlink($page_image_tmp);
                            $errMsg = 'File not uploaded. Please try again.';
                            include 'includes/error.html.php';
                            exit();
                        }                   
                    
                        try {
                            $sql = "UPDATE $table SET
                                    page_name = :page_name,
                                    page_image = :page_image,
                                    page_content = :page_content,
                                    main_menu_name = :main_menu_name,
                                    main_menu_id = :main_menu_id
                                    WHERE page_id = :page_id";

                            $s = $db->prepare($sql);
                            $s->bindValue(':page_id', $page_id);
                            $s->bindValue(':page_name', $page_name);
                            $s->bindValue(':page_image', $page_image);
                            $s->bindValue(':page_content', $page_content);
                            $s->bindValue(':main_menu_name', $main_menu_name);
                            $s->bindValue(':main_menu_id', $main_menu_id);
                            if( $s->execute() ){
                                echo "<script>alert('Page successfully updated!')</script>";
                                echo "<script>window.location.href = 'index.php?goto=view_pages'</script>"; //http://stackoverflow.com/questions/4813879/window-open-target-self-v-window-location-href
                            }
                        }
                        catch (PDOException $e) {
                            $errMsg = 'Error inserting data into database: ' . $e->getMessage();
                            include 'includes/error.html.php';
                            exit();
                        }
                    } 
                    else {
                        
                        // Assign queried table name to variable
                        $table = 'pages';

                        // Connect to database
                        include 'includes/dbconnect.php';
                        
                        try {
                            $sql = "UPDATE $table SET
                                    page_name = :page_name,
                                    page_image = :page_image,
                                    page_content = :page_content,
                                    main_menu_name = :main_menu_name,
                                    main_menu_id = :main_menu_id
                                    WHERE page_id = :page_id";

                            $s = $db->prepare($sql);
                            $s->bindValue(':page_id', $page_id);
                            $s->bindValue(':page_name', $page_name);
                            $s->bindValue(':page_image', NULL);
                            $s->bindValue(':page_content', $page_content);
                            $s->bindValue(':main_menu_name', $main_menu_name);
                            $s->bindValue(':main_menu_id', $main_menu_id);
                            if( $s->execute() ){
                                echo "<script>alert('Page successfully updated!')</script>";
                                echo "<script>window.location.href = 'index.php?goto=view_pages'</script>"; //http://stackoverflow.com/questions/4813879/window-open-target-self-v-window-location-href
                            }
                        }
                        catch (PDOException $e) {
                            $errMsg = 'Error inserting data into database: ' . $e->getMessage();
                            include 'includes/error.html.php';
                            exit();
                        }
                    }
                    
                    // Close database connection
                    $db = null;
                    exit();
                }                          
                ?>
                
                
                <!-- - - - - - - - - - - - - - - - - -  Delete page    - - - - - - - - - - - - - - - - -  -->
                <?php
                if (isset($_GET['delete_page'])){
                    
                    // Retrieve post_id and image values and store in variables
                    $page_id = htmlspecialchars($_GET['delete_page']);
                    $image = htmlspecialchars($_GET['image']);
                    
                    // Check if running locally or at host server and execute if else
                    if(isset($server) && $server === 'localhost'){
                        // Execute if server is localhost 
                        $image = $_SERVER['DOCUMENT_ROOT'].'/WomenOfWorshipUS.com/admin/uploaded_page_images/' . $image;
                    }
                    else {
                        // Execute if server is not localhost
                        $image = $_SERVER['DOCUMENT_ROOT'].'/admin/uploaded_page_images/' . $image;
                    }
                    
                    /*
                    // Testing
                    echo '$image: ' . $image . '<br>';
                    echo '$server: ' . $server;
                    exit();
                    */
                    
                    // Check if image and thumbnail exist; if true delete images
                    if(file_exists($image)){
                        unlink($image);
                    }
                    

                    // Set variables
                    $title = 'Delete Page';
                    $table = 'pages';                                                                          

                    // Connect to database
                    include 'includes/dbconnect.php';

                    // Query database for post data of specified id
                    try {
                        $sql = "DELETE FROM $table
                                WHERE page_id = :page_id";
                        $s = $db->prepare($sql);
                        $s->bindValue(':page_id', $page_id);
                        if($s->execute()){
                            echo "<script>alert('Page deleted!')</script>";
                            echo "<script>window.location.href = 'index.php?goto=view_pages'</script>";  //http://stackoverflow.com/questions/4813879/window-open-target-self-v-window-location-href
                        }
                    } 
                    catch (PDOException $e) {
                        $errMsg  = 'Error deleting category: ' . $e->getMessage();
                        include 'includes/error.html.php';
                        exit();
                    }

                    // Close database connection
                    $db = null;

                    // Exit
                    exit();   
                }              
                ?>
                
                
                <!-- - - - - - - - - - - - - - - - - -  Add New Event  - - - - - - - - - - - - - - - - - -->
                <?php
                if (isset($_GET['goto']) && $_GET['goto'] === 'add_event') {

                    $page_title = 'Add new event';
                                   
                    include 'add-new-event-form.html.php';
                    exit();
                };
                ?>
                
                <!-- - - - - - - - - - - - - - - -   Insert new event  - - - - - - - - - - - - - - - - - -->
                <?php
                // Turn on error reporting for debugging
                error_reporting( E_ALL );
                ini_set( 'display_errors', 1 );
                
                if(isset($_POST['action']) && $_POST['action'] === 'insert_event'){
                                                                                                 
                    // Clean post data and store in variables
                    $event_title = sanitize($_POST['event_title']);
                    $event_date = sanitize($_POST['event_date']);
                    $event_location = sanitize($_POST['event_location']);
                    $event_description = $_POST['event_description'];
                    
                    // Access $_FILES global array for uploaded file
                    $event_image = $_FILES['event_image']['name'];
                    $event_image_tmp = $_FILES['event_image']['tmp_name'];
                    $file_type = $_FILES['event_image']['type'];
                    $file_size = $_FILES['event_image']['size'];
                    $file_err_msg = $_FILES['event_image']['error'];
                    
                    
                    // Check if image selected for upload
                    if(isset($event_image) && $event_image != ''){

                        // Separate file name into an array by the dot
                            $kaboom = explode(".", $event_image);

                        // Assign last element of array to file_extension variable (in case file has more than one dot)
                            $file_extension = end($kaboom);
               
                    
                        /* - - - - -  Error handling  - - - - - - */

                        // Check if file size < 2 MB
                        if($file_size > 2097152){
                            unlink($event_image_tmp);
                            $errMsg = 'File must be less than 2 Megabytes to upload.';
                            include 'includes/error.html.php';
                            exit();
                        }
                        // Check if file is gif, jpg or png
                        elseif(!preg_match("/\.(gif|jpg|png)$/i", $event_image)){
                            unlink($event_image_tmp);
                            $errMsg = 'Image must be gif, jpg or png to upload.';
                            include 'includes/error.html.php';
                            exit();
                        }
                        // Check for any errors
                        elseif($file_err_msg == 1){
                            $errMsg = 'Error uploading file. Please try again.';
                            include 'includes/error.html.php';
                            exit();
                        }                   
                    
                        // Assign queried table name to variable
                        $table = 'events';

                        // Connect to database
                        include 'includes/dbconnect.php';

                        // Move uploaded file to assigned folder (here "uploaded_images") http://php.net/manual/en/function.move-uploaded-file.php
                            $move_result = move_uploaded_file($event_image_tmp, "uploaded_event_images/$event_image");

                        // Check for boolean result of move_uploaded_file()                   
                        if ($move_result != true) {
                            unlink($event_image_tmp);
                            $errMsg = 'File not uploaded. Please try again.';
                            include 'includes/error.html.php';
                            exit();
                        } 
                    
                        try {
                            $sql = "INSERT INTO $table SET
                                    event_title = :event_title,
                                    event_date = :event_date,
                                    event_location = :event_location,
                                    event_description = :event_description,
                                    event_image = :event_image";

                            $s = $db->prepare($sql);
                            $s->bindValue(':event_title', $event_title);
                            $s->bindValue(':event_date', $event_date);
                            $s->bindValue(':event_location', $event_location);                      
                            $s->bindValue(':event_image', $event_image);
                            $s->bindValue(':event_description', $event_description);
                            if( $s->execute() ){
                                echo "<script>alert('New event added!')</script>";
                                echo "<script>window.location.href = 'index.php?goto=view_events'</script>";
                            }
                        }
                        catch (PDOException $e) {
                            $errMsg = 'Error inserting data into database: ' . $e->getMessage();
                            include 'includes/error.html.php';
                            exit();
                        }
                    }
                    else{
                        // Assign queried table name to variable
                        $table = 'events';

                        // Connect to database
                        include 'includes/dbconnect.php';
                        
                         try {
                            $sql = "INSERT INTO $table SET
                                    event_title = :event_title,
                                    event_date = :event_date,
                                    event_location = :event_location,
                                    event_description = :event_description,
                                    event_image = :event_image";

                            $s = $db->prepare($sql);
                            $s->bindValue(':event_title', $event_title);
                            $s->bindValue(':event_date', $event_date);
                            $s->bindValue(':event_location', $event_location);                      
                            $s->bindValue(':event_image', NULL);
                            $s->bindValue(':event_description', $event_description);
                            if( $s->execute() ){
                                echo "<script>alert('New event added!')</script>";
                                echo "<script>window.location.href = 'index.php?goto=view_events'</script>";
                            }
                        }
                        catch (PDOException $e) {
                            $errMsg = 'Error inserting data into database: ' . $e->getMessage();
                            include 'includes/error.html.php';
                            exit();
                        }                      
                    }

                    // Close database connection
                    $db = null;
                    exit();
                }                   
                ?>
                
                
                <!-- - - - - - - - - - - - - - - - - -  View Events  - - - - - - - - - - - - - - - - - -->
                <?php
                if(isset($_GET['goto']) && $_GET['goto'] === 'view_events'){
                    
                    // Assign queried table name to variable
                    $table = 'events';
                    $page_title = 'View events';

                    // Connect to database
                    include 'includes/dbconnect.php';

                    try {
                        $sql = "SELECT * FROM $table ORDER BY event_date";
                        $s = $db->prepare($sql);
                        $s->execute();
                        
                        // Store query results in $results array as PDO object using fetchAll() (instead of creating array with while loop)
                        $results = $s->fetchAll(PDO::FETCH_OBJ);
                        
                        
                        /*
                        echo '<pre>';
                        print_r($results);
                        echo '</pre>';
                        exit();
                        */
                        /*
                        // Store results in $pages array
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
                        */
                    } 
                    catch (PDOException $e) {
                        $errMsg = 'Error fetching images: ' . $e->getMessage();
                        include 'includes/error.html.php';
                        exit();
                    }
                    
                    // Store number of images in variable
                        if(!empty($events)){
                            $pages_count = count($events);
                        }

                    // Close database connection
                    $db = null;

                    include 'view-events.html.php';
                    exit();
                }
                ?>
                
                
                <!-- - - - - - - - - - - - - - - - - -  Edit Event  - - - - - - - - - - - - - - - - -  -->
                <?php        
                if(isset($_GET['edit_event'])){
                    
                    $event_id = htmlspecialchars($_GET['edit_event']);
                    
                    $table = 'events';
                    $page_title = 'Edit event';
                    
                    // Connect to database
                    include 'includes/dbconnect.php';

                    try {
                        $sql = "SELECT * FROM $table
                                WHERE event_id = :event_id";
                        $s = $db->prepare($sql);
                        $s->bindValue(':event_id', $event_id);
                        $s->execute();

                        // Store results in $images array
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
                        $errMsg = 'Error fetching images: ' . $e->getMessage();
                        include 'includes/error.html.php';
                        exit();
                    }

                    // Close database connection
                    $db = null;
                                        
                    include 'edit-event-form.html.php';
                    exit();
                }                              
                ?>
                
                
                <!-- - - - - - - - - - - - - - - - - - Update Event  - - - - - - - - - - - - - - - - - -->
                <?php
                // Turn on error reporting for debugging
                error_reporting( E_ALL );
                ini_set( 'display_errors', 1 );
                
                if(isset($_POST['action']) && $_POST['action'] === 'update_event'){
                                                                                                 
                    // Clean post data and store in variables
                    $event_id = sanitize($_POST['event_id']);
                    $event_title = sanitize($_POST['event_title']);
                    $event_date = sanitize($_POST['event_date']);
                    $event_location = sanitize($_POST['event_location']);
                    $event_description = $_POST['event_description'];
                    
                    // Access $_FILES global array for uploaded file
                    $event_image = $_FILES['event_image']['name'];
                    $event_image_tmp = $_FILES['event_image']['tmp_name'];
                    $file_type = $_FILES['event_image']['type'];
                    $file_size = $_FILES['event_image']['size'];
                    $file_err_msg = $_FILES['event_image']['error'];
                    
                    
                    // Check if image selected for upload
                    if(isset($event_image) && $event_image != ''){

                        // Separate file name into an array by the dot
                            $kaboom = explode(".", $event_image);

                        // Assign last element of array to file_extension variable (in case file has more than one dot)
                            $file_extension = end($kaboom);
               
                    
                        /* - - - - -  Error handling  - - - - - - */

                        // Check if file size < 2 MB
                        if($file_size > 2097152){
                            unlink($event_image_tmp);
                            $errMsg = 'File must be less than 2 Megabytes to upload.';
                            include 'includes/error.html.php';
                            exit();
                        }
                        // Check if file is gif, jpg or png
                        elseif(!preg_match("/\.(gif|jpg|png)$/i", $event_image)){
                            unlink($event_image_tmp);
                            $errMsg = 'Image must be gif, jpg or png to upload.';
                            include 'includes/error.html.php';
                            exit();
                        }
                        // Check for any errors
                        elseif($file_err_msg == 1){
                            $errMsg = 'Error uploading file. Please try again.';
                            include 'includes/error.html.php';
                            exit();
                        }                   
                    
                        // Assign queried table name to variable
                        $table = 'events';

                        // Connect to database
                        include 'includes/dbconnect.php';

                        // Move uploaded file to assigned folder (here "uploaded_images") http://php.net/manual/en/function.move-uploaded-file.php
                            $move_result = move_uploaded_file($event_image_tmp, "uploaded_event_images/$event_image");

                        // Check for boolean result of move_uploaded_file()                   
                        if ($move_result != true) {
                            unlink($event_image_tmp);
                            $errMsg = 'File not uploaded. Please try again.';
                            include 'includes/error.html.php';
                            exit();
                        } 
                    
                        try {
                            $sql = "INSERT INTO $table SET
                                    event_title = :event_title,
                                    event_date = :event_date,
                                    event_location = :event_location,
                                    event_description = :event_description,
                                    event_image = :event_image";

                            $s = $db->prepare($sql);
                            $s->bindValue(':event_title', $event_title);
                            $s->bindValue(':event_date', $event_date);
                            $s->bindValue(':event_location', $event_location);                      
                            $s->bindValue(':event_image', $event_image);
                            $s->bindValue(':event_description', $event_description);
                            if( $s->execute() ){
                                echo "<script>alert('New event added!')</script>";
                                echo "<script>window.location.href = 'index.php?goto=view_events'</script>";
                            }
                        }
                        catch (PDOException $e) {
                            $errMsg = 'Error inserting data into database: ' . $e->getMessage();
                            include 'includes/error.html.php';
                            exit();
                        }
                    }
                    else{
                        // Assign queried table name to variable
                        $table = 'events';

                        // Connect to database
                        include 'includes/dbconnect.php';
                        
                         try {
                            $sql = "INSERT INTO $table SET
                                    event_title = :event_title,
                                    event_date = :event_date,
                                    event_location = :event_location,
                                    event_description = :event_description,
                                    event_image = :event_image";

                            $s = $db->prepare($sql);
                            $s->bindValue(':event_title', $event_title);
                            $s->bindValue(':event_date', $event_date);
                            $s->bindValue(':event_location', $event_location);                      
                            $s->bindValue(':event_image', NULL);
                            $s->bindValue(':event_description', $event_description);
                            if( $s->execute() ){
                                echo "<script>alert('New event added!')</script>";
                                echo "<script>window.location.href = 'index.php?goto=view_events'</script>";
                            }
                        }
                        catch (PDOException $e) {
                            $errMsg = 'Error inserting data into database: ' . $e->getMessage();
                            include 'includes/error.html.php';
                            exit();
                        }                      
                    }

                    // Close database connection
                    $db = null;
                    exit();
                }                                         
                ?>
                
                
                <!-- - - - - - - - - - - - - - - - - -  Delete Event    - - - - - - - - - - - - - - - - -  -->
                <?php
                if (isset($_GET['delete_event'])){
                    
                    // Get image id from GET variable
                    $event_id = htmlspecialchars($_GET['delete_event']);
                    $image = sanitize($_GET['image']);
                                        
                    if(isset($server) && $server === 'localhost'){
                        // Execute if server is localhost 
                        $image = $_SERVER['DOCUMENT_ROOT'].'/WomenOfWorshipUS.com/admin/uploaded_event_images/' . $image;
                    }
                    else {
                        // Execute if server is not localhost
                        $image = $_SERVER['DOCUMENT_ROOT'].'/admin/uploaded_event_images/' . $image;
                    }
                    
                    /*
                    // Testing
                    echo '$image: ' . $image . '<br>';
                    echo '$server: ' . $server;
                    exit();
                    */
                    
                    // Check if image and thumbnail exist; if true delete images
                    if(file_exists($image)){
                        unlink($image);
                    }
                    
                    // Set queried tabel to variable
                    $table = 'events';                                                     

                    // Connect to database
                    include 'includes/dbconnect.php';

                    // Query database for post data of specified id
                    try {
                        $sql = "DELETE FROM $table
                                WHERE event_id = :event_id";
                        $s = $db->prepare($sql);
                        $s->bindValue(':event_id', $event_id);
                        if($s->execute()){
                            echo "<script>alert('Event deleted!')</script>";
                            echo "<script>window.location.href = 'index.php?goto=view_events'</script>";  //http://stackoverflow.com/questions/4813879/window-open-target-self-v-window-location-href
                        }
                    } 
                    catch (PDOException $e) {
                        $errMsg  = 'Error deleting category: ' . $e->getMessage();
                        include 'includes/error.html.php';
                        exit();
                    }

                    // Close database connection
                    $db = null;

                    // Exit
                    exit();   
                }              
                ?>
                
                
                <!-- - - - - - - - - - - - - - - - - -  View Menu  - - - - - - - - - - - - - - - - - -->
                <?php
                if(isset($_GET['goto']) && $_GET['goto'] === 'view_menu'){
                    
                    // Assign queried table name to variable
                    $table = 'main_menu';
                    $page_title = 'View menu';

                    // Connect to database
                    include 'includes/dbconnect.php';

                    try {
                        $sql = "SELECT * FROM $table";
                        $s = $db->prepare($sql);
                        $s->execute();

                        // Store results in $pages array
                        while($row = $s->fetch(PDO::FETCH_ASSOC)){
                            $menu[] = array(
                                'main_menu_id' => $row['main_menu_id'],
                                'main_menu_name' => $row['main_menu_name']
                            );
                        }                        
                    } 
                    catch (PDOException $e) {
                        $errMsg = 'Error fetching images: ' . $e->getMessage();
                        include 'includes/error.html.php';
                        exit();
                    }
                    

                    // Close database connection
                    $db = null;

                    include 'view-menu.html.php';
                    exit();
                }
                ?>
                
                
                <!-- - - - - - - - - - - - - - - - - -  Edit Menu    - - - - - - - - - - - - - - - - - -->
                <?php
                if (isset($_GET['edit_menu'])){

                    // Set variables
                    $page_title = 'Edit menu name';
                    $table = 'main_menu';

                    // Retrieve post_id  value and store in $post_id variable
                    $main_menu_id = sanitize($_GET['edit_menu']);

                    // Connect to database
                    include 'includes/dbconnect.php';

                    // Query database for post data of specified id
                    try {
                        $sql = "SELECT * FROM $table
                                WHERE main_menu_id = :main_menu_id";
                        $s = $db->prepare($sql);
                        $s->bindValue(':main_menu_id', $main_menu_id);
                        $s->execute();

                        // Store results in $posts array
                        while ($row = $s->fetch(PDO::FETCH_ASSOC)){
                            $menu[] = array(
                                'main_menu_id' => $row['main_menu_id'],  
                                'main_menu_name' => $row['main_menu_name']
                            );
                        }
                    } 
                    catch (PDOException $e) {
                        $errMsg  = 'Error fetching data: ' . $e->getMessage();
                        include 'includes/error.html.php';
                        exit();
                    }

                    // Close database connection
                    $db = null;

                    // Include form to display results for editing
                    include 'edit-menu-form.html.php';
                    exit();
                } 
                ?>
                
                
                <!-- - - - - - - - - - - - - - - - - - Update menu  - - - - - - - - - - - - - - - - - -->
                <?php
                if (isset($_POST['action']) && $_POST['action'] === 'update_menu') {
 

                    // Sanitize and post values
                    $main_menu_id = sanitize($_POST['main_menu_id']);
                    $main_menu_name = sanitize($_POST['main_menu_name']);

                    // Check if fields have input  
                    if(empty($main_menu_name)){
                        $errMsg = '*Please fill in the menu name field.';
                        include 'includes/error.html.php';
                        exit();
                    } 
                    else {

                        // Set queried table name to variable
                        $table = 'main_menu';

                        // Connect to database
                        include 'includes/dbconnect.php';

                        try {
                            $sql = "UPDATE $table SET
                                   main_menu_name = :main_menu_name
                                   WHERE main_menu_id = :main_menu_id";
                            $s = $db->prepare($sql);
                            $s->bindValue(':main_menu_id', $main_menu_id);
                            $s->bindValue(':main_menu_name', $main_menu_name);
                            if( $s->execute() ){
                                echo "<script>alert('Menu name successfully updated!')</script>";
                                echo "<script>window.location.href = 'index.php?goto=view_menu'</script>"; //http://stackoverflow.com/questions/4813879/window-open-target-self-v-window-location-href
                            } 
                        }
                        catch (PDOException $e) {
                            $errMsg = 'Error updating database:' . $e->getMessage();
                            include 'includes/error.html.php';
                            exit();
                        }

                        // Close database connection
                        $db = null;

                        // Exit
                        exit(); 
                    }
                }                             
                ?>
                
                
                <!-- - - - - - - - - - - - - - - - - -  Add new menu    - - - - - - - - - - - - - - - - - -->
                <?php
                if (isset($_GET['goto']) && $_GET['goto'] === 'add_menu') {
                    
                    $page_title = 'Add new menu';
                    
                    include 'includes/dbconnect.php';
                    $table = 'main_menu';

                    try {
                        $sql = "SELECT * FROM $table
                                WHERE main_menu_id < '3'";
                        $s = $db->prepare($sql);
                        $s->execute();

                        while ($row = $s->fetch(PDO::FETCH_ASSOC)) {
                            $menu[] = array(
                                'main_menu_id' => $row['main_menu_id'],
                                'main_menu_name' => $row['main_menu_name']
                            );
                        }
                    } catch (PDOException $e) {
                        $errMsg = 'Unable to retrieve data from database' . $e->getMessage();
                        include 'includes/error.html.php';
                        exit();
                    }

                    // Close database connection
                    $db = null;
                   
                    include 'add-new-menu-form.html.php';
                    exit();                   
                }                
                ?>
                
                
                <!-- - - - - - - - - - - - - - - - - - Insert new menu  - - - - - - - - - - - - - - - - - -->
                <?php
                if (isset($_POST['action']) && $_POST['action'] === 'add_new_menu') {

                    //include 'includes/helper.php';
                    $errMsg[] = array();

                    $new_menu = sanitize($_POST['new_menu']);



                    // Check if category selected
                    if(empty($new_menu)){
                        $errMsg = 'You must enter a menu name. Please try again.';
                        include 'includes/error.html.php';
                        exit();
                    }
                    
                    // Connect to database
                    include 'includes/dbconnect.php';
                    
                    // Assign queried table name to variable
                    $table = 'main_menu';

                    try {
                        $sql = "INSERT INTO $table SET         
                                main_menu_name = :main_menu_name";

                        $s = $db->prepare($sql);
                        $s->bindValue(':main_menu_name', $new_menu);
                        if( $s->execute() ){
                            echo "<script>alert('New menu added!')</script>";
                            echo "<script>window.location.href = 'index.php?goto=view_menu'</script>";
                        } 
                    }
                    catch (PDOException $e) {
                        $errMsg = 'Error inserting data into database: ' . $e->getMessage();
                        include 'includes/error.html.php';
                        exit();
                    }

                    // Close database connection
                    $db = null;

                    //header('Location: .');
                    exit();
                } 
                ?>
                
                
                
                <!-- - - - - - - - - - - - - - - - - -  Delete Menu    - - - - - - - - - - - - - - - - -  -->
                <?php
                if (isset($_GET['delete_menu'])){
                    
                    // Get image id from GET variable
                    $main_menu_id = htmlspecialchars($_GET['delete_menu']);                                        
                    
                    // Set queried tabel to variable
                    $table = 'main_menu';                                                     

                    // Connect to database
                    include 'includes/dbconnect.php';

                    // Query database for post data of specified id
                    try {
                        $sql = "DELETE FROM $table
                                WHERE main_menu_id = :main_menu_id";
                        $s = $db->prepare($sql);
                        $s->bindValue(':main_menu_id', $main_menu_id);
                        if($s->execute()){
                            echo "<script>alert('Menu deleted!')</script>";
                            echo "<script>window.location.href = 'index.php?goto=view_menu'</script>";  //http://stackoverflow.com/questions/4813879/window-open-target-self-v-window-location-href
                        }
                    } 
                    catch (PDOException $e) {
                        $errMsg  = 'Error deleting category: ' . $e->getMessage();
                        include 'includes/error.html.php';
                        exit();
                    }

                    // Close database connection
                    $db = null;

                    // Exit
                    exit();   
                }              
                ?>
                
                
                
                
                      
                <p class="red"><?php if (isset($_SESSION['message'])) echo htmlspecialchars($_SESSION['message']); ?></p>

            </div><!--  // .col-md-10  -->

        </div><!-- // .row -->

</div><!-- // .container -->

<?php
include 'includes/footer.php';