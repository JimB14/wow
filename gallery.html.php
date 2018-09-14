<?php
$title = 'Gallery';
$page_id = 'gallery';
$description = '';
include 'includes/helper.php';
include 'includes/header.php';
?>


<!-- - - - - - - - - - - - - - - - - -   Content  - - - - - - - - - - - - - - -->

<div class="container">
    <div class="row">

        <div class="col-md-8">
            <h1 style="letter-spacing: 10px;" class="text-center text-uppercase">
                <?php echo htmlspecialchars($title); ?> 
                <span class="badge" style="letter-spacing: 0; margin-top:-20px;">
                    <?php if(isset($gallery_count) && $gallery_count > 0 ) {htmlout($gallery_count);} ?>
                </span>
            </h1>
            
            <!--  Source code:  https://github.com/blueimp/Bootstrap-Image-Gallery. Under MIT License: https://opensource.org/licenses/MIT  -->
            <!-- The Bootstrap Image Gallery lightbox, should be a child element of the document body -->
            <div id="blueimp-gallery" class="blueimp-gallery blueimp-gallery-controls" data-use-bootstrap-modal="true">
                
                <!-- The container for the modal slides -->
                <div class="slides"></div>
                
                <!-- Controls for the borderless lightbox -->
                <h3 class="title"></h3>
                <a class="prev">‹</a>
                <a class="next">›</a>
                <a class="close">×</a>
                <a class="play-pause"></a>
                <ol class="indicator"></ol>
                
                <!-- The modal dialog, which will be used to wrap the lightbox content -->
                <div class="modal fade">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" aria-hidden="true">&times;</button>
                                <h4 class="modal-title"></h4>
                            </div>
                            <div class="modal-body next"></div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default pull-left prev">
                                    <i class="glyphicon glyphicon-chevron-left"></i>
                                    Previous
                                </button>
                                <button type="button" class="btn btn-primary next">
                                    Next
                                    <i class="glyphicon glyphicon-chevron-right"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                
            </div><!--  // .blueimp-gallery  -->
            
            <div id="links">
                <?php foreach($images as $image): ?>   
                <a href="admin/uploaded_gallery_images/<?php htmlout($image['image']); ?>" title="<?php htmlout($image['title']); ?>" data-gallery>
                    <img src="admin/uploaded_gallery_images/<?php htmlout($image['thumbnail']); ?>" alt="<?php htmlout($image['alt']); ?>">
                </a>
                <?php endforeach; ?>           
            </div><!-- // #links  -->


        </div><!-- // .col-md-8  -->

        <div class="col-md-4">
            <?php include 'includes/side-margin-right.inc.php'; ?>           
        </div><!--  //  .col-md-4  -->

    </div><!-- // .row  -->
</div><!--  //  .container  -->


<?php
include 'includes/footer.php';