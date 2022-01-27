<?php
$network = social_network();
?>
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
                                <a href="<?php echo get_field( "website" ) ?>" title="<?php the_title() ?>"
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
