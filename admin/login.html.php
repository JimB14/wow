<?php
// Include functions
$description = 'Login';
include 'includes/header.php';
include 'includes/helper.php';
?>


<div class="container">
    <!--<img id="login-bg" src="images/login-bg.jpg">-->
    <div class="row">
        <div class="col-md-offset-4 col-md-4 col-md-offset-4">

            <div class="border-box p3 bg-fff">
                <h1 style="margin-bottom:10px;">Log In</h1>

                <?php if (isset($loginError)): ?>
                    <p style="color:#ff0000;">*<?php htmlout($loginError); ?></p>
                    <p><?php endif; ?></p>

                <form action="" method="post">
                    <div class="form-group">
                        <label for="email">Email </label>
                        <input type="text" class="form-control" name="email" id="email" placeholder="Email" autofocus>
                    </div><!-- // .form-group -->

                    <div class="form-group">
                        <label for="password">Password </label> 
                        <input type="text" class="form-control" name="password" placeholder="Password" id="password">
                    </div><!-- // .form-group -->

                    <button  class="btn btn-primary btn-block" type="submit" name="action" value="login">Login</button>
                </form>

                <!--<p><a href=".">Return to home</a></p>-->

            </div><!-- // .box-general -->

        </div><!-- // .col-md-5 -->       
    </div><!-- // .row -->
</div><!-- // .container -->