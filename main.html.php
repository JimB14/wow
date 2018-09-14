<?php
$title = 'Home';
$page_id = 'main';
$description = '';
include 'includes/helper.php';
include 'includes/header.php';
?>


<?php include 'includes/carousel_slider.php'; ?>

<!--   Main Content  -->

<div class="container">
    <!--
    <script>
        function white(){document.body.style.backgroundColor='#fff';}
        function purple(){document.body.style.backgroundColor='#cc96ec';}
        function light_purple(){document.body.style.backgroundColor='#ebd7f8';}
        function lighter_purple(){document.body.style.backgroundColor='#f3e8fb';}
        function lightest_purple(){document.body.style.backgroundColor='#fcf8fe';}
    </script>
    <p style="margin:0px;margin-top:-30px;">Select background color</p>
    <button style="background-color:#fff;" type="button" onclick="white()">White</button>
    <button style="background-color:#cc96ec;" type="button" onclick="purple()">Your choice</button>
    <button style="background-color:#ebd7f8;" type="button" onclick="light_purple()">Light purple</button>
    <button style="background-color:#f3e8fb;" type="button" onclick="lighter_purple()">Lighter purple</button>
    <button style="background-color:#fcf8fe;" type="button" onclick="lightest_purple()">Lightest purple</button>
    -->
    
    <div class="row">
        
        <div class="col-md-8">
            <h1 style="letter-spacing: 10px;" class="text-center text-uppercase">Welcome</h1>
            
            <div class="panel panel-default">                                      

<!--                <div class="panel-heading">
                    <h3 class="panel-title">WoW <?php echo htmlspecialchars($title); ?></h3>
                </div>-->


                <div class="panel-body height-line16 text-center">

                    <div class="embed-responsive embed-responsive-16by9">
                        <iframe class="embed-responsive-item" src="https://www.youtube.com/embed/gFryHatisTQ" frameborder="0" allowfullscreen></iframe>
                    </div>

                </div>
                </div>   
            <div style="padding:20px;">
                <h2 class="text-center">&quot;Grace and Peace&quot; from the founder of WoW</h2>
                
                <p style="font-size: 120%" class="p2">
                    
                    <?php 
                    
                    if(isset($home_page['page_content']))  {
                            echo $home_page['page_content'];                           
                        }                    
                    ?>
                </p>                     
            </div>
        </div>

        <div class="col-md-4">

            <?php include 'includes/side-margin-right.inc.php'; ?> 

        </div>
    </div>
</div>


<?php
include 'includes/footer.php';