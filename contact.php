<?php
session_start();
$title = 'Contact';
$page_id = 'contact';
$description = '';
include 'includes/helper.php';

if (isset($_POST['action']) && $_POST['action'] === 'submit_contact_info') {
    
    $name = sanitize($_POST['name']);
    $email = sanitize($_POST['email']);
    $telephone = sanitize($_POST['telephone']);
    $form_message = sanitize($_POST['message']);
    
    // Store visitor name in SESSION variable for use @thankyou
    $_SESSION['name'] = $name;  

    // Check if fields have input
    if(empty($name)){
        $errMsg['name'] = '*Please enter your name.';
    }
    elseif(empty($email)){
        $errMsg['email'] = '*Please enter your email address.';
    }
    elseif(empty($telephone)) {
        $errMsg['telephone'] = '*Please enter your telephone number.';
    }            
    
    if(count($errMsg) == 0) {
    
        // Prepare message for e-mail; set e-mail recipient  
        $jim_gmail = 'jim.burns14@gmail.com';
        $damaris = 'womenofworship3@gmail.com';

        $to = $damaris;
        $subject = 'Web site visitor';
        $from = $email;
        $message = '
        <html>
        <head></head>
        <body>
        <h2>Web site message via Contact Form</h2>
        <p>Name: ' . $name . '<br>
           Email: ' . $email . '<br>
           Telephone: ' . $telephone . '<br>
           Message: ' . $form_message . '<br><br>  
        </body>
        </html>
        '; // end of message
        // To send HTML mail, the Content-type header must be set
        $headers = 'MIME-Version: 1.0' . "\r\n";      // code to send HTML on UNIX
        $headers .= 'Content-type:text/html; charset=iso-8859-1' . "\r\n";

        // Additional headers
        $headers .= 'From: ' . $from . "\r\n";
        //$headers .= 'Bcc: ' . $marylou . "\r\n";         
        $headers .= 'Bcc: ' . $jim_gmail . "\r\n"; 

        // Send message using mail() function 
        mail($to, $subject, $message, $headers);

        header('Location: thankyou.php');
        exit();
    }
}

include 'includes/header.php';
?>


<!-- ------------------  Content  -------------------------------- -->

<div class="container">
    <div class="row">

        <div class="col-md-8">
            
            <h1 style="letter-spacing: 10px;" class="text-center text-uppercase"><?php echo htmlspecialchars($title); ?></h1>

                <div class="panel panel-default">
                <div class="panel-heading"></div>
                <div class="panel-body">
                    <h4 class="p1">Please provide the following information.</h4>
                    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" name="contact-form" method="post">
                        <div class="form-group has-feedback">
                            <p class="errMsg"><?php
                                if (isset($errMsg['name'])) {
                                    echo htmlspecialchars($errMsg['name']);
                                }
                                ?></p>
                            <label class="control-label">Name </label><sup><span class="glyphicon glyphicon-asterisk"></span></sup>
                            <input type="text" name="name" class="form-control" id="name" placeholder="Name" value="<?php if (isset($name)) echo htmlspecialchars($name); ?>" autofocus="autofocus">
                            <i class="glyphicon glyphicon-user form-control-feedback"></i>
                        </div>
                        <div class="form-group has-feedback">
                            <p class="errMsg"><?php
                                if (isset($errMsg['email'])) {
                                    echo htmlspecialchars($errMsg['email']);
                                }
                                ?></p>
                            <label class="control-label">Email address </label><sup><span class="glyphicon glyphicon-asterisk"></span></sup>
                            <input type="email" name="email" class="form-control" id="email" placeholder="Email" value="<?php if (isset($email)) echo htmlspecialchars($email); ?>">
                            <i class="glyphicon glyphicon-envelope form-control-feedback"></i>
                        </div>
                        <div class="form-group has-feedback">
                            <p class="errMsg"><?php
                                if (isset($errMsg['telephone'])) {
                                    echo htmlspecialchars($errMsg['telephone']);
                                }
                                ?></p>
                            <label class="control-label">Telephone</label><sup><span class="glyphicon glyphicon-asterisk"></span></sup>
                            <input type="text" name="telephone" class="form-control" id="telephone" placeholder="Telephone" value="<?php if (isset($telephone)) echo htmlspecialchars($telephone); ?>">
                            <i class="glyphicon glyphicon-earphone form-control-feedback"></i>
                        </div>
                        
                        <div class="form-group">
                            <label for="message">Message</label>
                            <textarea id="message" class="form-control" name="message" rows="2" placeholder="How can we help you?"><?php if(isset($_GET['inquiry'])) echo $_GET['inquiry']; ?></textarea>
                        </div>
                                                                                                                                          
                        <button style="background-color: #301482;" type="submit" class="btn btn-primary btn-lg btn-block" name="action" value="submit_contact_info">Submit</button>
                    </form>

                </div><!-- // .panel-body -->
            </div><!-- // .panel -->

        </div><!-- // .col-md-8  -->

        <div class="col-md-4">
            <?php include 'includes/side-margin-right.inc.php'; ?>           
        </div><!--  //  .col-md-4  -->

    </div><!-- // .row  -->
</div><!--  //  .container  -->


<?php
include 'includes/footer.php';