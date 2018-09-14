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
                    <th>&nbsp;</th>
                    <th>Image</th>
                    <th>Thumbnail</th>
                    <th>Title</th>
                    <th>Alt text</th> 
                    <th>Upload date</th> 
                    <th>Edit</th>
                    <th>Delete</th>
                </tr>
            </thead>

            <tbody>
                <?php if(isset($images) && count($images) > 0){
                    foreach($images as $image) { ?>
                <tr>
                    <td><img src="uploaded_gallery_images/<?php htmlout($image['thumbnail']); ?>" alt="image" height="50"></td>
                    <td><?php htmlout(substr($image['image'], 0, 20)); ?></td>
                    <td><?php htmlout(substr($image['thumbnail'], 0, 20)); ?></td>
                    <td><?php htmlout($image['title']); ?></td>
                    <td><?php htmlout($image['alt']); ?></td>
                    <td><?php htmlout($image['upload_date']); ?></td>             
                    <td><a class="btn btn-default btn-sm" href="index.php?edit_gallery_image=<?php htmlout($image['id']); ?>">Edit</a></td>
                    <td><a class="btn btn-danger btn-sm" href="index.php?delete_gallery_image=<?php htmlout($image['id']); ?>&image=<?php htmlout($image['image']); ?>&thumbnail=<?php htmlout($image['thumbnail']); ?>" onclick="return confirm('Permanently delete this image?');">&times;</a></td>
                </tr>
                    <?php }
                } else {
                    echo '<div class="alert alert-warning">';
                    echo '<h4 style="margin-bottom:0px">No images to display.</h4>';
                    echo '</div>';
                }?> 
            </tbody>
        </table>

    </form>
    
</div><!-- // .table-responsive  -->  