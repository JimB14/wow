<?php
session_start();
$page_id = 'thankyou';
$title = 'Thank You';
$description = 'Thank you | WoW';
include 'includes/header.php';
?>

<div class="container">
    <h2 class="p1 home-sub-title text-center wow bounceInDown" data-wow-duration="2s" data-wow-delay="1s" data-wow-offset="10"  data-wow-iteration="1"><?php if (isset($title)) {echo htmlspecialchars($title);} ?></h2>

    <div class="row p2">        
        <div class="col-md-12 col-sm-12">           
            <h2 class="p1 wow fadeInLeft text-center" data-wow-duration="1s" data-wow-delay="0.5s" data-wow-offset="50" data-wow-iteration="1">Thank you <?php if (isset($_SESSION['name'])) {echo htmlspecialchars($_SESSION['name']);} ?>! <br><br>Your message has been sent!  We will be in touch.</h2>
            <h2 class="wow flash errMsg" data-wow-duration="3s" data-wow-delay="2s" data-wow-offset="10" data-wow-iteration="2"><img id="warranty-image" class="img-responsive center-block" src="images/thank_you.jpg" alt="thank you image"></h2>
        </div>
    </div>
</div>

<?php
include 'includes/footer.php';