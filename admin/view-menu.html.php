<?php
include 'includes/login-check.inc.php';
?>

<h1 class="text-center" style="margin-bottom:10px;"><?php if(isset($page_title)) echo htmlspecialchars($page_title); ?></h1>

<div class="table-responsive">
    <p class="red"><?php if (isset($errMsg)) htmlout($errMsg); ?></p>
    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" enctype="multipart/form-data">        
        <table class="table table-bordered insert-post bg-fff">

            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Edit</th>
                    <th>Delete <span style="color:#ff0000; margin-top:-10px; font-size:24px;">*</span></th>
                </tr>
            </thead>

            <tbody>
                <?php foreach($menu as $item): ?>
                <tr>
                    <td><?php echo $item['main_menu_id']; ?></td>
                    <td><?php echo $item['main_menu_name']; ?></td>
                    <td><a class="btn btn-default btn-sm" href="index.php?edit_menu=<?php echo $item['main_menu_id'] ?>">Edit</a></td>
                    <td><a class="btn btn-danger btn-sm" href="index.php?delete_menu=<?php echo $item['main_menu_id'] ?>" onclick="return confirm('Permanently delete this menu?');">&times;</a></td>
                </tr>
                <?php  endforeach; ?>

            </tbody>
        </table>

    </form>
    <h4 style="color:#ff0000;"><span style="color:#ff0000; margin-top:-25px; font-size:30px;">*</span>Warning! Do <strong>not</strong> delete menu names that you have not added. You cannot 
    add them back if deleted without a web developer. If this happens, please contact Jim Burns at jim.burns14@gmail.com.</h4>
</div><!-- // .table-responsive  -->     