<?php
include 'includes/login-check.inc.php';
?>

<h1 class="text-center" style="margin-bottom:10px;"><?php if (isset($page_title)) echo htmlspecialchars($page_title); ?></h1>


<div id="add-category-form"> 
    
    <form class="form-horizontal" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
        <?php foreach($images as $image): ?>
        
        <div class="form-goup">
            <label for="image" class="col-sm-2 control-label">Image: </label>
            <div class="col-sm-10 p1">            
                <p><img src="uploaded_gallery_images/<?php htmlout($image['thumbnail']); ?>" alt="image" height="75"></p>
            </div>
        </div>       
        
        <div class="form-goup">
            <label for="title" class="col-sm-2 control-label">Title: </label>
            <div class="col-sm-10 p1">
                <input type="text" class="form-control" name="title" id="title" placeholder="Appears top left in slide show display" value="<?php htmlout($image['title']) ?>">
            </div>
        </div>
        
        <div class="form-goup">
            <label for="alt" class="col-sm-2 control-label">Alt text: </label>
            <div class="col-sm-10 p1">
                <input type="text" class="form-control" name="alt" id="alt" value="<?php htmlout($image['alt']) ?>">
            </div>
        </div>

        <div class="col-sm-offset-2 col-sm-10">
            <input type="hidden" name="id" value="<?php htmlout($image['id']); ?>">
            <button type="submit" class="btn btn-primary center-block p1" onclick="return confirm('Update now?');" name="action" value="update_gallery_image">Update</button>
        </div>
        <?php endforeach; ?>
    </form>
</div><!-- // #add-category-form  -->