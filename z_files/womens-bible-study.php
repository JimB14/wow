<?php
$title = 'Women\'s Bible Study';
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
                            In addition to meeting once a month we also have an intimate time with women, especially those who may feel uncomfortable/shy to attend our monthly 
                            meetings where there are a lot of people. We understand some women have come from very traumatic backgrounds and may feel comfortable being in a small 
                            group. 
                            <br><br>
                            This Bible study is designed to cater to such needs as we dig into the Word of God in simplicity. We usually have many topics designed to rebuild 
                            these hurting women. 
                            <br><br>
                            For more information, please contact us to sign you up for this Bible study.

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