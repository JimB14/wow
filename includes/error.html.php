<?php
$page_id = 'error';
$title = 'Error';
$description = 'Eror';
include 'includes/header.php';
?>

<div class="page-wrapper">
    <div class="container">
        <div class="row">            

            <div class="col-md-12 t2">
                <!--<h3 style="color:#AEAA04;">Error detected!</h3>-->
                <div>
                    <!--<h2>Sorry, error detected.</h2>-->
                    <h3 class="errMsg text-center">
                        <?php 
                            if(isset($errMsg) && isset($link)) {echo $errMsg . ' ' . $link;} else {echo $errMsg;} 
                        ?>
                    </h3>
                    <!--<h3><a href="javascript: history.go(-1);"><i class="fa fa-angle-double-left"></i> Go back</a></h3>-->
                    <h2>&nbsp;</h2>      
                </div> <!-- //   -->
            </div><!-- // End column -->      

        </div><!-- // .row   -->
    </div><!-- // .container   -->
</div><!-- // .page-wrapper  -->

<?php
include 'includes/footer.php';    