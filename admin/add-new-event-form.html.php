<?php
include 'includes/login-check.inc.php';
?>

<h1 class="text-center" style="margin-bottom:10px;"><?php if (isset($page_title)) echo htmlspecialchars($page_title); ?></h1>
   
    <p class="red"><?php if (isset($errMsg)) htmlout($errMsg); ?></p>
    
<div id="new-post-form">  
    
    <form class="form-horizontal" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" enctype="multipart/form-data">

        <div class="form-goup">
            <label for="event_title" class="col-sm-2 control-label">Event Title: </label>
            <div class="col-sm-10 p1">
                <input type="text" class="form-control" name="event_title" id="event_title" placeholder="Event Title" value="<?php if (isset($event_title)) echo htmlspecialchars($event_title); ?>" autofocus required>
            </div>
        </div>



        <div class="form-goup">
            <label for="event_date" class="col-sm-2 control-label">Date: </label>
            <div class="col-sm-10 p1">
                <input type="text" class="form-control" name="event_date" id="datepicker"  placeholder="YYYY-MM-DD" value="<?php if (isset($event_date)) echo htmlspecialchars($event_date); ?>" required>
            </div>
        </div>

        <div class="form-goup">
            <label for="event_location" class="col-sm-2 control-label">Location: </label>
            <div class="col-sm-10 p1">
                <input type="text" class="form-control" name="event_location" id="event_location" placeholder="Location" value="<?php if (isset($event_location)) echo htmlspecialchars($event_location); ?>" required>
            </div>
        </div>
               

        <div class="form-goup">
            <label for="event_image" class="col-sm-2 control-label">Event Image: </label>
            <div class="col-sm-10 p1">
                <input type="file" name="event_image" id="event_image">
                <p class="help-block small">                   
                    *Must be gif, jpg or png file under 2 MB.
                </p>
            </div>
        </div>
        
        <div class="form-goup">
            <label for="event_description" class="col-sm-2 control-label">Description: </label>
            <div class="col-sm-10 p1">
                <textarea class="form-control" name="event_description" id="event_description" placeholder="Description"  rows="10"><?php if (isset($event_description)) echo htmlspecialchars($event_description); ?></textarea>
            </div>
        </div>

        

        <div class="col-sm-offset-2 col-sm-10 p1">
            <button type="submit" class="btn btn-primary center-block p1"  name="action" value="insert_event" title="MAKE SURE&#10;YOU SELECTED&#10;AN IMAGE">Publish Now</button>
        </div>

    </form><!--  // .form  --> 
    
</div><!-- // #new-post-form  -->

<script>
/* Resource:  http://jqueryui.com/datepicker/#date-formats 
 * and: http://stackoverflow.com/questions/2486854/formatting-out-of-a-jquery-ui-datepicker   */    

  $(function() {
    $( "#datepicker" ).datepicker();
    $( "#datepicker" ).datepicker("option", "dateFormat", "yy-mm-dd");

  });
  
</script>