<?php
$title = 'Band and Arts';
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
                            We are raising the Women of Worship band which consists of all women i.e singer, instrumentalists, and musicians among others. We believe that this 
                            is a powerful tool and avenue for reaching out to more women. There are a lot of women with great gifts yet the enemy has deceived them to sit down 
                            and do nothing. Through this ministry, we will be able to influence women to worship the Lord in Spirit and in Truth. The band leads worship during 
                            our monthly meetings and also hosts its own worship concerts and goes to prisons to reach out to more women.
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