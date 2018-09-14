<?php
include 'includes/login-check.inc.php';
?>

<h1 class="text-center" style="margin-bottom:10px;"><?php if (isset($page_title)) echo htmlspecialchars($page_title); ?></h1>
   
    <p class="red"><?php if (isset($errMsg)) htmlout($errMsg); ?></p>
    
<div id="new-post-form">  
    
    <form class="form-horizontal" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" enctype="multipart/form-data">

        <div class="form-goup">
            <label for="page_name" class="col-sm-2 control-label">Page name: </label>
            <div class="col-sm-10 p1">
                <input type="text" class="form-control" name="page_name" id="page_name" placeholder="Page name" value="<?php if (isset($page)) echo htmlspecialchars($page_name); ?>" autofocus required>
            </div>
        </div>
        
        <div class="form-goup">
            <label for="main_menu_id" class="col-sm-2 control-label">Menu name: </label>                         
            <div class="col-sm-10 p1">
                <select class="form-control" name="main_menu_id" id="main_menu_id">                   
                    <option value="">Select menu</option>
                    <?php foreach($menu as $item): ?>
                    <option value="<?php htmlout($item['main_menu_id']); ?>"><?php htmlout($item['main_menu_name']); ?></option>
                    <?php endforeach; ?>
                </select>               
            </div>          
        </div>
        
        
        <div class="form-goup">
            <label for="main_menu_name" class="col-sm-2 control-label">Menu name: </label>        
            <div class="col-sm-10 p1">
                <span class="text-size80 blue" style="margin-top:-10px;">*repeat selection</span>
                <select class="form-control" name="main_menu_name" id="main_menu_name">                    
                    <option value="">Select menu</option>
                    <?php foreach($menu as $item): ?>
                    <option value="<?php htmlout($item['main_menu_name']); ?>"><?php htmlout($item['main_menu_name']); ?></option>
                    <?php endforeach; ?>
                </select>               
            </div>          
        </div>
        
        
        <div class="form-goup">
            <label for="page_image" class="col-sm-2 control-label">Image: </label>
            <div class="col-sm-10 p1">
                <input type="file" name="page_image" id="page_image">
                <p class="help-block small"> 
                    *Image optional. Not required. If added, must be gif, jpg or png file under 2 MB.
                </p>
            </div>
        </div>

        <div class="form-goup">
            <label for="page_content" class="col-sm-2 control-label">Content: </label>
            <div class="col-sm-10 p1">
                <textarea class="form-control" name="page_content" id="page_content" placeholder="Page Content"  rows="15"><?php if (isset($page_content)) echo htmlspecialchars($page_content); ?></textarea>
            </div>
        </div>

        <div class="col-sm-offset-2 col-sm-10 p1">
            <button type="submit" class="btn btn-primary center-block p1"  name="action" value="insert_page_content">Publish Now</button>
        </div>

    </form><!--  // .form  --> 
    
</div><!-- // #new-post-form  -->