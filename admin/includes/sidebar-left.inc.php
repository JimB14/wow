<div style="padding-top:50px;">
    <ul class="list-group text-right">
        <li class="list-group-item bold text-center text-uppercase">
            Events  
        </li>
        <li class="list-group-item"><a href="index.php?goto=add_event">Add event</a></li>
        <li class="list-group-item"><a href="index.php?goto=view_events">View events</a></li> 
        <li class="list-group-item text-center text-uppercase bold">
            <a href="index.php?goto=logout" title="FOR SECURITY&#10;ALWAYS LOG OUT&#10;WHEN FINISHED">  <!-- Resource: http://stackoverflow.com/questions/358874/how-can-i-use-a-carriage-return-in-a-html-tooltip -->
                <span class="glyphicon glyphicon-chevron-left"></span>
                Logout 
                <span class="glyphicon glyphicon-chevron-right"></span>
            </a>
        </li>
    </ul>
</div>

<div style="margin-top:-10px;">
    <ul class="list-group text-right">
        <li class="list-group-item bold text-center text-uppercase">
            Gallery  
        </li>
        <li class="list-group-item"><a href="index.php?goto=add_image">Add new image</a></li>
        <li class="list-group-item"><a href="index.php?goto=view_gallery_images">View images</a></li>
    </ul>
</div>

<div style="margin-top:-10px;">
    <ul class="list-group text-right">
        <li class="list-group-item bold text-center text-uppercase">
            Pages  
        </li>
        <li class="list-group-item"><a href="index.php?goto=add_page">Add page</a></li>
        <li class="list-group-item"><a href="index.php?goto=view_pages">View pages</a></li> 
        <li class="list-group-item bold text-center text-uppercase">Menu</li>
        <li class="list-group-item"><a href="index.php?goto=add_menu">Add menu</a></li>
        <li class="list-group-item"><a href="index.php?goto=view_menu">View menu</a></li>
    </ul>
</div>

<div style="margin-top:-10px;">
    <ul class="list-group text-right">
        <li class="list-group-item bold text-center text-uppercase">Blog</li>
        <li class="list-group-item"><a href="index.php?goto=newpost">New post</a></li>
        <li class="list-group-item"><a href="index.php?goto=view_posts">View posts</a></li>  
        <li class="list-group-item"><a href="index.php?goto=view_categories">View categories</a></li>
        <li class="list-group-item"><a href="index.php?goto=create_category">Add category</a></li>       
        <li class="list-group-item"><a href="index.php?goto=view_comments">View comments</a></li>         
        <li class="list-group-item"><a href="index.php?goto=view_comments">Comments Pending Approval (<?php if(isset($unapproved_count)) {htmlout($unapproved_count);} ?>)</a></li>
        <!--<li class="list-group-item"><a href=".">Admin - home</a></li>-->        
    </ul>
</div>

<div style="margin-top:-10px;">
    <ul class="list-group text-right">
        <li class="list-group-item bold text-center text-uppercase">
            Store  
        </li>
        <li class="list-group-item"><a href="index.php?goto=add_product">Add product</a></li>
        <li class="list-group-item"><a href="index.php?goto=view_products">View products</a></li>        
        <li class="list-group-item"><a href="index.php?goto=add_product_category">Add category</a></li>
        <li class="list-group-item"><a href="index.php?goto=view_product_categories">View categories</a></li>
    </ul>
</div>