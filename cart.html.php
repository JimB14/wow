<?php
$title = 'Cart';
$page_id = 'cart';
$page_title = 'Cart';
$description = '';
include 'includes/helper.php';
include 'includes/header.php';

/* - - - - - - - - - *
echo '<pre>';
echo '$_SESSION[\'cart\']: ' . '<br>';
print_r($_SESSION['cart']);
echo '</pre>';

$x = '1';
echo 'Quantity of id #' . $x . ' =  ' . $_SESSION['cart'][$x]['quantity'] . '<br><br>';


echo 'var_dump of $_SESSION[\'cart\']: ';
var_dump($_SESSION['cart']);

echo '<pre>';
echo '$cart: ' . '<br>';
if(isset($cart)) {print_r($cart);}  else {echo '$cart is empty';}
echo '</pre>';

echo '<pre>';
echo '$paypal_cart: ' . '<br>';
if(isset($paypal_cart)) {print_r($paypal_cart);}  else {echo '$paypal_cart is empty';}
echo '</pre>';
/* - - - - - - - - - */
?>


<div class="container">
    <div class="row">
        <div class="col-md-12">
            <?php
                $name = isset($_GET['name']) ? $_GET['name'] : '';
                $id = isset($_GET['id']) ? $_GET['id'] : '';
                $new_quantity = isset($_GET['new_quantity']) ? $_GET['new_quantity'] : '';
                // display a message           
                if (isset($success_message)) {
                    echo "<div class='alert alert-success text-center'>";
                    echo "<strong>$success_message</strong>!";
                    echo "</div>";                  
                } else if (isset($_GET['new_quantity'])) {
                    echo "<div class='alert alert-success text-center'>";
                    echo "<h4 style='margin-bottom:0px'><span class='glyphicon glyphicon-ok' style='color:#00b300; padding-right:10px; font-size:150%;'></span><strong>{$name}</strong> quantity updated to {$new_quantity}!</h4>";
                    echo "</div>";
                    /*
                } else if (isset($failure_update_quantity_message)) {
                    echo "<div class='alert alert-success text-center'>";
                    echo "<strong>{$name}</strong> quantity failed to updated!";
                    echo "</div>";
                    */
                }
            ?>
            <h1 style="letter-spacing: 10px;" class="text-center text-uppercase"><?php echo htmlspecialchars($page_title); ?></h1>
        </div>
        
        <div class="col-md-12 p3">
        <!--
            <?php//  if(isset($session_cart_count) && $session_cart_count > 0): ?>
        -->

            <a class="btn btn-default btn-sm" style="margin-bottom:5px;" role="button" href="index.php?get_page=shop&amp;id=7" >Shop</a>         
            <a class="btn btn-default btn-sm pull-right" style="margin-bottom:5px;" role="button" href="index.php?action=empty_cart" onclick="return confirm('Empty all contents of shopping cart?');">Empty cart</a>         
            
            <table class="table table-hover table-responsive table-bordered table-condensed cart-table"  style="background-color:#fcfcfc;">
                
                <thead>
                    <tr>                       
                        <th style="width:9%; text-align: center">Image</th>
                        <th>Product Name</th>
                        <th>Inscription</th>
                        <th>Size</th>
                        <th>Price (USD)</th>
                        <th style="width:12em;">Quantity</th>
                        <th>Sub Total</th>
                        <th class="text-center" style="width:10%;">Action</th>
                    </tr>
                </thead>
                
                <tbody>
                    <?php foreach($cart as $item): ?>
                    <tr> 
                        <td><img class="thumbnail center-block" src="admin/uploaded_product_images/<?php htmlout($item['image']); ?>" height=50></td>                    
                        <td>
                            <!-- include product ID but do not display to user  -->
                            <div style="display:none"><?php htmlout($item['id']); ?></div>
                            <div><?php htmlout($item['name']); ?></div>
                        </td>
                        <td><?php htmlout($item['inscription']); ?></td>
                        <td><?php htmlout($item['size']); ?></td>
                        <td>&#36;<?php htmlout(number_format($item['price'], 2)); ?></td>
                        <td>
                            <form method="get" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
                                <div class="input-group">
                                    <input type="number" class="form-control"  name="new_quantity" id="update_qty" min="1" value="<?php htmlout($item['quantity']); ?>">
                                    <span class="input-group-btn">
                                        <input type="hidden" name="id" value="<?php htmlout($item['id']); ?>">
                                        <input type="hidden" name="name" value="<?php htmlout($item['name']); ?>">
                                        <button class="btn btn-default"  type="submit" name="action" value="update_quantity">
                                            Update
                                        </button>
                                    </span>
                                </div>                        
                            </form>                       
                        </td>
                        <td>&#36;<?php htmlout(number_format($item['subtotal'], 2)); ?></td>
                        <td class="text-center">
                            <a href="index.php?action=delete_item&id=<?php htmlout($item['id']); ?>&name=<?php htmlout($item['name']); ?>" class="btn btn-danger btn-sm" role="button"  onclick="return confirm('Delete <?php htmlout($item['name']);  ?> from cart now?');"><span class='glyphicon glyphicon-remove'></span></a>
                        </td>
                    </tr>
                    <?php  endforeach; ?>
                </tbody>
                
                <!--  Resource:  https://developer.paypal.com/docs/classic/paypal-payments-standard/integration-guide/Appx_websitestandard_htmlvariables/ -->
                
                <tfoot>
                    <tr>
                        <td colspan="6" style="font-weight:bold; font-size:140%;">Total</td>
                        <td>&#36;<?php if(isset($total)) {htmlout(number_format($total, 2));} ?> </td>
                        <td>

                            <form action="https://www.paypal.com/us/cgi-bin/webscr" method="post">
                                <!-- inside cart rendering  -->
                                <input type="hidden" name="cmd" value="_cart">
                                <input type="hidden" name="upload" value="1">   
                                <input type="hidden" name="business" value="info@solaceministriesinternational.com">

                                <?php 
                                foreach($paypal_cart as $item): ?>
                                    <input type="hidden" name="item_number_<?php echo $i++; ?>" value="<?php htmlout($item['id']); ?>">
                                    <input type="hidden" name="item_name_<?php echo $j++; ?>" value="<?php htmlout($item['name']); if(isset($item['size'])) {echo ', Size: ' .  $item['size'];} if(isset($item['inscription'])) {echo ', ' . $item['inscription'];} ?> ">
                                    <input type="hidden" name="amount_<?php echo $k++; ?>" value="<?php htmlout($item['price']); ?>">                                    
                                    <input type="hidden" name="quantity_<?php echo $l++; ?>" value="<?php htmlout($item['quantity']); ?>">
                                <?php  endforeach; ?>

                                <!-- below and outside foreach loop  -->
                                <input type="hidden" name="notify_url" value="http://www.womenofworshipus.com/storescripts/my_ipn.php">
                                <input type="hidden" name="return" value="http://www.womenofworshipus.com/checkout_complete.php">
                                <input type="hidden" name="rm" value="2">
                                <input type="hidden" name="ctbt" value="Return to the Store">
                                <input type="hidden" name="cancel_return" value="http://www.womenofworshipus.com/">
                                <input type="hidden" name="currency_code" value="USD">

                                <input type="image" src="images/checkout-btn.png" width="100" name="submit" alt="Checkout with PayPal">

                            </form>
                        </td>
                        
                    </tr>
                </tfoot>
                
            </table> 
            <!--<button class="btn btn-success" name="action" value="checkout"><span class="glyphicon glyphicon-shopping-cart"></span> Checkout</button> -->
    <!--        
        <?php// else: ?>
            <div class="p3">
                <h3 class="text-center">Your cart is empty!</h3>
                <h4 class="text-center" style="margin-top:px;"><a href="?goto=store">Shop now</a></h4>
            </div>
        <?php// endif; ?>

    -->
        </div><!-- // .col-md-12  -->

    </div><!-- // .row  -->
</div><!-- // .container  -->


<script>
/*
$("#update_qty").change(function(){
    alert("You must click \"Update\" after changing the quantity.");
});
*/
</script>

<?php
include 'includes/footer.php';