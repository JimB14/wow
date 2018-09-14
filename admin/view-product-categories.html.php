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
                    <th>ID</th>
                    <th>Category Title</th>
                    <th>Edit</th>
                    <th>Delete</th>
                </tr>
            </thead>

            <tbody>
                <?php foreach($categories as $category): ?>
                <tr>
                    <td><?php echo $category['id']; ?></td>
                    <td><?php echo $category['name']; ?></td>
                    <td><a class="btn btn-default btn-sm" href="index.php?edit_product_category=<?php echo $category['id'] ?>">Edit</a></td>
                    <td><a class="btn btn-danger btn-sm" href="index.php?delete_product_category=<?php echo $category['id'] ?>" onclick="return confirm('Permanently delete this product category?');">&times;</a></td>
                </tr>
                <?php  endforeach; ?>

            </tbody>
        </table>

    </form>
    
</div><!-- // .table-responsive  -->     