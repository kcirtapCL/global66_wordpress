<?php
$active = active_selector();
$pages_menu  = new WP_Query(
	array(
		'page_name'   => 'personas,empresas',
		'post_type'   => 'page',
		'post_status' => 'publish',
		'order'       => 'DESC',
		'orderby'     => 'name'
	)
);
?>
<div class="selector-page">
    <div class="flex flex-row items-center justify-center">
		<?php
		if ( $pages_menu->have_posts() ):
			while ( $pages_menu->have_posts() ): $pages_menu->the_post(); ?>
                <a href="<?php the_permalink() ?>" target="_self"
                   class="<?php echo $active === get_the_ID() ? 'text-neutral-12 border-neutral-12' : 'text-neutral-5 hover:text-neutral-12 border-neutral-5' ?> flex-1 border-b-2 border-solid text-center relative transition-all duration-200 ease-in-out"><?php the_title() ?></a>
			<?php
			endwhile;
			wp_reset_postdata();
		endif;
		?>
    </div>
</div>
