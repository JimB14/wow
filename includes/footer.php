<!-- ******************************  Footer  ************************************-->

<!-- ******************************  Bottom  ************************************-->

<div id="bottom" class="bg-bottom text-center">
    <div class="container">
        <div class="row p1">
            <div class="col-md-12">
                <div class="p1">
                    &copy; <script>var today = new Date();
                    document.write(today.getFullYear());</script> 
                    Women Of Worship &nbsp; 
                    | &nbsp; www.womenofworshipus.com &nbsp;
                    | &nbsp; All Rights Reserved &nbsp;
                    <br>
                    &nbsp; <a href="mailto:womenofworship3@gmail.com?Subject=Please%20contact%20me" target="_top"><i class="fa fa-envelope"></i> Email</a> &nbsp;
                    | &nbsp; <a href="tel:7634000893"><i class="fa fa-phone"></i> 763-400-0893</a>&nbsp;
                    | &nbsp; <a href="tel:6122295126"><i class="fa fa-mobile"></i> 763-657-6413</a>&nbsp;
                    | &nbsp; <a href="tel:6124834604"><i class="fa fa-mobile"></i> 612-483-4604</a>&nbsp;
                    | &nbsp; <a href="#">Terms of Use</a> &nbsp;
                    | &nbsp; <a href="#"> Privacy Policy</a> &nbsp; 
                </div>
                
                <div id="social-bar">
                    <ul class="social-network social-circle">
                        <li><a href="https://www.facebook.com/wow.womenofworship/" target="_blank" class="icoFacebook" title="Facebook"><i class="fa fa-facebook fa-lg"></i></a></li>
                        <li><a href="#" target="_blank" class="icoTwitter"  title="Twitter"><i class="fa fa-twitter fa-lg"></i></a></li>
                        <li><a href="#" target="_blank" class="icoPinterest"   title="Google +"><i class="fa fa-pinterest fa-lg"></i></a></li>
                        <li><a href="https://plus.google.com/u/0/110752650747989497991/posts" target="_blank" class="icoGoogle"   title="Google +"><i class="fa fa-google-plus fa-lg"></i></a></li>
                        <li><a href="#" target="_blank" class="icoLinkedin" title="Linkedin"><i class="fa fa-linkedin fa-lg"></i></a></li>
                    </ul>
                </div>

                
                <p class="wmp">Web development by <a href="http://www.webmediapartners.com" target="_blank" rel="follow">Web Media Partners</a></p>
            </div><!-- // .col-md-12 -->
        </div><!-- // .row -->
    </div>
</div><!-- // #bottom  -->

<!-- *****************************************************************************-->

<?php/*
if(isset($page_id) && $page_id === 'main'){
    include 'local_storage_script.php';
} */
?>

<script>
    $('.more-less').click(function() {
        var $this = $(this);
        $this.toggleClass('more-less');
        if ($this.hasClass('more-less')) {
            $this.text('Read more');
        } else {
            $this.text('Hide');
        }
    });
</script>

<script>
$(document).ready(function(){
    /*
    $("#add_item_to_cart").hover(function(){
        if( $("#size").val() === '' ){
            alert("Please select a size before adding item to cart.");
        }
    });
    */
    
    $("#add-to-cart").click(function(){
        var productCategory = $("#productCategory").text();        
        var size = $("#size").val();
        if(productCategory == "clothing" && size == ""){
            console.log("Size = " + size);
            console.log("Product category = " + productCategory);
            alert("You must select a size.")
            return false;
        }
        
        
    });

});

</script>

<?php
if(isset($page_id) && $page_id === 'gallery'){
    
    include 'includes/gallery_js_scripts.inc.php';
}
?>

</body>
</html>  