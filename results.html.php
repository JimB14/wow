<?php
$title = 'Search Results';
$description = 'snippet here';
include 'includes/helper.php';
include 'includes/header.php';
?>


<div class="container">
    <div class="row"> 

        <div class="col-md-9 col-sm-9">
            
            <h3 class="text-center" style="margin-bottom: 15px;">Search results for <span style="color:#3b3bff;">&quot;<?php htmlout($_SESSION['search']); ?></span>&quot;</h3>

            <?php include 'includes/post_content.inc.php'; ?>

        </div><!-- // .col-md-9  -->


        <div class="col-md-3 col-sm-3" style="margin-top:60px;">

            <?php include 'includes/blog-sidebar-right.inc.php'; ?>

        </div><!-- // .col-md-3  -->

    </div><!-- // .row  -->
</div><!-- // .container -->


<!-- no clue why these must be here for it to work!  -->
</div></div>
<!-- // end -->
<?php
include 'includes/footer.php';