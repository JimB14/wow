<?php
include 'includes/login-check.inc.php';
?>
<h1 class="text-center" style="margin-bottom:10px;"><?php if(isset($page_title)) echo htmlspecialchars($page_title); ?></h1>

<div class="table-responsive">
    <p class="red"><?php if (isset($errMsg)) htmlout($errMsg); ?></p>
    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" enctype="multipart/form-data">        
        <table class="table table-bordered insert-post bg-fff">

            <thead>
                <tr>
                    <th></th>
                    <th>Category ID</th>
                    <th>Category name</th>
                    <th>Name</th>
                    <th>Inscription</th>
                    <th>Description</th>
                    <th>Size</th>
                    <th>Image</th>
                    <th>Price</th>
                    <th>Edit</th>
                    <th>Delete</th>
                </tr>
            </thead>

            <tbody>
                <?php foreach($products as $product): ?>
                <tr>                   
                    <td><img src="uploaded_product_images/<?php echo $product['image']; ?>" width="60"></td>
                    <td><?php echo $product['category_id']; ?></td>
                    <td><?php echo $product['category_name']; ?></td>
                    <td><?php echo $product['name']; ?></td>
                    <td><?php echo $product['inscription']; ?></td>
                    <td><?php echo $product['description']; ?></td>
                    <td><?php echo $product['size']; ?></td>                 
                    <td><?php echo substr($product['image'], 0, 15); ?></td>
                    <td><?php echo $product['price']; ?></td>
                    <td><a class="btn btn-default btn-sm" href="index.php?edit_product=<?php echo $product['id'] ?>">Edit</a></td>
                    <td><a class="btn btn-danger btn-sm" href="index.php?delete_product=<?php echo $product['id'] ?>&image=<?php htmlout($product['image']); ?>" onclick="return confirm('Permanently delete this product?');">&times;</a></td>
                </tr>
                <?php  endforeach; ?>

            </tbody>
        </table>

    </form>
    
</div><!-- // .table-responsive  -->  