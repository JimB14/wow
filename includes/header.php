<?php
include 'includes/dbconnect.php';
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <title><?php echo htmlspecialchars($title); ?></title>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags --> 

        <meta name="description" content="<?php echo htmlspecialchars($description); ?>">
        <!-- Bootstrap -->
        <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
          <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->

        <link rel="shortcut icon" href="images/favicon.ico" type="image/x-icon">
        <link rel="apple-touch-icon" href="images/apple-touch-icon.png">
        <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
        <link rel="stylesheet" href="css/bootstrap.css">
        <link rel="stylesheet" href="css/animate.css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
        <link href='https://fonts.googleapis.com/css?family=Londrina+Shadow|Vast+Shadow|Dancing+Script' rel='stylesheet' type='text/css'>
        <link href='https://fonts.googleapis.com/css?family=Shadows+Into+Light' rel='stylesheet' type='text/css'>

        <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
        <!-- Include all compiled plugins (below), or include individual files as needed -->
        <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
        
        <!-- Font Awesome -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
        
        <!-- for Gallery  -->
        <?php
        if(isset($page_id) && $page_id === 'gallery'){
            echo '<link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">';
            echo '<link rel="stylesheet" href="//blueimp.github.io/Gallery/css/blueimp-gallery.min.css">';
            echo '<link rel="stylesheet" href="css/bootstrap-image-gallery.min.css">';
            echo '<link rel="stylesheet" href="css/blueimp-gallery.min.css">';
        }?>
        <!-- // Gallery  -->

        <!-- Google fonts -->
        <link href='https://fonts.googleapis.com/css?family=Shadows+Into+Light' rel='stylesheet' type='text/css'>

        <!-- Must be below bootstrap styles -->
        <link rel="stylesheet" href="css/style.css">
        <!--<link rel="stylesheet" href="css/hovericons.css">-->
        <!--<link rel="stylesheet" href="css/animations.css">-->

        <!-- WOW --><!-- http://mynameismatthieu.com/WOW/docs.html -->    
        <script src="js/wow.js"></script>
        <script>
            wow = new WOW(
                    {
                        boxClass: 'wow', // default
                        animateClass: 'animated', // default
                        offset: 0, // default
                        mobile: true, // default
                        live: false       // default = true
                    }
            );
            wow.init();
        </script>     

        <style>
            /* Note: Try to remove the following lines to see the effect of CSS positioning */
            .affix {
                top: 0;
                width: 100%;
            }

            .affix + .container-fluid {
                padding-top: 70px;
            }
        </style>
    </head>
    <body>
        <div class="container-fluid bg-header text-center" >
            <div class="header">
                <div class="container">
                    <div class="col-md-4 col-sm-4" id="wow-logo">
                        <a href="."><img class="img-responsive" src="images/logo_900x310.png" alt="women of worship logo"></a>
                    </div>
                    <div class="col-md-8 col-sm-8">
                        <div id="wow-box">
                            <p id="wow-header">Women of Worship</p>
                        </div>
                    </div>
                </div><!--  // .container  -->
            </div>
        </div>

        <nav class="navbar" data-spy="affix" data-offset-top="235">
            <div class="container-fluid">
                <div class="container">

                    <!-- Brand and toggle get grouped for better mobile display -->
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar" aria-expanded="false">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                    </div>

                    <?php// include 'old_navbar.inc.php'; ?>
                    
                    
                     <div class="collapse navbar-collapse" id="myNavbar">
                                       
                         <!--  Resource for dynamic navbar dropdown from MySQL tables:  http://www.codingcage.com/2015/03/dynamic-drop-down-menu-using-php-and.html  -->
                         <ul class="nav navbar-nav">
                            <li><a href="."><span class="glyphicon glyphicon-home"></span></a></li>                
                            <?php
                            $res = $db->query("SELECT * FROM main_menu");
                                while($row = $res->fetch(PDO::FETCH_ASSOC)){
                                    $main_menu_id = $row['main_menu_id'];
                                    
                                    ?>
                                    <li class="dropdown">
                                        <?php
                                            // Check if menu has submenu items by its assigned (not dynamic) main_main_id. If true, display dropdown functionality.
                                            if(isset($row['main_menu_id']) && $row['main_menu_id'] > 2){
                                                echo '<a class="text-capitalize" href="index.php?get_page='.$row['main_menu_name'].'&amp;id='.$row['page_id'].'">'.$row['main_menu_name']. '</a>';
                                            }
                                            else {
                                                echo '<a class="dropdown-toggle text-capitalize" data-toggle="dropdown" href="index.php?get_page='.$row['main_menu_name'].'&amp;id='.$row['page_id'].'">'.$row['main_menu_name'].'<span class="caret"></span></a>';
                                            }
                                        ?>                                                                              
                                 

                                    <?php $res_pro = $db->query("SELECT * FROM pages WHERE main_menu_id=".$row['main_menu_id']);?>
                                    
                                        <ul class="dropdown-menu text-capitalize">    
                                            <?php  
                                                while($pro_row=$res_pro->fetch(PDO::FETCH_ASSOC)){?>


                                            <li><a href="index.php?get_page=<?php echo $pro_row['page_name']; ?>&amp;id=<?php echo $pro_row['page_id']; ?>"><?php echo $pro_row['page_name']; ?></a></li>
                                            <?php }?>
                                        </ul>
                                    </li> <?php
                                }
                                ?>
                                    
                                    
                            </ul> 
                         
                            <ul class="nav navbar-nav pull-right">

                                <li class="<?php
                                if (isset($page_id) && $page_id === 'cart') {
                                    echo 'active';
                                }
                                ?>"><a href="index.php?goto=cart">
                                        <span class="glyphicon glyphicon-shopping-cart"></span>                             
                                        <?php if(isset($session_cart_count)) { echo '<span class="badge">' . $session_cart_count . '</span>'; } else if(isset($cart_items_count)) {echo '<span class="badge">' . $cart_items_count . '</span>';} ?>                               
                                    </a>
                                </li>
                                
                            </ul>                                     
                 
                    </div><!-- // .collapse navbar-collapse  --> 

                </div><!-- // .container  -->
            </div><!-- // .container-fluid  -->         
        </nav>