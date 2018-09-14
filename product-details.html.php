<?php
$page_id = 'shop';
$description = '';
include 'includes/helper.php';
include 'includes/header.php';
?>


<!--   Main Content  -->

<div class="container">
    
    <div class="row">
        
        <div class="col-md-12">
            <h1 class="text-center"  style="color: #787878; margin: 0px 0px 20px 0px;"> </h1>
        </div> 
        
        
        <div class="col-md-4 p3">           
            <!--<a href="admin/uploaded_product_images/<?php htmlout($item['image']); ?>">-->
                <img class="img-responsive" style="margin-bottom: 20px;" src="admin/uploaded_product_images/<?php htmlout($item['image']); ?>">
            <!--</a>-->
        </div>
        
        <div class="col-md-8">
            
            <div id="item-box">
                
                <div id="item-title">
                    <h1 class="text-uppercase"><?php htmlout($item['name']); ?></h1>
                </div>
                
                <div id="item-attributes">
   
                    <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
                        
                        <p>Description: <span class="text-capitalize"><?php htmlout($item['description']); ?></span></p> 
                        
                        <?php
                            // Check if item is clothing; if true, display inscription field content
                            if(isset($item['category_id']) && $item['category_id'] == 1){
                                echo '<p>';                              
                                echo 'Inscription: ';
                                echo '<span>';
                                echo '"' . $item['inscription'] . '"';
                                echo '</span>';
                                echo '</p>';
                            }
                        ?>

                        <p>Category: <span class="text-capitalize" id="productCategory"><?php htmlout($item['category_name']); ?></span></p>
                        
                        <p>Item ID: <span class="text-capitalize">#<?php htmlout($item['id']); ?></span></p>

                        <?php
                            // Check if item is clothing; if true, display size dropdown
                            if(isset($item['category_id']) && $item['category_id'] == 1){
                                // Explode size field data into array and loop through to populate drop-down
                                $sizes = $item['size'];
                                $sizes = explode(",", $sizes);
                                
                                echo '<span id="available-sizes">';
                                echo 'Available sizes: ';
                                echo '</span>';
                                echo '<select name="size" id="size">';
                                echo '<option value="">Select size</option>';
                                    foreach($sizes as $size):
                                echo "<option value=$size>$size</option>";
                                    endforeach;
                                echo '</select>';
                                echo '<span style="color:#ff0000; font-size:150%;">';
                                echo ' *';
                                echo '</span>';
                                echo '<span style="font-size:90%;color:#ff0000;">';
                                echo 'Required';
                                echo '</span>';
                            } 
                        ?>
                        
                        <span id="display-error-message"></span>
                        
                        <p style="margin-top: 10px;"><span>$<?php htmlout($item['price']); ?></span></p>

                        <input type="hidden" name="id" value="<?php echo $item['id']; ?>">
                        <input type="hidden" name="category_id" value="<?php echo $item['category_id']; ?>">
                        <input type="hidden" name="category_name" value="<?php echo $item['category_name']; ?>">                       
                        <input type="hidden" name="name" value="<?php echo $item['name']; ?>">                        
                        <input type="hidden" name="inscription" value="<?php echo $item['inscription']; ?>">
                        <input type="hidden" name="description" value="<?php echo $item['description']; ?>">
                        <input type="hidden" name="image" value="<?php echo $item['image']; ?>">
                        <input type="hidden" name="price" value="<?php echo $item['price']; ?>">
                        <button id="add-to-cart" class="btn btn-primary" name="action" value="add_to_cart" type="submit">Add to cart</button>

                    </form>
                    
                    <p style="margin-top: 20px; font-size:95%;"><a href="index.php?get_page=shop&amp;id=7" title="Return to shopping"><< Return to Shop</a></p>
                    
                </div><!-- // #item-attributes  -->
                
            </div><!-- // #item-box  -->
            
        </div><!-- // .col-md-8  -->
        
    </div><!-- // .row  -->               
                       
</div> <!-- // .container  -->


<?php
include 'includes/footer.php';