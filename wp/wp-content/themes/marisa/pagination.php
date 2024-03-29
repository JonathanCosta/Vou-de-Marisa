<?php
require_once('../../../wp-config.php'); 
$theme_opts = get_option('marisa_options');
$args = array(
    'posts_per_page' => $theme_opts['marisa_logo_posts_page'],
    'post_type' => 'post',
    'paged' => $_GET['page'],
    'order' => 'DESC'
);

if($_GET['category'] != 'undefined') {
    $args['category_name'] = $_GET['category'];
}

if($_GET['order'] != 'undefined') {
    $args['orderby'] = $_GET['order'];
}

query_posts($args);
global $count;
$count = $_GET['loadeditems'];
$totalposts = $wp_query->found_posts;
if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
<div class="general" rel="<?php echo $totalposts; ?>">
    <div class="artigo <?php
        if ($count % 3 == 0) { echo "first"; }
    ?>" style="opacity:0;">
        <a href="<?php the_permalink() ?>"><?php if ( has_post_thumbnail() ) { the_post_thumbnail(); } ?></a>
        <div class="call-box">
            <h3><?php echo $first; ?><?php the_category(); ?></h3>
            <h2><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h2>
            <p><?php echo words(get_field('resumo_de_capa'), 15); ?></p>
        </div>
    </div>
    <?php $count++; ?>
    <?php endwhile?>
</div>
<?php else: ?>nothing<?php endif; ?>