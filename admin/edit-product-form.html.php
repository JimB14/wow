<?php
include 'includes/login-check.inc.php';
?>

<h1 class="text-center" style="margin-bottom:10px;"><?php if (isset($page_title)) echo htmlspecialchars($page_title); ?></h1>
   
    <p class="red"><?php if (isset($errMsg)) htmlout($errMsg); ?></p>
    
<div id="new-post-form">  
    
    <form class="form-horizontal" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" enctype="multipart/form-data">
        <?php foreach($products as $product): ?>
        
        <?php
            include 'includes/dbconnect.php';
            $table = 'category';
        
            // Get selected product category
            try{
                $sql = "SELECT * FROM $table
                        WHERE id = :id";
                $s = $db->prepare($sql);
                $s->bindValue(':id', $product['category_id']);
                $s->execute();
                
                // Store single row of results in $item array
                $item = $s->fetch(PDO::FETCH_ASSOC);  
            } 
            catch (PDOException $e) {
                $errMsg = 'Error fetching data from database: ' . $e->getMessage();
                include 'includes/error.html.php';
                exit();
            }
            
            
            // Get all category fields to display in select drop down
            try {
                $sql = "SELECT * FROM $table";
                $s = $db->prepare($sql);
                $s->execute();

                // Loop below not required. I don't know why. When used it produces double results
                // in drop-down, which appears to mean that the $categories array must already exist

                while ($row = $s->fetch(PDO::FETCH_ASSOC)) {
                    $categories[] = array(
                        'id' => $row['id'],
                        'name' => $row['name']
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
        ?>
                     

        <div class="form-goup">
            <label for="category_id" class="col-sm-2 control-label">Select Category:</label>
            <div class="col-sm-10 p1">
                <select class="form-control" name="category_id">
                    <option value="<?php echo $item['id']; ?>"><?php echo $item['name']; ?></option>
                    <?php foreach ($categories as $category): ?>
                        <option value="<?php htmlout($category['id']); ?>"><?php htmlout($category['name']); ?> (ID = <?php htmlout($category['id']);  ?>)</option>
                    <?php endforeach; ?>
                </select> 
            </div>
        </div>

        <div class="form-goup">
            <label for="name" class="col-sm-2 control-label">Name: </label>
            <div class="col-sm-10 p1">
                <input type="text" class="form-control" name="name" id="name" placeholder="Name" value="<?php if (isset($product['name'])) echo htmlspecialchars($product['name']); ?>" >
            </div>
        </div>
        
         <div class="form-goup">
            <label for="inscription" class="col-sm-2 control-label">Inscription: </label>
            <div class="col-sm-10 p1">
                <input type="text" class="form-control" name="inscription" id="inscription" placeholder="Inscription" value="<?php if (isset($product['inscription'])) echo htmlspecialchars($product['inscription']); ?>" >
            </div>
        </div>

        <div class="form-goup">
            <label for="description" class="col-sm-2 control-label">Description: </label>
            <div class="col-sm-10 p1">
                <input type="text" class="form-control" name="description" id="description" placeholder="Description" value="<?php if (isset($product['description'])) echo htmlspecialchars($product['description']); ?>" required>
            </div>
        </div>
        
        <div class="form-goup">
            <label for="size" class="col-sm-2 control-label">Size: </label>
            <div class="col-sm-10 p1">
                <input type="text" class="form-control" name="size" id="size" placeholder="Size" value="<?php if (isset($product['size'])) echo htmlspecialchars($product['size']); ?>">
            </div>
        </div>

        <div class="form-goup">
            <label for="product_image" class="col-sm-2 control-label">Image: </label>
            <div class="col-sm-10 p1">
                <p class="help-block text-size90">*Select new image or current image before updating</p>
                <input type="file" name="product_image" id="product_image"><img style="padding:7px 0px 4px 0px;" src="uploaded_product_images/<?php if(isset($product['image'])) {echo $product['image'];} ?>" width="110">
                <p style="margin-top:-5px;" class="help-block text-size90">
                    *Form will not submit unless image file is chosen
                    <br>
                    *File must be jpg, gif or png < 2MB
                </p>
            </div>
        </div>
        
        <div class="form-goup">
            <label for="price" class="col-sm-2 control-label">Price: </label>
            <div class="col-sm-10 p1">
                <input type="text" class="form-control" name="price" id="price" placeholder="No dollar sign" value="<?php if (isset($product['price'])) echo htmlspecialchars($product['price']); ?>">
            </div>
        </div>

        <div class="col-sm-offset-2 col-sm-10 p1">
            <input type="hidden" name="id" value="<?php htmlout($product['id']); ?>">
            <button type="submit" class="btn btn-primary center-block p1"  name="action" value="update_product" title="MAKE SURE&#10;YOU SELECTED&#10;AN IMAGE">Update</button>
        </div>
        <?php endforeach; ?>
    </form><!--  // .form  --> 
    
</div><!-- // #new-post-form  -->