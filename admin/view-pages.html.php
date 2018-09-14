<?php
include 'includes/login-check.inc.php';
?>

<h1 class="text-center" style="margin-bottom:10px;">
    <?php if(isset($page_title)) echo htmlspecialchars($page_title); ?>
     <?php if(isset($gallery_count)) {
        echo "<span class='badge' style='margin-top:-20px;'>$gallery_count</span>";
    }
    ?>
</h1>

<div class="table-responsive">
    <p class="red"><?php if (isset($errMsg)) htmlout($errMsg); ?></p>
    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">        
        <table class="table table-bordered insert-post bg-fff">

            <thead>
                <tr>
                    <th>Page name</th>                    
                    <th>Menu ID</th>
                    <th>Menu name</th>
                    <th>&nbsp;</th>
                    <th>Content</th>
                    <th>Edit</th>
                    <th>Delete</th>
                </tr>
            </thead>

            <tbody>
                <?php if(isset($pages_count) && count($pages_count) > 0){
                    foreach($pages as $page) { ?>
                <tr>                                    
                    <td><?php htmlout($page['page_name']); ?></td>
                    <td><?php htmlout($page['main_menu_id']); ?></td>
                    <td><?php htmlout($page['main_menu_name']); ?></td>
                    <td><img src="uploaded_page_images/<?php htmlout($page['page_image']); ?>" alt="image" height="50"></td>
                    <td><?php htmlout(substr($page['page_content'], 0, 300)); ?></td>             
                    <td><a class="btn btn-default btn-sm" href="index.php?edit_page=<?php htmlout($page['page_id']); ?>">Edit</a></td>
                    <td><a class="btn btn-danger btn-sm" href="index.php?delete_page=<?php htmlout($page['page_id']); ?>&image=<?php htmlout($page['page_image']); ?>" onclick="return confirm('Permanently delete this page?');">&times;</a></td>
                </tr>
                    <?php }
                } else {
                    echo '<div class="alert alert-warning">';
                    echo '<h4 style="margin-bottom:0px">No content to display.</h4>';
                    echo '</div>';
                }?> 
            </tbody>
        </table>

    </form>
    
</div><!-- // .table-responsive  -->  