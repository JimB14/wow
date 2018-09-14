<?php
include 'includes/login-check.inc.php';
?>

<h1 class="text-center" style="margin-bottom:10px;"><?php if(isset($page_title)) echo htmlspecialchars($page_title); ?></h1>


<div id="add-category-form"> 
    
    <form class="form-horizontal" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" enctype="multipart/form-data">
        <?php foreach($categories as $category): ?>
        <div class="form-goup">
            <label for="id" class="col-sm-4 control-label">Category ID (display only): </label>
            <div class="col-sm-8 p1">
                <input type="text" class="form-control" name="id" value="<?php if(isset($category['id'])) {echo $category['id'];} ?>" readonly>
            </div>
        </div>

        <div class="form-goup">
            <label for="name" class="col-sm-4 control-label">Category Title: </label>
            <div class="col-sm-8 p1">
                <input type="text" class="form-control" name="name" value="<?php if(isset($category['name'])) {echo $category['name'];} ?>">
            </div>
        </div>

        <div class="col-sm-offset-4 col-sm-8">
            <button type="submit" class="btn btn-primary p1"  name="action" value="update_product_category" onclick="return confirm('Update product category title now?');">Update</button>
        </div>
        <?php endforeach; ?>
    </form>
</div><!-- // #add-category-form  -->                