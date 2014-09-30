<?php 
/*
Plugin Name: Marisa Search Engine
Plugin URI: http://vert.se
Description: Plugin de do sistema de busca
Version: 1.0
Author: Miguel Alves
Author URI: http://vert.se
*/

function busca_entries( ) {
    $theme_opts = get_option('marisa_options');
    global $wp_query;
    $query_args = array(
        'posts_per_page' => 100,
        'post_type' => 'post',
        'paged' => 1,
        's' => $_GET["b"],
        'exact' => false,
        'sentance' => false   
    );
    //query_posts($args);
    $results = new WP_Query( $query_args ); 
    global $count;
    $count = 0;
        if ( $results->have_posts() ) : ?>
    
        <div class="resultados">
            <ico class="sprite-lupa"></ico>
            <p>Resultados da Busca para <span><?php echo $_GET["b"]; ?></span>. Foram encontrados <b><?php echo $results->found_posts; ?> artigos</b>.</p>
        </div>
    
        <?php while ( $results->have_posts() ) : $results->the_post(); ?>
        <div class="artigo <?php
            if ($count % 3 == 0) { echo "first"; }
        ?>">
            <a href="<?php the_permalink() ?>"><?php if ( has_post_thumbnail() ) { the_post_thumbnail(); } ?></a>
            <div class="call-box">
                <h3><?php echo $first; ?><?php the_category(); ?></h3>
                <h2><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h2>
                <p><a href="<?php the_permalink() ?>"><?php the_field('resumo_de_capa'); ?></a></p>
            </div>
        </div>
        <?php $count++; ?>
        <?php endwhile?>
    <?php else: ?>
        <div class='col1 naoencontrado'>
            <h5><ico class="sprite-alert"></ico>Nada Encontrado</h5>
            <p>Breve texto de introdução Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
            <p class="bolder">Sua busca n&atilde;o encontrou nenhum resultado correspondente.</p>
            <div class="busca-box">
                <h4>SUGESTÕES</h4>
                <p><ico class="sprite-positive"></ico>Certifique-se de que todas as palavras estejam escritas corretamente.</p>
                <p><ico class="sprite-key"></ico> Tente palavras-chave diferentes.</p>
                <p><ico class="sprite-pencil"></ico> Tente palavras-chave mais gen&eacute;ricas.</p>
            </div>
        </div>
        <div class='col2 naoencontrado'>
            <?php if ( isset($theme_opts[marisa_call_sign_fd]) && strlen($theme_opts[marisa_call_sign_fd]) > 0 ) { ?>
                <img src='<?php echo $theme_opts[marisa_call_sign_fd]; ?>' title=''/>
            <?php } ?>
        </div>
    <?php endif; 
    wp_reset_query();
}
add_shortcode('busca', busca_entries);