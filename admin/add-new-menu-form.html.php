<?php
include 'includes/login-check.inc.php';
?>

<h1 class="text-center" style="margin-bottom:10px;"><?php if (isset($page_title)) echo htmlspecialchars($page_title); ?></h1>


<div id="add-category-form"> 
    
    <form class="form-horizontal" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" enctype="multipart/form-data">

        <div class="form-goup">
            <label for="menu" class="col-sm-4 control-label">Current menu names:</label>
            <div class="col-sm-8 p1">
                <select class="form-control" name="menu">
                    <?php foreach ($menu as $item): ?>
                        <option value="<?php htmlout($item['main_menu_id']) ?>"><?php htmlout($item['main_menu_name']); ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>

        <div class="form-goup">
            <label for="new_menu" class="col-sm-4 control-label">New menu: </label>
            <div class="col-sm-8 p1">
                <input type="text" class="form-control" name="new_menu" id="new_menu" placeholder="Menu name" required>
            </div>
        </div>

        <div class="col-sm-offset-4 col-sm-8">
            <button type="submit" class="btn btn-primary center-block p1"  name="action" value="add_new_menu">Add Menu</button>
        </div>

    </form>
</div><!-- // #add-category-form  -->