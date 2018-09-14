<?php
foreach ($events as $event): 
$title = $event["event_title"];
$page_id = 'events';
$description = 'Single event';
include 'includes/helper.php';
include 'includes/header.php';
?>

<div class="container">
    <div class="row"> 

        <div class="col-md-9">
            <div class="white-bg">
                    <h1 style="letter-spacing: 10px; margin-top: 0px;" class="text-center text-uppercase"><?php echo htmlspecialchars($title); ?></h1>
                    <div class="event-single-page"> 

                        <img class="img-responsive center-block" src="admin/uploaded_event_images/<?php htmlout($event['event_image']); ?>">
                            <h1 class="text-left colora9a9a9" style="margin-bottom:15px;"><?php htmlout($event['event_title']); ?></h1>                                     
                            <p class="bold text24" style="color:#393939;"><?php htmlout($event['event_date']); ?></p>
                            <p class="bold text20" style="color:#393939;"><?php htmlout($event['event_location']); ?></p>
                            <p><?php echo $event['event_description']; ?> </p>
                            <div>                       
                                <a class="btn btn-primary" href="contact.php?inquiry=RE%20the%20event: <?php htmlout($event['event_title']); ?>">Contact us for more information</a>
                            </div>

                    </div><!-- // .event-single-page  -->
                </div><!-- // .white-bg  -->
                                                     
        <?php endforeach; ?>
                        
        </div><!-- // .col-md-9  -->
        
  
        
        
        <div class="col-md-3 light-gray-bg sidebar">

            <?php include 'includes/side-margin-right.inc.php'; ?>

        </div><!-- // .col-md-3  -->
        
    </div><!--  // .row  -->
</div><!-- // .container  -->

<!-- Go to www.addthis.com/dashboard to customize your tools -->
<script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-56fad0667e200529"></script>


<?php include 'includes/footer.php';