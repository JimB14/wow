<?php
$title = 'Cart';
$page_id = 'cart';
$page_title = 'Cart';
$description = '';
include 'includes/helper.php';
include 'includes/header.php';

/* - - - - - - - - - */
echo '<pre>';
print_r($cart_items);
echo '</pre>';
/* - - - - - - - - - */
?>


<div class="container">
    <div class="row">
        <div class="col-md-12">
            <?php
                // display a message           
                if (isset($success_message)) {
                    echo "<div class='alert alert-success text-center'>";
                    echo "<strong>$success_message</strong>!";
                    echo "</div>"; 
                    /*                  
                } else if (isset($success_update_quantity_message)) {
                    echo "<div class='alert alert-success text-center'>";
                    echo "<strong>{$name}</strong> quantity was updated to $new_quantity!";
                    echo "</div>";
                } else if (isset($failure_update_quantity_message)) {
                    echo "<div class='alert alert-success text-center'>";
                    echo "<strong>{$name}</strong> quantity failed to updated!";
                    echo "</div>";
                    */
                }
            ?>
            <h1 style="letter-spacing: 10px;" class="text-center text-uppercase"><?php echo htmlspecialchars($page_title); ?></h1>
        </div>
        
        <div class="col-md-12">
            
            <table class="table table-hover table-responsive table-bordered table-condensed cart-table"  style="background-color:#fcfcfc;">
                
                <thead>
                    <tr>
                        <th>Product Name</th>
                        <th style="width:9%; text-align: center">Image</th>
                        <th>Price(USD)</th>
                        <th style="width:12em;">Quantity</th>
                        <th>Sub Total</th>
                        <th class="text-center" style="width:10%;">Action</th>
                    </tr>
                </thead>
                
                <tbody>
                    <?php foreach($cart as $item): ?>
                    <tr style=" height:60px;">                     
                        <td>
                            <!-- include product ID but do not display to user  -->
                            <div style="display:none"><?php htmlout($item['id']); ?></div>
                            <div><?php htmlout($item['name']); ?></div>
                        </td>
                        <td><img class="thumbnail center-block" src="images/products/<?php htmlout($item['thumbnail']); ?>" height=50></td>
                        <td>&#36;<?php htmlout(number_format($item['price'],2 )); ?></td>
                        <td>
                            <form method="get" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
                                <div class="input-group">
                                    <input type="number" class="form-control"  name="new_quantity" min="1" value="<?php htmlout($item['quantity']); ?>">
                                    <span class="input-group-btn">
                                        <input type="hidden" name="product_id" value="<?php htmlout($item['id']); ?>">
                                        <input type="hidden" name="product_name" value="<?php htmlout($item['name']); ?>">
                                        <button class="btn btn-default" type="submit" name="action" value="update_quantity">
                                            Update
                                        </button>
                                    </span>
                                </div>                        
                            </form>                       
                        </td>
                        <td>&#36;<?php htmlout(number_format($item['subtotal'], 2)); ?></td>
                        <td class="text-center">
                            <a href="index.php?action=delete_item&id=<?php htmlout($item['id']); ?>&name=<?php htmlout($item['name']); ?>" class="btn btn-danger btn-sm" role="button"  onclick="return confirm('Delete from cart now?');"><span class='glyphicon glyphicon-remove'></span></a>
                        </td>
                    </tr>
                    <?php  endforeach; ?>
                </tbody>
                
                <tfoot>
                    <tr>
                        <td colspan="4" style="font-weight:bold; font-size:140%;">Total</td>
                        <td>&#36;<?php if(isset($total)) {htmlout(number_format($total, 2));} ?> </td>
                        <td><button class="btn btn-success" name="action" value="checkout"><span class="glyphicon glyphicon-shopping-cart"></span> Checkout</button></td>
                        
                    </tr>
                </tfoot>
                
            </table> 
            <p style="font-size:12px; margin-top:-17px;margin-bottom: 30px; margin-left:5px;"><a href="index.php?action=empty_cart" onclick="return confirm('Empty all contents of shopping cart?');">Empty cart</a></p>
            
        </div><!-- // .col-md-12  -->

    </div><!-- // .row  -->
</div><!-- // .container  -->

<?php
include 'includes/footer.php';