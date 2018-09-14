<?php
include 'includes/login-check.inc.php';
?>

<h1 class="text-center" style="margin-bottom:10px;"><?php if(isset($page_title)) echo htmlspecialchars($page_title); ?></h1>

<div id="edit-post-form">
    <p class="red"><?php if(isset($errMsg)) htmlout($errMsg); ?></p>
    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" enctype="multipart/form-data">
        <?php foreach($pages as $page): ?>

        <div class="form-goup">
            <label for="page_name" class="col-sm-3 control-label">Page name: </label>
            <div class="col-sm-9 p1">
                <input type="text" class="form-control" name="page_name" value="<?php if(isset($page['page_name'])) {echo $page['page_name'];} ?>">
            </div>
        </div> 
        
        
        <?php
        include 'includes/dbconnect.php';
        $table = 'main_menu';

        // Get all category fields to display in select drop down
        try {
            $sql = "SELECT * FROM $table
                    WHERE main_menu_id < '3'";
            $s = $db->prepare($sql);
            $s->execute();

            // Loop below not required. I don't know why. When used it produces double results
            // in drop-down, which appears to mean that the $categories array must already exist

            while ($row = $s->fetch(PDO::FETCH_ASSOC)) {
                $main_menu[] = array(
                    'main_menu_id' => $row['main_menu_id'],
                    'main_menu_name' => $row['main_menu_name'],
                    'page_id' => $row['page_id']
                );
            }
        } 
        catch (PDOException $e) {
            $errMsg = 'Unable to retrieve data from database' . $e->getMessage();
            include 'includes/error.html.php';
            exit();
        }

        // Close database connection
        $db = null;

        ?>
         <div class="form-goup">
            <label for="main_menu_id" class="col-sm-3 control-label">Menu name:</label>
            <div class="col-sm-9 p1">
                <select class="form-control" name="main_menu_id">
                    <option value="<?php if(isset($page['main_menu_id'])) {echo $page['main_menu_id'];} ?>"><?php if(isset($page['main_menu_name'])) {echo $page['main_menu_name'];} ?></option>  
                    <?php foreach($main_menu as $menu): ?>
                    <option value="<?php echo $menu['main_menu_id'] ?>"><?php echo $menu['main_menu_name']; ?></option>
                    <?php endforeach; ?>
                </select>
            </div> 
         </div>
        
        
        <div class="form-goup">
            <label for="main_menu_name" class="col-sm-3 control-label">Menu name: </label>        
            <div class="col-sm-9 p1">
                <span class="text-size80 blue" style="margin-top:-10px;">*repeat selection</span>
                <select class="form-control" name="main_menu_name" id="main_menu_name">                    
                    <option value="<?php if(isset($page['main_menu_id'])) {echo $page['main_menu_id'];} ?>"><?php if(isset($page['main_menu_name'])) {echo $page['main_menu_name'];} ?></option>  
                    <?php foreach($main_menu as $menu): ?>
                    <option value="<?php htmlout($menu['main_menu_name']); ?>"><?php htmlout($menu['main_menu_name']); ?></option>
                    <?php endforeach; ?>
                </select>               
            </div>          
        </div>
                

        <div class="form-goup">
            <label for="page_image" class="col-sm-3 control-label">Image: </label>
            <div class="col-sm-9 p1">
                <p class="help-block text-size90">*Select new image or current image before updating</p>
                <input type="file" name="page_image"><img style="padding:7px 0px 4px 0px;" src="uploaded_page_images/<?php if(isset($page['page_image'])) {echo $page['page_image'];} ?>" width="110">
                <p class="help-block small"> 
                    *Image optional. Not required. If added, must be gif, jpg or png file under 2 MB.
                </p>
            </div>
        </div>
        

        <div class="form-goup">
            <label for="page_content" class="col-sm-3 control-label">Content: </label>
            <div class="col-sm-9 p1">
                <textarea class="form-control" name="page_content" id="page_content" placeholder="Page Content"  rows="20"><?php if(isset($page['page_content'])) {echo $page['page_content'];} ?></textarea>
            </div>
        </div>
        

        <div class="col-sm-offset-3 col-sm-9">
            <input type="hidden" value="<?php echo $page['page_id']; ?>" name="page_id">
            <button type="submit" class="btn btn-primary center-block p1"  name="action" value="update_page" title="MAKE SURE&#10;YOU SELECTED&#10;AN IMAGE">Update</button>
        </div>
        

        <?php endforeach; ?>
    </form>   
</div>