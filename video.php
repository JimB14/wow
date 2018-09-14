<?php
session_start();
$title = 'Video';
$page_id = 'video';
$description = '';
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


                        <div class="panel-body height-line16 text-center">
                            
                            <div class="embed-responsive embed-responsive-16by9" style="margin-bottom:15px;">
                                <iframe class="embed-responsive-item" src="https://www.youtube.com/embed/uYR_xoGvcgs" frameborder="0" allowfullscreen></iframe>
                            </div>
                            
                            <div class="embed-responsive embed-responsive-16by9" style="margin-bottom:15px;">
                                <iframe class="embed-responsive-item" src="https://www.youtube.com/embed/6L0tBRGJfFI" frameborder="0" allowfullscreen></iframe>
                            </div>
                            
                            <div class="embed-responsive embed-responsive-16by9" style="margin-bottom:15px;">
                                <iframe class="embed-responsive-item" src="https://www.youtube.com/embed/iA0Zs-QcECw" frameborder="0" allowfullscreen></iframe>
                            </div>
                            
                            <div class="embed-responsive embed-responsive-16by9" style="margin-bottom:15px;">
                                <iframe class="embed-responsive-item" src="https://www.youtube.com/embed/S5B2znAK_Xw" frameborder="0" allowfullscreen></iframe>
                            </div>
                            
                            <div class="embed-responsive embed-responsive-16by9" style="margin-bottom:15px;">
                                <iframe class="embed-responsive-item" src="https://www.youtube.com/embed/xkcXx3pIyhw" frameborder="0" allowfullscreen></iframe>
                            </div>

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