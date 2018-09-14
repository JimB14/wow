<?php
include 'includes/login-check.inc.php';
?>

<h1 class="text-center" style="margin-bottom:10px;"><?php if (isset($page_title)) echo htmlspecialchars($page_title); ?></h1>
   
    <p class="red"><?php if (isset($errMsg)) htmlout($errMsg); ?></p>
    
<div id="new-post-form">  
    
    <form class="form-horizontal" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" enctype="multipart/form-data">
        <?php foreach($events as $event): ?>

        <div class="form-goup">
            <label for="event_title" class="col-sm-2 control-label">Event Title: </label>
            <div class="col-sm-10 p1">
                <input type="text" class="form-control" name="event_title" id="event_title"  value="<?php if(isset($event['event_title'])) {echo htmlspecialchars($event['event_title']);} ?>">

            </div> 
        </div>



        <div class="form-goup">
            <label for="event_date" class="col-sm-2 control-label">Date: </label>
            <div class="col-sm-10 p1">
                <input type="text" class="form-control" name="event_date" id="event_date" value="<?php if(isset($event['event_date'])) {echo htmlspecialchars($event['event_date']);} ?>">
            </div>
        </div>

        <div class="form-goup">
            <label for="event_location" class="col-sm-2 control-label">Location: </label>
            <div class="col-sm-10 p1">
                <input type="text" class="form-control" name="event_location" id="event_location" value="<?php if(isset($event['event_location'])) {echo htmlspecialchars($event['event_location']);} ?>">
            </div>
        </div>
               

        <div class="form-goup">
            <label for="event_image" class="col-sm-2 control-label">Event Image: </label>
            <div class="col-sm-10 p1">
                <p class="help-block text-size90">*Select new image or current image before updating</p>
                <input type="file" name="event_image" id="post_image"><img style="padding:7px 0px 4px 0px;" src="uploaded_event_images/<?php if(isset($event['event_image'])) {echo htmlspecialchars($event['event_image']);} ?>" width="110">
                <p class="help-block small">*File must be selected</p>
            </div>
        </div>
        
        
        <div class="form-goup">
            <label for="event_description" class="col-sm-2 control-label">Description: </label>
            <div class="col-sm-10 p1">
                <textarea class="form-control" name="event_description" id="event_description" placeholder="Description"  rows="10"><?php if (isset($event['event_description'])) {echo htmlspecialchars($event['event_description']);} ?></textarea>
            </div>
        </div>

        

        <div class="col-sm-offset-2 col-sm-10 p1">
            <input type="hidden" name="event_id" value="<?php htmlout($event['event_id']); ?>">
            <button type="submit" class="btn btn-primary center-block p1"  name="action" value="update_event" title="MAKE SURE&#10;YOU SELECTED&#10;AN IMAGE">Update Now</button>
        </div>
        <?php endforeach; ?>
    </form><!--  // .form  --> 
    
</div><!-- // #new-post-form  -->