<?php
$title = 'Intercessory';
$page_id = 'ministries';
$cms_page_name = 'intercessory';
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
                        
                        <?php foreach($page as $content): ?>
                        
                        <?php if(isset($content['page_content']))  {echo $content['page_content'];}  ?>
                        
                        <?php endforeach; ?>
                                               
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