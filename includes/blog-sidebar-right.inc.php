<h3 class="text-center bg-purple" style="color:#fff; margin-bottom: 20px;;">
    Search
</h3>

<div style="margin-bottom: 25px;">

    <form class="inline" role="search" method="get" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" enctype="multipart/form-data">
        <div class="input-group">
            <input type="text" class="form-control small" name="search_query" placeholder="Words to search" required>
            <span class="input-group-btn">
                <input type="hidden" name="action" value="search">
                <button type="submit" class="btn btn-default">
                    Search
                </button>
            </span>
        </div>
    </form>

</div>


<h3 class="text-center bg-purple" style="color:#fff;">
    Posts by Category
</h3>

<div id="category-list">                    
    <ul>                   
        <?php foreach ($categories as $category): ?>       
        <li><a href="?cat_id=<?php echo htmlspecialchars($category['cat_id']); ?>&cat_title=<?php echo htmlspecialchars(strtolower((preg_replace("~[^0-9a-z-]~i", "",(str_replace(' ', '-', $category['cat_title'])))))); ?>"><?php echo htmlspecialchars($category['cat_title']); ?></a></li>
        <?php endforeach; ?>
        <li><a href="index.php?get_page=blog&amp;id=5">All posts</a></li>
    </ul>
</div>                 