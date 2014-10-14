		<div id="sidebar">
            <div class="brad hidemobile">
                <header class="hidemobile">
                    <ico class="sprite-list hidemobile"></ico>
                    VOC&Ecirc; ESTÁ EM
                </header>
                <ul class="post-categories">
                <?php
                    $category = get_the_category();
                    $parent_id = $category[0]->category_parent;
                    $parent_cat = get_the_category_by_ID( $parent_id );
                    if ( is_string($parent_cat) && $category[0]->name != $parent_cat ) {
                        echo '<li><a href="'.get_site_url().'/category/'.$parent_cat.'/" rel="category tag">'.$parent_cat.'</a></li>';
                    }
                    echo '<li><a href="'.get_site_url().'/category/'.$category[0]->slug.'/" rel="category tag">'.$category[0]->name.'</a></li>';
                ?>
                </ul>
            </div>
            
            <div class="author">
                <?php 
                    if ( esc_attr(get_the_author_meta( 'avatar', $user->ID )) ) {
                        ?><img width="100%" src="<?php echo esc_attr( get_the_author_meta( 'avatar', $user->ID ) ); ?>" alt="" /><?php
                    }
                ?>
                <h4><span class="mobile">Por: </span><?php the_author_meta( 'user_firstname', $userID ); echo " "; the_author_meta( 'user_lastname', $userID ); ?></h4>
                <p><?php 
                    the_author_meta( 'description', $userID );

                ?></p>
                <div class="authorshare">
                    <header class="hidemobile">
                        <ico class="sprite-share-author author-share hidemobile"></ico>
                        COMPARTILHE
                    </header>
                    
                    <header class="mobile">
                        <ico class="sprite-share-mobile mobile"></ico>
                    </header>
                    <?php 

                    $actual_link = get_permalink();
                    echo "<a href=\"http://www.facebook.com/sharer.php?u='+encodeURIComponent(u)".urlencode($actual_link)."\" target=\"_blank\" title=\"Facebook do autor\" class=\"sprite-facebook-author hidemobile\">Facebook</a>";
                    echo "<a href=\"http://www.twitter.com/share?text=Li+e+gostei+no+Blog+da+Marisa&url=".urlencode($actual_link)."\" target=\"_blank\" title=\"Twitter do autor\" class=\"sprite-twitter-author hidemobile\">Twitter</a>";
                    echo "<a href=\"http://plus.google.com/share?url=".urlencode($actual_link)."\" target=\"_blank\" title=\"Google Plus do autor\" class=\"sprite-gplus-author hidemobile\">Google Plus</a>";
                    

                    echo "<a href=\"http://www.facebook.com/sharer.php?u='+encodeURIComponent(u)".urlencode($actual_link)."\" target=\"_blank\" title=\"Facebook do autor\" class=\"sprite-facebook-author sprite-facebook-mobile mobile\">Facebook</a>";
                    echo "<a href=\"http://www.twitter.com/share?text=Li+e+gostei+no+Blog+da+Marisa&url=".urlencode($actual_link)."\" target=\"_blank\" title=\"Twitter do autor\" class=\"sprite-twitter-author sprite-twitter-mobile mobile\">Twitter</a>";
                    echo "<a href=\"http://plus.google.com/share?url=".urlencode($actual_link)."\" target=\"_blank\" title=\"Google Plus do autor\" class=\"sprite-gplus-author sprite-gplus-mobile mobile\">Google Plus</a>";
                    
                    ?>
                </div>
            </div>
			<?php /*if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Sidebar') ) : ?><?php endif;*/ ?>
		</div>