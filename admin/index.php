<?php
/*
 *  Controller for admin panel 
 */

$server = htmlspecialchars($_SERVER['SERVER_NAME']);

require 'includes/access.inc.php';

// Check if user is logged in; if not display login form
if(!userIsLoggedIn()){
    
    $title = 'Login';
    include 'login.html.php';
    exit();
}

// Send email when user logs in
notify_login($_SESSION['email']);


// After SESSION['loggedIn'] === TRUE; include session timeout code for auto logout
//include '../includes/session_life.inc.php';



/* - - - - - - - - - - - - - - - - - Add new post to database  - - - - - - - - - - - - - - - -  */
if (isset($_POST['action']) && $_POST['action'] === 'insert_post_content') {
    
    include 'includes/helper.php';
    $errMsg[] = array();

    $post_category_id = sanitize($_POST['post_category_id']);
    $post_title = sanitize($_POST['post_title']);
    $post_date = date('m-d-Y');
    $post_author = sanitize($_POST['post_author']);
    $post_keywords = sanitize($_POST['post_keywords']);
    $post_image = $_FILES['post_image']['name'];
    $post_image_tmp = $_FILES['post_image']['tmp_name'];
    $post_content = $_POST['post_content'];
       
    /* testing posted variables
    if(isset($post_category_id))echo '$post_category_id isset and = ' . $post_category_id . '<br>'; else echo ' !isset <br>';
    if(isset($post_title))      echo '$post_title isset and = ' . $post_title . '<br>';             else echo ' !isset <br>';
    if(isset($post_date))       echo '$post_date isset and = ' . $post_date . '<br>';               else echo ' !isset <br>';
    if(isset($post_author))     echo '$post_author isset and = ' . $post_author . '<br>';           else echo ' !isset <br>';
    if(isset($post_keywords))   echo '$post_keywords isset and = ' . $post_keywords . '<br>';       else echo ' !isset <br>';
    if(isset($post_image))      echo '$post_image isset and = ' . $post_image . '<br>';             else echo ' !isset <br>';
    if(isset($post_image_tmp))  echo '$post_image_tmp isset and = ' . $post_image_tmp . '<br>';     else echo ' !isset <br>';
    if(isset($post_content))    echo '$post_content isset and = ' . $post_content . '<br>';         else echo ' !isset <br>';
    */
    
// Check if fields have input  
if(!isset($post_title) || $post_title === '' || !isset($post_category_id) || $post_category_id === '' || !isset($post_author) || 
        $post_author === '' || !isset($post_keywords) || $post_keywords === '' || !isset($post_content) || $post_content === '' ){
    
        $errMsg = '*Please fill in all fields before submitting.';
        include 'includes/error.html.php';
        exit();
    } 
    else {
        
        // Move uploaded file to assigned folder (here "uploaded_images") http://php.net/manual/en/function.move-uploaded-file.php
        move_uploaded_file($post_image_tmp, "uploaded_post_images/$post_image");

        include 'includes/dbconnect.php';
        $table = 'posts';

        try {
            $sql = "INSERT INTO $table SET
                    post_category_id = :post_category_id,
                    post_title = :post_title,
                    post_date = :post_date,
                    post_author = :post_author,
                    post_keywords = :post_keywords,
                    post_image = :post_image,
                    post_content = :post_content";

            $s = $db->prepare($sql);
            $s->bindValue(':post_category_id', $post_category_id);
            $s->bindValue(':post_title', $post_title);
            $s->bindValue(':post_date', $post_date);
            $s->bindValue(':post_author', $post_author);
            $s->bindValue(':post_keywords', $post_keywords);
            $s->bindValue(':post_image', $post_image);
            $s->bindValue(':post_content', $post_content);
            if( $s->execute() ){
                echo "<script>alert('New post created!')</script>";
                echo "<script>window.location.href = 'index.php?goto=view_posts'</script>";
                
                /*
                echo "<div style='padding:30px; font-family:Arial;'>";
                echo "<h2 style='color:red;'>New post published!</h2>";
                echo "<p><a href='index.php?goto=newpost'>Add another post</a></p>";
                echo "<p><a href='.'>Go to dashboard</a></p>";
                echo "</div>"; */
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
}


/* - - - - - - - - - - - - - - - - -  Update post  - - - - - - - - - - - - - - - - - */
if (isset($_POST['action']) && $_POST['action'] === 'update_post_content') {
           
    // Include to access functions
    include 'includes/helper.php';  

    // Sanitize and post values
    $post_id = sanitize($_POST['post_id']);
    $post_category_id = sanitize($_POST['post_category_id']);
    $post_title = sanitize($_POST['post_title']);
    $post_author = sanitize($_POST['post_author']);
    $post_keywords = sanitize($_POST['post_keywords']);
    $post_image = $_FILES['post_image']['name'];
    $post_image_tmp = $_FILES['post_image']['tmp_name'];
    $post_content = $_POST['post_content'];
    
    // Check if fields have input  
    if(empty($post_title) || empty($post_category_id) || empty($post_author) || empty($post_keywords) || empty($post_image)|| empty($post_content) ){
        $errMsg = '*Please fill in all fields before submitting (make sure image is selected).';
        include 'includes/error.html.php';
        exit();
    } 
    else {

        // Move uploaded file to assigned folder (here "uploaded_images") http://php.net/manual/en/function.move-uploaded-file.php
        move_uploaded_file($post_image_tmp, "uploaded_post_images/$post_image");
        
        // Set queried table name to variable
        $table = 'posts';
        
        // Connect to database
        include 'includes/dbconnect.php';

        try {
         $sql = "UPDATE $table SET
            post_category_id = :post_category_id,
            post_title = :post_title,
            post_author = :post_author,
            post_keywords = :post_keywords,
            post_image = :post_image,
            post_content = :post_content
            WHERE post_id = :post_id";
        $s = $db->prepare($sql);
        $s->bindValue(':post_id', $post_id);
        $s->bindValue(':post_category_id', $post_category_id);
        $s->bindValue(':post_title', $post_title);
        $s->bindValue(':post_author', $post_author);
        $s->bindValue(':post_keywords', $post_keywords);
        $s->bindValue(':post_image', $post_image);
        $s->bindValue(':post_content', $post_content);
        if( $s->execute() ){
            echo "<script>alert('Post successfully updated!')</script>";
            echo "<script>window.location.href = 'index.php?goto=view_posts'</script>"; //http://stackoverflow.com/questions/4813879/window-open-target-self-v-window-location-href
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

/*-- - - - - - - - - - - - - - - - - -  Delete Post    - - - - - - - - - - - - - - - - - */

if (isset($_GET['delete_post'])){
                  
    // Retrieve post_id and image values and store in variables
    $post_id = htmlspecialchars($_GET['delete_post']); 
    $image = htmlspecialchars($_GET['image']);
    
    // Check if running locally or at host server
    if(isset($server) && $server === 'localhost'){
        // Execute if server is localhost 
        $image = $_SERVER['DOCUMENT_ROOT'].'/WomenOfWorshipUS.com/admin/uploaded_post_images/' . $image;
    }
    else {
        // Execute if server is not localhost
        $image = $_SERVER['DOCUMENT_ROOT'].'/admin/uploaded_post_images/' . $image;
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
    $table = 'posts';

    // Connect to database
    include 'includes/dbconnect.php';

    // Query database for post data of specified id
    try {
        $sql = "DELETE FROM $table
                WHERE post_id = :post_id";
        $s = $db->prepare($sql);
        $s->bindValue(':post_id', $post_id);
        if($s->execute()){
            echo "<script>alert('Post deleted!')</script>";
            echo "<script>window.location.href = 'index.php?goto=view_posts'</script>";  //http://stackoverflow.com/questions/4813879/window-open-target-self-v-window-location-href
        }
    } 
    catch (PDOException $e) {
        $errMsg  = 'Error deleting post: ' . $e->getMessage();
        include 'includes/error.html.php';
        exit();
    }

    // Close database connection
    $db = null;

    // Exit
    exit();   
}



/* - - - - - - - - - - - - - - - - -  Add new category  - - - - - - - - - - - - - - - - - */
                
if (isset($_POST['action']) && $_POST['action'] === 'add_new_category') {
    
    include 'includes/helper.php';
    $table = 'categories';
    
    // Sanitize and store user data in variable
    $new_category_name = sanitize($_POST['new_post_category']);
    
    // Connect to database
    include 'includes/dbconnect.php';

    // Insert new category into database
    try {
        $sql = "INSERT INTO $table SET
                cat_title = :cat_title";
        $s = $db->prepare($sql);
        $s->bindValue(':cat_title', $new_category_name);
        if($s->execute()){
            echo "<script>alert('New category added!')</script>";
            echo "<script>window.location.href = 'index.php?goto=create_category'</script>";  //http://stackoverflow.com/questions/4813879/window-open-target-self-v-window-location-href
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

/*-- - - - - - - - - - - - - - - - - -  Delete Category    - - - - - - - - - - - - - - - - - */

if (isset($_GET['delete_category'])){

    // Set variables
    $table = 'categories';                  

    // Retrieve post_id  value and store in $post_id variable
    $cat_id = htmlspecialchars($_GET['delete_category']);                                     

    // Connect to database
    include 'includes/dbconnect.php';

    // Query database for post data of specified id
    try {
        $sql = "DELETE FROM $table
                WHERE cat_id = :cat_id";
        $s = $db->prepare($sql);
        $s->bindValue(':cat_id', $cat_id);
        if($s->execute()){
            echo "<script>alert('Category deleted!')</script>";
            echo "<script>window.location.href = 'index.php?goto=view_categories'</script>";  //http://stackoverflow.com/questions/4813879/window-open-target-self-v-window-location-href
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



/* - - - - - - - - - - - - - - - - - Update category  - - - - - - - - - - - - - - - - - */
if (isset($_POST['action']) && $_POST['action'] === 'update_category') {
           
    // Include to access functions
    include 'includes/helper.php';  

    // Sanitize and post values
    $cat_id = sanitize($_POST['cat_id']);
    $cat_title = sanitize($_POST['cat_title']);
    
    // Check if fields have input  
    if(empty($cat_title)){
        $errMsg = '*Please fill in the category title field.';
        include 'includes/error.html.php';
        exit();
    } 
    else {
        
        // Set queried table name to variable
        $table = 'categories';
        
        // Connect to database
        include 'includes/dbconnect.php';

        try {
            $sql = "UPDATE $table SET
                   cat_title = :cat_title
                   WHERE cat_id = :cat_id";
            $s = $db->prepare($sql);
            $s->bindValue(':cat_id', $cat_id);
            $s->bindValue(':cat_title', $cat_title);
            if( $s->execute() ){
                echo "<script>alert('Category title successfully updated!')</script>";
                echo "<script>window.location.href = 'index.php?goto=view_categories'</script>"; //http://stackoverflow.com/questions/4813879/window-open-target-self-v-window-location-href
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


/*-- - - - - - - - - - - - - - - - - -  Delete Comment    - - - - - - - - - - - - - - - - - */

if (isset($_GET['delete_comment'])){

    // Set variables
    $table = 'comments';                  

    // Retrieve post_id  value and store in $post_id variable
    $comment_id = htmlspecialchars($_GET['delete_comment']);                                     

    // Connect to database
    include 'includes/dbconnect.php';

    // Query database for post data of specified id
    try {
        $sql = "DELETE FROM $table
                WHERE comment_id = :comment_id";
        $s = $db->prepare($sql);
        $s->bindValue(':comment_id', $comment_id);
        if($s->execute()){
            echo "<script>alert('Comment deleted!')</script>";
            echo "<script>window.location.href = 'index.php?goto=view_comments'</script>";  //http://stackoverflow.com/questions/4813879/window-open-target-self-v-window-location-href
        }
    } 
    catch (PDOException $e) {
        $errMsg  = 'Error deleting comment: ' . $e->getMessage();
        include 'includes/error.html.php';
        exit();
    }

    // Close database connection
    $db = null;

    // Exit
    exit();   
}

/* - - - - - - - - - - - - - - - - - Update comment  - - - - - - - - - - - - - - - - - */

if (isset($_POST['action']) && $_POST['action'] === 'update_comment') {
           
    // Include to access functions
    include 'includes/helper.php';  

    // Sanitize and post values
    $comment_id = sanitize($_POST['comment_id']);
    $post_id = sanitize($_POST['post_id']);
    $comment_date = sanitize($_POST['comment_date']);
    $comment_name = sanitize($_POST['comment_name']);
    $comment_email = sanitize($_POST['comment_email']);
    $comment_text = $_POST['comment_text'];
    $status = sanitize($_POST['status']);
    
    // Check if fields have input  
    if(empty($post_id) || empty($comment_date) || empty($comment_name)  || empty($comment_email) || empty($comment_text) || empty($status)){
        $errMsg = '*Please fill in all comment fields.';
        include 'includes/error.html.php';
        exit();
    } 
    else {
        
        // Set queried table name to variable
        $table = 'comments';
        
        // Connect to database
        include 'includes/dbconnect.php';

        try {
            $sql = "UPDATE $table SET
                   post_id = :post_id,
                   comment_date = :comment_date,
                   comment_name = :comment_name,
                   comment_email = :comment_email,
                   comment_text = :comment_text,
                   status = :status
                   WHERE comment_id = :comment_id";
            $s = $db->prepare($sql);
            $s->bindValue(':comment_id', $comment_id);
            $s->bindValue(':post_id', $post_id);
            $s->bindValue(':comment_date', $comment_date);
            $s->bindValue(':comment_name', $comment_name);
            $s->bindValue(':comment_email', $comment_email);
            $s->bindValue(':comment_text', $comment_text);
            $s->bindValue(':status', $status);
            if( $s->execute() ){
                echo "<script>alert('Comment successfully updated!')</script>";
                echo "<script>window.location.href = 'index.php?goto=view_comments'</script>"; //http://stackoverflow.com/questions/4813879/window-open-target-self-v-window-location-href
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

/*-- - - - - - - - - - - - - - - - - -  Unapprove Comment    - - - - - - - - - - - - - - - - - */

if (isset($_GET['unapprove_comment'])){
    
    // Set variables
    $table = 'comments'; 
    $status = 'unapprove';

    // Retrieve post_id  value and store in $post_id variable 
    $comment_id = htmlspecialchars($_GET['unapprove_comment']);                                     

    // Connect to database
    include 'includes/dbconnect.php';

    // Query database 
    try {
        $sql = "UPDATE $table SET
                status = :status
                WHERE comment_id = :comment_id";
        $s = $db->prepare($sql);
        $s->bindValue(':comment_id', $comment_id);
        $s->bindValue(':status', $status);
        if($s->execute()){
            echo "<script>alert('Comment status changed to unapproved!')</script>";
            echo "<script>window.location.href = 'index.php?goto=view_comments'</script>";  //http://stackoverflow.com/questions/4813879/window-open-target-self-v-window-location-href
        }
    } 
    catch (PDOException $e) {
        $errMsg  = 'Error updating database: ' . $e->getMessage();
        include 'includes/error.html.php';
        exit();
    }

    // Close database connection
    $db = null;

    // Exit
    exit();     
}


/*-- - - - - - - - - - - - - - - - - -  Approve Comment    - - - - - - - - - - - - - - - - - */

if (isset($_GET['approve_comment'])){
    
    // Set variables
    $table = 'comments'; 
    $status = 'approved';

    // Retrieve post_id  value and store in $post_id variable 
    $comment_id = htmlspecialchars($_GET['approve_comment']);                                     

    // Connect to database
    include 'includes/dbconnect.php';

    // Query database 
    try {
        $sql = "UPDATE $table SET
                status = :status
                WHERE comment_id = :comment_id";
        $s = $db->prepare($sql);
        $s->bindValue(':comment_id', $comment_id);
        $s->bindValue(':status', $status);
        if($s->execute()){
            echo "<script>alert('Comment status changed to approved!')</script>";
            echo "<script>window.location.href = 'index.php?goto=view_comments'</script>";  //http://stackoverflow.com/questions/4813879/window-open-target-self-v-window-location-href
        }
    } 
    catch (PDOException $e) {
        $errMsg  = 'Error updating database: ' . $e->getMessage();
        include 'includes/error.html.php';
        exit();
    }

    // Close database connection
    $db = null;

    // Exit
    exit();     
}


   
/* - - - - - - - - - - - -   DEFAULT   - - - - - - - - - - - -  */

/*-- - - - - - - - - - - - -   Get Count of Unapproved / Pending Comments    - - - - - - - - - - - -  */
    // Set variables
    $table = 'comments'; 
    $status = 'unapproved';                               

    // Connect to database
    include 'includes/dbconnect.php';

    // Query database 
    try {
        $sql = "SELECT * FROM $table
                WHERE status = :status";
        $s = $db->prepare($sql);
        $s->bindValue(':status', $status);
        $s->execute();
        
        $unapproved_count = $s->rowCount();
    } 
    catch (PDOException $e) {
        $errMsg  = 'Error updating database: ' . $e->getMessage();
        include 'includes/error.html.php';
        exit();
    }
            
    // Close database connection
    $db = null;  
    
    
    /* - - - - - - -  Default  - - - - - - - - - - */
    
    include 'main.html.php';
    exit();