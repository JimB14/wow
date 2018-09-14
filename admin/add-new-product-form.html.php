<?php
include 'includes/login-check.inc.php';
?>

<h1 class="text-center" style="margin-bottom:10px;"><?php if (isset($page_title)) echo htmlspecialchars($page_title); ?></h1>
   
    <p class="red"><?php if (isset($errMsg)) htmlout($errMsg); ?></p>
    
<div id="new-post-form">  
    
    <form class="form-horizontal" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" enctype="multipart/form-data">

        <div class="form-goup">
            <label for="category_id" class="col-sm-2 control-label">Select Category:</label>
            <div class="col-sm-10 p1">
                <select class="form-control" name="category_id">
                    <option value="">Select category</option>
                    <?php foreach ($categories as $category): ?>
                        <option value="<?php htmlout($category['id']) ?>"><?php htmlout($category['name']); ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>

        <div class="form-goup">
            <label for="name" class="col-sm-2 control-label">Name: </label>
            <div class="col-sm-10 p1">
                <input type="text" class="form-control" name="name" id="name" placeholder="Name, e.g. T-shirt, book, mug, earrings, necklace" value="<?php if (isset($product['name'])) echo htmlspecialchars($product['name']); ?>" required>
            </div>
        </div>
        
        <div class="form-goup">
            <label for="inscription" class="col-sm-2 control-label">Inscription: </label>
            <div class="col-sm-10 p1">
                <input type="text" class="form-control" name="inscription" id="inscription" placeholder="Inscription - text on t-shirt" value="<?php if (isset($product['inscription'])) echo htmlspecialchars($product['inscription']); ?>" required>
            </div>
        </div>

        <div class="form-goup">
            <label for="description" class="col-sm-2 control-label">Description: </label>
            <div class="col-sm-10 p1">
                <input type="text" class="form-control" name="description" id="description" placeholder="Description, e.g. 100% cotton, short-sleeves" value="<?php if (isset($product['description'])) echo htmlspecialchars($product['description']); ?>" required>
            </div>
        </div>
        
        <div class="form-goup">
            <label for="size" class="col-sm-2 control-label">Size: </label>
            <div class="col-sm-10 p1">
                <input type="text" class="form-control" name="size" id="size" placeholder="Size - comma separated, e.g. XS,S,M,L,XL,XXL" value="<?php if (isset($product['size'])) echo htmlspecialchars($product['size']); ?>">
            </div>
        </div>

        <div class="form-goup">
            <label for="product_image" class="col-sm-2 control-label">Image: </label>
            <div class="col-sm-10 p1">
                <input type="file" name="product_image" id="product_image">
                <p class="help-block small">*File must be jpg, gif or png < 2MB</p>
            </div>
        </div>
        
        <div class="form-goup">
            <label for="price" class="col-sm-2 control-label">Price: </label>
            <div class="col-sm-10 p1">
                <input type="text" class="form-control" name="price" id="price" placeholder="No dollar sign, e.g. 25 will display as $25.00, 19.99 will display as $19.99" value="<?php if (isset($product['price'])) echo htmlspecialchars($product['price']); ?>" required>
            </div>
        </div>

        <div class="col-sm-offset-2 col-sm-10 p1">
            <input type="hidden" name="category_name" value="<?php htmlout($category['name']); ?>">
            <button type="submit" class="btn btn-primary center-block p1"  name="action" value="insert_product">Submit</button>
        </div>

    </form><!--  // .form  --> 
    
</div><!-- // #new-post-form  -->