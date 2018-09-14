<?php
include 'includes/login-check.inc.php';
?>

<h1 class="text-center" style="margin-bottom:10px;"><?php if (isset($page_title)) echo htmlspecialchars($page_title); ?></h1>


<div id="add-category-form"> 
    
    <form class="form-horizontal" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" enctype="multipart/form-data">
        
        <div class="form-goup">
            <label for="image" class="col-sm-2 control-label">Image: </label>
            <div class="col-sm-10 p1">
                <input type="file" name="image" id="image">
                <p class="help-block small">                   
                    *Must be gif, jpg or png file under 2 MB.
                </p>
            </div>
        </div>
        
        <div class="form-goup">
            <label for="title" class="col-sm-2 control-label">Title: </label>
            <div class="col-sm-10 p1">
                <input type="text" class="form-control" name="title" id="post_author" placeholder="Appears top left in slide show display" >
            </div>
        </div>
        
        <div class="form-goup">
            <label for="alt" class="col-sm-2 control-label">Alt text: </label>
            <div class="col-sm-10 p1">
                <input type="text" class="form-control" name="alt" id="alt" placeholder="What search engines read" >
            </div>
        </div>

        <div class="col-sm-offset-2 col-sm-10">
            <button type="submit" class="btn btn-primary center-block p1"  name="action" value="add_new_gallery_image">Add image</button>
        </div>

    </form>
</div><!-- // #add-category-form  -->