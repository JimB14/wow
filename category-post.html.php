<?php
$title = 'Category Posts';
$description = 'Category posts';
$page_id = 'blog';
include 'includes/helper.php';
include 'includes/header.php';
?>


<div class="container">
    <div class="row">

        <div class="col-md-9 col-sm-9">
            
                <h2 class="text-center text-uppercase" style="margin-bottom:20px;letter-spacing: 10px;" >
                    <?php 
                        if(isset($_SESSION['category_id']) && $_SESSION['category_id'] == 1){
                            echo 'Leadership Posts'; 
                        }if (isset($_SESSION['category_id']) && $_SESSION['category_id'] == 2){
                            echo 'Worship Posts';
                        }if (isset($_SESSION['category_id']) && $_SESSION['category_id'] == 3){
                            echo 'Community Posts';
                        }if (isset($_SESSION['category_id']) && $_SESSION['category_id'] == 4){
                            echo 'Hurting - Healing Posts'; 
                        }if (isset($_SESSION['category_id']) && $_SESSION['category_id'] == 5){
                            echo 'Rise Up Posts';
                        }                                          
                    ?>
                    <span class="badge" style="margin-top:-15px; letter-spacing: 0px;"><?php if(isset($cat_post_count)) htmlout($cat_post_count); ?></span>
                </h2>

                
                <?php 
                if(isset($posts) && count($posts) > 0){
                    foreach ($posts as $post) { ?>
                
                <div class="post-single-main">
                    <h2 style="margin-bottom:15px;">  <a href="?getpost=<?php htmlout($post['post_id']);?>&gettitle=<?php htmlout(strtolower((preg_replace("~[^0-9a-z-]~i", "",(str_replace(' ', '-', $post['post_title'])))))); ?>"><?php htmlout($post['post_title']); ?></a></h2>         
                    <!--<h2 style="margin-bottom:15px;">  <a href="index.php?getpost=<?php htmlout($post['post_id']); ?>"><?php htmlout($post['post_title']); ?></a></h2>-->         
                    <img class="img-responsive pull-left p1" src="admin/uploaded_post_images/<?php htmlout($post['post_image']); ?>">
                    <span class="shadows-font">Category </span><span style="padding-left:0px; color:#000;" class="bold"><?php htmlout($post['cat_title']); ?></span>
                    <br>
                    <span class="shadows-font">Posted by </span> <span style="padding-left:0px; color:#000;" class="bold"><?php htmlout($post['post_author']); ?></span> &nbsp; 
                    <span class="shadows-font">On </span> <span style="color:#000;" class="bold"><?php htmlout($post['post_date']); ?></span>
                    <span class="bold"><?php if(isset($comment_count)) { echo 'Comments ' . '(' . htmlspecialchars($comment_count) . ')';} ?></span>
                    <p class="text-justify"><?php echo $post['post_content']; ?></p>
                    <p style="padding-bottom: 20px;" class="pull-right p2"><a href="index.php?getpost=<?php htmlout($post['post_id']); ?>">  Read more <i class="fa fa-angle-double-right"></i></a></p>
                </div>
                    <?php }
                } 
                else {
                    $no_category_post = 'No posts in this category';
                } 
                
                if(isset($no_category_post)) {
                    echo '<div class="alert alert-warning text-center">';
                    echo '<h4 style="margin-bottom:0px;">' . htmlspecialchars($no_category_post) . '</h4>';
                    echo '</div>';
                }
                ?>
        </div><!-- // .col-md-9  -->
                
       <div class="col-md-3 col-sm-3" style="margin-top:54px;">
                       
            <h3 class="text-center bg-purple" style="color:#fff;">
                Posts by Category
            </h3>

            <div id="category-list">
                    
                <ul>                   
                    <?php foreach ($categories as $category): ?>
                    <li><a href="index.php?cat_id=<?php echo htmlspecialchars($category['cat_id']); ?>&cat_title=<?php echo htmlspecialchars(strtolower((preg_replace("~[^0-9a-z-]~i", "",(str_replace(' ', '-', $category['cat_title'])))))); ?>"><?php echo htmlspecialchars($category['cat_title']); ?></a></li>
                    <!--<li><a href="index.php?cat_id=<?php echo htmlspecialchars($category['cat_id']); ?>"><?php echo htmlspecialchars($category['cat_title']); ?></a></li>-->
                    <?php endforeach; ?>
                    <li><a href="index.php?get_page=blog&amp;id=5">All posts</a></li>
                </ul>

            </div>
                  
        </div><!--  //  .col-md-3  -->

    </div><!-- // .row  -->
</div><!-- // .container -->


<!-- no clue why these must be here for it to work!  -->
</div></div>
<!-- // end -->
<?php
include 'includes/footer.php';