<?php define("page", "e404"); $theme_opts = get_option('marisa_options'); ?>
<?php get_header(); ?>

<section id="page">
	<div class="container">
		<div id="artigos">
                <div class="pagecontent">
                    <h1><a href="<?php the_permalink() ?>">404 - P&aacute;gina não encontrada</a></h1>
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
                </div>
			
		</div>
	</div>
</section>
<?php get_footer(); ?>