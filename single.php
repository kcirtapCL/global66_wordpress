<?php get_header() ?>
<?php the_post() ?>
<?php
$categories = get_the_terms( get_the_ID(), "category" );
$related    = related_posts();
$network    = social_network();
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <div class="header">
        <div class="container mx-auto">
            <div class="pt-24 pb-10 space-y-3">
                <div class="flex flex-row justify-between items-center">
                    <div class="flex flex-row items-center space-x-4">
						<?php foreach ( $categories as $category ) { ?>
                            <span class="font-bold text-<?php echo $category->description ?>"><?php echo $category->name ?></span>
						<?php } ?>
                    </div>
                    <div class="flex flex-row items-center space-x-4">
                        <p class="read-time font-medium text-neutral-4"><?php echo reading_time() ?></p>
                        <span class="w-8 h-8 block bg-no-repeat bg-center bg-contain"
                              style="background-image: url('<?php echo get_template_directory_uri() ?>/images/svg/read-time.svg')"></span>
                    </div>
                </div>
                <div class="space-y-6">
                    <div class="space-y-3">
                        <h1 class="font-bold text-4xl text-neutral-1"><?php the_title() ?></h1>
                        <p class="font-medium text-neutral-1 leading-5"><?php echo get_the_excerpt() ?></p>
                    </div>
                    <div>
                        <p class="text-neutral-4">por <?php the_author(); ?>, <?php the_time( "d F Y" ); ?></p>
                    </div>
                </div>
            </div>
        </div>
        <div>
                <span class="w-full pb-96 block max-h-96 bg-no-repeat bg-center bg-cover text-indent"
                      style="background-image: url(<?php echo thumbnail_post( get_the_ID() ) ?>)"><?php the_title() ?></span>
        </div>
    </div>
    <div class="content pt-24">
        <div class="container mx-auto">
            <div>
				<?php the_content() ?>
            </div>
            <div class="border-t border-neutral-2 mt-6 pt-6">
                <p class="font-light italic text-sm">Esta publicación fue creada para entregar información general
                    sobre el tema descrito en la fecha
                    de su publicación, la cual puede tener caducidad en ciertos elementos como precios, promociones,
                    costos u otros elementos de servicio. La información de esta publicación no constituye una
                    recomendación profesional de tipo legal, impositivo, financiero u otros por parte de Global66.
                    En virtud de la transparencia, te sugerimos siempre comparar y comprobar por ti mismo cuál es la
                    mejor alternativa para tus servicios de remesas y transferencias internacionales.</p>
            </div>
        </div>
    </div>
</article>
<div class="related py-16">
    <div class="container mx-auto">
        <div class="space-y-20">
            <div class="text-center">
                <h2 class="font-bold text-4xl text-neutral-2">Contenido relacionado</h2>
            </div>
            <div class="grid grid-cols-1 lg:grid-cols-3 grid-flow-row auto-rows-max gap-y-4 lg:gap-y-0 lg:gap-x-24">
				<?php
				if ( $related->have_posts() ):
					while ( $related->have_posts() ): $related->the_post();
						?>
                        <div class="overflow-related bg-no-repeat bg-center bg-cover relative"
                             style="background-image: url(<?php echo thumbnail_post( get_the_ID() ) ?>)">
                            <div class="flex flex-col justify-between w-full h-100 p-6 relative z-10">
                                <div class="flex flex-row flex-wrap justify-end items-center space-x-1">
									<?php $category_related = get_the_terms( get_the_ID(), "category" ); ?>
									<?php foreach ( $category_related as $key => $category ) { ?>
										<?php if ( $key > 1 ) {
											break;
										} ?>
                                        <span class="font-bold py-1 px-2 rounded text-neutral-12 bg-<?php echo $category->description ?>"><?php echo $category->name ?></span>
									<?php } ?>
                                </div>
                                <div>
                                    <a href="<?php the_permalink() ?>">
                                        <div class="space-y-3.5">
                                            <span class="icon-global text-indent">Global66</span>
                                            <p class="font-alternates font-bold text-xl text-neutral-12 leading-tight"><?php the_title() ?></p>
                                            <p class="font-alternates font-medium text-neutral-12 leading-normal"><?php echo get_the_excerpt() ?></p>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>
					<?php
					endwhile;
					wp_reset_postdata();
				endif; ?>
            </div>
        </div>
    </div>
</div>
<div class="others py-16">
    <div class="container mx-auto">
        <div class="space-y-16">
            <div class="text-center">
                <h2 class="font-bold text-4xl text-neutral-2">Síguenos para más información</h2>
            </div>
            <div>
                <ul class="flex flex-row justify-around items-center">
					<?php
					if ( $network->have_posts() ):
						while ( $network->have_posts() ): $network->the_post();
							?>
                            <li>
                                <a href="<?php echo get_field( "website" ) ?>" alt="<?php the_title() ?>"
                                   target="_blank">
                                    <span class="w-12 h-12 block bg-no-repeat bg-center bg-contain text-indent"
                                          style="background-image: url(<?php echo get_field( "image" )["url"] ?>)"><?php the_title() ?></span>
                                </a>
                            </li>
						<?php
						endwhile;
						wp_reset_postdata();
					endif;
					?>
                </ul>
            </div>
        </div>
    </div>
</div>

<?php get_footer() ?>
