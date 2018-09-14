<div class="collapse navbar-collapse" id="myNavbar">
                        <ul class="nav navbar-nav">
                            <li class="<?php
                            if (isset($page_id) && $page_id === 'main') {
                                echo 'active';
                            }
                            ?>"><a href="."><span class="glyphicon glyphicon-home"></span></a></li>
                            
                            <li class="dropdown <?php
                            if (isset($page_id) && $page_id === 'about') {
                                echo 'active';
                            }
                            ?>">
                                <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                                    About<span class="caret"></span>
                                </a>
                                <ul class="dropdown-menu"> 
                                    <?php foreach($about_menu as $page): ?>
                                    <li>
                                        <a href="index.php?get_page=<?php echo htmlspecialchars($page['page_name']); ?>&id=<?php echo htmlspecialchars($page['page_id']); ?>&menu=<?php echo htmlspecialchars($page['menu_id']); ?>">
                                            <?php echo '<span style class="text-capitalize">' . htmlspecialchars($page['page_name']) . '</span>' ?>
                                        </a>
                                    </li>
                                    <?php endforeach; ?>                                 
                                    <li><a href="leaders.php">Leaders</a></li>
                                </ul>
                            </li>

                            <li class="dropdown <?php
                            if (isset($page_id) && $page_id === 'ministries') {
                                echo 'active';
                            }
                            ?>">
                                <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                                    Ministries<span class="caret"></span>
                                </a>
                                <ul class="dropdown-menu">
                                    <?php foreach($ministries_menu as $page): ?>
                                    <li>
                                        <a href="index.php?get_page=<?php echo htmlspecialchars($page['page_name']); ?>&id=<?php echo htmlspecialchars($page['page_id']); ?>&menu=<?php echo htmlspecialchars($page['menu_id']); ?>">
                                            <?php echo '<span style class="text-capitalize">' . htmlspecialchars($page['page_name']) . '</span>' ?>
                                        </a>
                                    </li>
                                    <?php endforeach; ?>
                                </ul>
                            </li>
                            
                            <li class="<?php
                            if (isset($page_id) && $page_id === 'gallery') {
                                echo 'active';
                            }
                            ?>"><a href="index.php?goto=gallery">Gallery</a></li>                                                                                 
                            
                            <li class="<?php
                            if (isset($page_id) && $page_id === 'events') {
                                echo 'active';
                            }
                            ?>"><a href="index.php?goto=events">Events</a></li>
                            
                            <li class="<?php
                            if (isset($page_id) && $page_id === 'blog') {
                                echo 'active';
                            }
                            ?>"><a href="index.php?goto=blog">Blog</a></li>

                            <li class="<?php
                            if (isset($page_id) && $page_id === 'contact') {
                                echo 'active';
                            }
                            ?>"><a href="contact.php">Contact</a></li>
                        </ul>
                                                       
                        <ul  class="nav navbar-nav pull-right">
                            <li class="<?php
                            if (isset($page_id) && $page_id === 'store') {
                                echo 'active';
                            }
                            ?>"><a href="index.php?goto=store">Shop</a></li>
                            
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
                    </div><!--  // . collapse  -->