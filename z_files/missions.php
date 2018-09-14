<?php
$title = 'Missions';
$page_id = 'ministries';
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
                        <p>
                            Apart from having our monthly meetings in Minnesota, we also believe in sending more women to different parts of the world to plant more Women of 
                            Worship gatherings. So far, in Kenya we have an Annual conference every December with Pastors/Ministers wives and other women who come together 
                            for powerful teachings, workshops, impartations, etc. We have also introduced Women of Worship in Kabale, Uganda. We believe God to keep doing 
                            this wherever He enables us.

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