<?php
$title = 'Monthly Meetings';
$page_id = 'ministries';
$description = '';
include 'includes/helper.php';
include 'includes/header.php';
?>


<!--  - - - - - - - - - - -  Content  - - - - - - - - - - - - -->

<div class="container">
    <div class="row">

        <div class="col-md-8">
            <h1 style="letter-spacing: 10px;" class="text-center text-uppercase"><?php echo htmlspecialchars($title); ?></h1>

                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">WoW <?php echo htmlspecialchars($title); ?></h3>
                    </div>
                    <div class="panel-body height-line16">
                        <p>
                            We host Women of Worship Monthly Meetings every fourth Saturday of the month at 2011 21st Ave, South Minneapolis, Minnesota 55404 from 2:00 PM - 4:30 PM where we gather 
                            together as women to fellowship, pray, have Christian teachings, worship, encourage each other, and have fun in the presence of God. 
                            <br><br>
                            We believe these meetings will empower women to rise up from mediocrity and be instruments of change in the spheres of influence. If you ever find yourself 
                            in Minnesota you are welcome to fellowship with us.
                        </p>
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