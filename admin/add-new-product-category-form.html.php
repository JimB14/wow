<?php
include 'includes/login-check.inc.php';
?>

<h1 class="text-center" style="margin-bottom:10px;"><?php if (isset($page_title)) echo htmlspecialchars($page_title); ?></h1>


<div id="add-category-form"> 
    
    <form class="form-horizontal" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" enctype="multipart/form-data">

        <div class="form-goup">
            <label for="post_category" class="col-sm-4 control-label">Current categories:</label>
            <div class="col-sm-8 p1">
                <select class="form-control" name="post_category">
                    <?php foreach ($categories as $category): ?>
                        <option value="<?php htmlout($category['id']); ?>"><?php htmlout($category['name']); ?> (ID = <?php htmlout($category['id']); ?>)</option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>

        <div class="form-goup">
            <label for="new_product_category" class="col-sm-4 control-label">New category: </label>
            <div class="col-sm-8 p1">
                <input type="text" class="form-control" name="new_product_category" id="new_product_category" placeholder="Product category name" required>
            </div>
        </div>

        <div class="col-sm-offset-4 col-sm-8">
            <button type="submit" class="btn btn-primary center-block p1"  name="action" value="add_new_product_category">Add Category</button>
        </div>

    </form>
</div><!-- // #add-category-form  -->