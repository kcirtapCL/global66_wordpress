<?php
$active_menu = is_singular() ? get_the_ID() : 0;
$pages_menu = new WP_Query(
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
                   class="<?php echo $active_menu === get_the_ID() ? 'menu-active' : '' ?>"><?php the_title() ?></a>
			<?php
			endwhile;
			wp_reset_postdata();
		endif;
		?>
    </div>
</div>
