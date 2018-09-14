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
                    <th>Title</th>
                    <th>Date</th>
                    <th>Location</th>
                    <th>Description</th>
                    <th>Image</th>
                    <th>Edit</th>
                    <th>Delete</th>
                </tr>
            </thead>

            <tbody>
                <?php 
                if (isset($results)) {
                    foreach($results as $event){ ?>
                <tr>
                    <td><?php echo $event->event_id; ?></td>
                    <td><?php echo $event->event_title; ?></td>
                    <td><?php echo $event->event_date; ?></td>
                    <td><?php echo $event->event_location; ?></td>
                    <td><?php echo $event->event_description; ?></td>
                    <td><img src="uploaded_event_images/<?php echo $event->event_image; ?>" width="60"></td>
                    <td><a class="btn btn-default btn-sm" href="index.php?edit_event=<?php echo $event->event_id; ?>">Edit</a></td>
                    <td><a class="btn btn-danger btn-sm" href="index.php?delete_event=<?php echo $event->event_id; ?>&image=<?php echo $event->event_image; ?>" onclick="return confirm('Permanently delete this event?');">&times;</a></td>
                    
                    
                    <!--
                    <td><?php// echo $event['event_id']; ?></td>
                    <td><?php// echo $event['event_title']; ?></td>
                    <td><?php// echo $event['event_date']; ?></td>
                    <td><?php// echo $event['event_location']; ?></td>
                    <td><?php// echo substr($event['event_description'], 0, 300); ?></td>
                    <td><img src="uploaded_event_images/<?php// echo $event['event_image']; ?>" width="60"></td>
                    <td><a class="btn btn-default btn-sm" href="index.php?edit_event=<?php// echo $event['event_id']; ?>">Edit</a></td>
                    <td><a class="btn btn-danger btn-sm" href="index.php?delete_event=<?php// echo $event['event_id']; ?>&image=<?php// echo $event['event_image']; ?>" onclick="return confirm('Permanently delete this event?');">&times;</a></td>
                    -->
                </tr>
                <?php
                    }
                }?>

            </tbody>
        </table>

    </form>
    
</div><!-- // .table-responsive  -->     