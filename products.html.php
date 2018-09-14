<?php
$title = 'Products';
$page_id = 'store';
$description = '';
include 'includes/helper.php';
include 'includes/header.php';
?>


<!-- - - - - - - -  Content  - - - - - - - -  -->

<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-2">
            <?php
                // show message
                if (isset($success_message)) {
                    echo "<div class='alert alert-success text-center'>";
                    echo "<strong>$success_message</strong>";
                    echo "</div>";
                } 
                if (isset($already_in_cart)) {
                    echo "<div class='alert alert-success text-center'>";
                    echo "<strong>$already_in_cart</strong>";
                    echo "</div>";
                } 
                else if (isset($failure_message)) {
                    echo "<div class='alert alert-danger text-center'>";
                    echo "<strong>$failure_message</strong>";
                    echo "</div>";
                }
            ?>

            <h1 style="letter-spacing: 10px;" class="text-center text-uppercase">
                <?php 
                    if(isset($category_name) && $category_name != 'a') {htmlout($category_name);} else echo 'All Products'; 
                ?>
                <span class="badge" style="letter-spacing:0px; margin-top:-17px; margin-left:-20px;"><?php if(isset($product_count)) {htmlout($product_count);} ?></span>
            </h1>
            <!--<h1 style="letter-spacing: 10px;" class="text-center text-uppercase"><?php if(isset($category_name) && $category_name != 'a') {htmlout($category_name);} else echo 'All Products'; ?></h1>-->
        </div>

        <div class="col-md-2 col-sm-2">
            
            <div class="p2">
                <img class="img-responsive" src="images/free_shipping_295x150.png" alt="free shipping">
            </div>

            <h4></h4>
            <div  style="margin-left: 7px">
                
                <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);  ?>">                                                                 
  
                    <label style="display:block; margin-bottom: 5px;">
                        <input type="radio" name="category" id="category" value="1Clothing"  <?php if(isset($category_id) && $category_id == '1') {echo ' checked="checked"';} ?>>
                        <span class="text-capitalize"> Clothing</span>
                    </label>

                    <label style="display:block; margin-bottom: 5px;">
                        <input type="radio" name="category" id="category" value="2Jewelry"  <?php if(isset($category_id) && $category_id == '2') {echo ' checked="checked"';} ?>>
                        <span class="text-capitalize"> Jewelry</span>
                    </label>


                    <label style="display:block; margin-bottom: 5px;">
                        <input type="radio" name="category" id="category" value="3Music"  <?php if(isset($category_id) && $category_id == '3') {echo ' checked="checked"';} ?>>
                        <span class="text-capitalize">Music</span>
                    </label>

                    <label style="display:block; margin-bottom: 5px;">
                        <input type="radio" name="category" id="category" value="all"  <?php if(!isset($category_id) ||  isset($category_id) && $category_id === 'all') {echo ' checked="checked"';} ?>>
                        All
                    </label>

                    <button class="btn btn-primary btn-sm" type="submit" name="action" value="sort_products">Update</button> 
                    
                </form>
                
            </div>
            
            
        </div><!--  // .col-md-2  -->



        <div class="col-md-10 col-sm-10 p3">  
            <?php foreach ($products as $product): ?>
            <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
              
                <div class="product-box">
                    <div class="shaded-bar text-center"><span style="display:inline-block;color:#fff;margin-top:3px;;" class="text-capitalize"><?php htmlout($product['category_name']); ?></span></div>
                    
                    <div class="image-box">
                        <!--<a href="admin/uploaded_product_images/<?php htmlout($product['image']); ?>">-->
                            <img class="img-responsive" src="admin/uploaded_product_images/<?php htmlout($product['image']); ?>">
                        <!--</a>-->
                    </div>
                    <div class="product-details-box">
                        <p class="text-center text-capitalize"><?php htmlout($product['name']); ?></p>
                        
                        
                        <?php
                        /*
                            // Check if item is clothing; if true, display size dropdown
                            if(isset($product['category_id']) && $product['category_id'] == 1){
                                // Explode size field data into array and loop through to populate drop-down
                                $sizes = $product['size'];
                                $sizes = explode(",", $sizes);
                                
                                echo '<select name="size">';
                                echo '<option value="">Select size</option>';
                                    foreach($sizes as $size):
                                echo "<option value=$size;>$size</option>";
                                    endforeach;
                                echo '</select>';
                            } 
                            */
                        ?>
                        
                        
                        <p class="text-center text-capitalize"><?php htmlout($product['size']); ?></p>
                        <p class="text-center" style="font-size:12px;margin-bottom:2px">$<?php htmlout($product['price']); ?></p>
                    </div>

                    <input type="hidden" name="id" value="<?php echo $product['id']; ?>">
                    <input type="hidden" name="name" value="<?php echo $product['name']; ?>">
                    <button class="btn btn-primary center-block" name="action" value="get_product_details" type="submit">Select</button>
                    <!--<a class="btn btn-sm btn-primary center-block" href="index.php?action=add_to_cart&id=<?php// echo $product['id'] . '&name=' . $product['name'] . '&quantity=1'; ?>">Add to Cart</a>-->
                    
                    <div class="shaded-bar-bottom"></div>
                </div>               
            
            </form>
            <?php endforeach; ?>

        </div><!-- // .col-md-10  -->

    </div><!-- // .row  -->
</div><!--  //  .container  -->

<?php
include 'includes/footer.php';