<?php
$title = 'Mission';
$page_id = 'about';
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
                            To reach out to women entangled in sex trafficking in the streets, stripping clubs, prisons, bad habits, and 
                            addictions and share with them the bountiful love of God though His Son Jesus Christ in simplicity.
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