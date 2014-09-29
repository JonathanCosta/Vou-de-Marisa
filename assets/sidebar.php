		<div id="sidebar">
            <div class="author">
                <?php 
                    if ( esc_attr(get_the_author_meta( 'avatar', $user->ID )) ) {
                        ?><img width="100%" src="<?php echo esc_attr( get_the_author_meta( 'avatar', $user->ID ) ); ?>" alt="" /><?php
                    }
                ?>
                <h4><?php the_author_meta( 'user_firstname', $userID ); echo " "; the_author_meta( 'user_lastname', $userID ); ?></h4>
                <p><?php 
                    the_author_meta( 'description', $userID );

                ?></p>
                <div class="authorshare">
                    <header>
                        <ico class="sprite-share-author author-share"></ico>
                        COMPARTILHE
                    </header>
                    <?php 
                    $link = the_permalink();
                    if (strlen($facebook)>0) {
                        echo "<a href=\"http://www.facebook.com/sharer.php?u='+encodeURIComponent(u)".urlencode($actual_link)."\" target=\"_blank\" title=\"Facebook do autor\" class=\"sprite-facebook-author\">Facebook</a>";
                    } 
                    
                    if (strlen($twitter)>0) {
                        echo "<a href=\"http://www.twitter.com/share?text=Li+e+gostei+no+Blog+da+Marisa&url=".urlencode($actual_link)."\" target=\"_blank\" title=\"Twitter do autor\" class=\"sprite-twitter-author\">Twitter</a>";
                    } 
                        
                    if (strlen($gplus)>0) {
                        echo "<a href=\"http://plus.google.com/share?url=".urlencode($actual_link)."\" target=\"_blank\" title=\"Google Plus do autor\" class=\"sprite-gplus-author\">Google Plus</a>";
                    }
                    ?>
                </div>
            </div>
			<?php /*if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Sidebar') ) : ?><?php endif;*/ ?>
		</div>