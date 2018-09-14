<?php
$title = 'Events';
$page_id = 'events';
$description = '';
include 'includes/helper.php';
include 'includes/header.php';
?>


<!-- ------------------  Content  -------------------------------- -->

<div class="container">
    <div class="row">

        <div class="col-md-8">
            <h1 style="letter-spacing: 10px;" class="text-center text-uppercase"><?php echo htmlspecialchars($title); ?></h1>

                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">WoW <?php echo htmlspecialchars($title); ?></h3>
                    </div>
                    <div class="panel-body height-line16">
                        <div class="event-display-box">
                            
                            <?php
                            if (count($events) > 0) {

                                foreach ($events as $event) {
                                    ?>
                                    <div class="event-single"> 
                                        <div class="col-md-4">
                                            <img class="img-responsive pull-left p1" src="admin/uploaded_event_images/<?php htmlout($event['event_image']); ?>" alt="<?php htmlout($event['event_title']); ?>">           
                                        </div>
                                        <div class="col-md-8">
                                            <div style="padding-left: 15px;">
                                                <h3 style="margin:0px 0px 15px 0px;">  <a href="index.php?getevent=<?php htmlout($event['event_id']);?>&gettitle=<?php htmlout(strtolower((preg_replace("~[^0-9a-z-]~i", "",(str_replace(' ', '-', $event['event_title'])))))); ?>"><?php htmlout($event['event_title']); ?></a></h3>
                                                <p style="margin-bottom: 5px; color:#838383;" class="bold text20"><?php htmlout($event['event_date']); ?></p>
                                                <p style="padding-left:0px; color:#222;" class="bold text20"><?php htmlout($event['event_location']); ?></p> 
                                                <p style="color:#000;"><?php echo substr($event['event_description'],  0, 100); ?></p>
                                                <p class="pull-right p2"><a href="index.php?getevent=<?php htmlout($event['event_id']); ?>">  Read more <i class="fa fa-angle-double-right"></i></a></p>
                                            </div>
                                        </div>
                                    </div>
                                    <?php
                                }
                            } else {
                                $no_event_message = 'Sorry, there are no events!';
                            }
                            ?>

                        </div><!-- // .event-display-box  -->
                        
                    </div>
                </div>

        </div><!-- // .col-md-8  -->

        <div class="col-md-4">
            <?php include 'includes/side-margin-right.inc.php'; ?>           
        </div><!--  //  .col-md-4  -->

    </div><!-- // .row  -->
</div><!--  //  .container  -->


<?php
include 'includes/footer.php';