<?php define("page", "page"); ?>
<?php get_header(); ?>

<section id="page">
	<div class="container">
		<div id="artigos">
            <?php 
                $argspage = array(
                    'post_type' => 'page',
                    'pagename' => getLastPathSegment($_SERVER['REQUEST_URI'])
                );
                //query_posts($args);
                $resultspage = new WP_Query( $argspage ); 
            ?>
            <?php if ( $resultspage->have_posts() ) : while ( $resultspage->have_posts() ) : $resultspage->the_post(); ?>
                <div class="pagecontent">
                    <h1><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h1>
                    <p><?php the_content(); ?></p>
                </div>
            <?php endwhile; else: ?>
                <div class="artigo">
                    <h2>Nada Encontrado</h2>
                    <p>Erro 404</p>
                    <p>Lamentamos mas não foram encontrados artigos.</p>
                </div>            
            <?php endif; ?>
			
		</div>
		
		<?php //get_sidebar(); ?>
	</div>
</section>
<?php include(TEMPLATEPATH . '/socials.php'); ?>
<?php get_footer(); ?>