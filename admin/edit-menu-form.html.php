<?php
include 'includes/login-check.inc.php';
?>

<h1 class="text-center" style="margin-bottom:10px;"><?php if(isset($page_title)) echo htmlspecialchars($page_title); ?></h1>


<div id="add-category-form"> 
    
    <form class="form-horizontal" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" enctype="multipart/form-data">
        <?php foreach($menu as $item): ?>
        <div class="form-goup">
            <label for="main_menu_id" class="col-sm-4 control-label">Menu ID (display only): </label>
            <div class="col-sm-8 p1">
                <input type="text" class="form-control" name="main_menu_id" value="<?php if(isset($item['main_menu_id'])) {echo $item['main_menu_id'];} ?>" readonly>
            </div>
        </div>

        <div class="form-goup">
            <label for="main_menu_name" class="col-sm-4 control-label">Menu name: </label>
            <div class="col-sm-8 p1">
                <input type="text" class="form-control" name="main_menu_name" value="<?php if(isset($item['main_menu_name'])) {echo $item['main_menu_name'];} ?>">
            </div>
        </div>

        <div class="col-sm-offset-4 col-sm-8">
            <button type="submit" class="btn btn-primary p1"  name="action" value="update_menu" onclick="return confirm('Update menu name now?');">Update</button>
        </div>
        <?php endforeach; ?>
    </form>
</div><!-- // #add-category-form  -->                