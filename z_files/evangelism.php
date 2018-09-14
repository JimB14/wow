<?php
$title = 'Evangelism';
$page_id = 'ministries';
$description = '';
include 'includes/helper.php';
include 'includes/header.php';
?>


<!-- - - - - - - - - - - - -   Content  - - - - - - - - - - - -  -->

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
                            The harvest is ready but the laborers are few. 
                            <br><br>
                            We are going to the streets, prisons, stripping clubs, shelters and wherever we can find women as we share with them the love of Christ. If you want to join this team, please <a href="mailto:evangelism@womenofworshipus.com?Subject=From%20website:%20Interest%20in%20Evangelism">send us an email</a> and we will be glad to connect with you.
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