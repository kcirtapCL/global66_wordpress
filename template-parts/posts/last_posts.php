<?php
$category = !empty( get_query_var( 'category' ) ) ? get_query_var( 'category' ) : get_term_by( 'name', $post->post_title, 'category' )->term_id;
$query    = new WP_Query(
	array(
		'tax_query'      => array(
			array(
				'taxonomy'         => 'category',
				'field'            => 'term_id',
				'terms'            => $category,
				'include_children' => true
			)
		),
		'post_type'      => 'post',
		'post_status'    => 'publish',
		'posts_per_page' => 1,
		'order'          => 'DESC',
		'orderby'        => 'date'
	)
);
?>
<section class="py-10">
    <div class="container">
        <div class="flex flex-col space-y-9">
            <div>
                <h2 class="text-4xl text-neutral-1 font-bold"><?php echo get_configurations("last_post") ?></h2>
            </div>
            <div>
				<?php if ( $query->have_posts() ): $query->the_post() ?>
                    <div class="min-h-full h-100 relative bg-no-repeat bg-center bg-cover rounded-t-2xl"
                         style="background-image: url(<?php echo thumbnail_post( get_the_ID() ) ?>)">
                        <div class="top-1/2 right-20 mx-auto p-7 bg-neutral-1 max-w-lg w-full space-y-6 absolute transform -translate-y-1/2">
                            <div class="flex flex-row justify-end space-x-2">
								<?php foreach ( child_categories( get_the_ID() ) as $child_cat ): ?>
                                    <span class="px-3 py-1 font-alternate font-bold text-sm text-neutral-12 rounded-lg bg-<?php echo $child_cat->description ?>"><?php echo $child_cat->name ?></span>
								<?php endforeach; ?>
                            </div>
                            <div class="space-y-2">
                                <div>
                                    <svg width="34" height="13" viewBox="0 0 34 13" fill="none"
                                         xmlns="http://www.w3.org/2000/svg">
                                        <path d="M33.9849 5.94098C33.7016 2.61315 30.9303 0 27.5488 0C25.3701 0 23.444 1.08735 22.2762 2.74907C21.5877 3.7312 21.1563 4.90624 21.0953 6.19089C21.091 6.29174 21.0866 6.39696 21.0866 6.49781C21.0866 8.77336 19.2565 10.6148 16.9993 10.6148C16.9949 10.6148 16.9949 10.6148 16.9949 10.6148H16.9905C14.7377 10.6148 12.9032 8.77336 12.9032 6.49781C12.9032 6.39696 12.8988 6.29174 12.8945 6.19089C12.8378 4.90624 12.4064 3.7312 11.7136 2.74907C10.5588 1.08735 8.63282 0 6.45406 0C3.07263 0 0.301245 2.61315 0.0180063 5.94098C0.0180063 5.94098 -0.00378132 6.20843 0.000576201 6.2742C0.0441514 6.89241 0.549624 7.38786 1.17711 7.38786C1.83509 7.38786 2.34056 6.84418 2.36235 6.19528C2.44079 5.12985 2.92447 4.17841 3.65654 3.49444C4.39296 2.81046 5.3734 2.38954 6.44971 2.38954C8.60232 2.38954 10.3671 4.0688 10.524 6.19528L10.5414 6.5285C10.5458 7.91838 10.9815 9.19865 11.7223 10.2509C12.8901 11.9126 14.8205 13 16.9949 13C16.9993 13 16.9993 13 16.9993 13H17.0036C19.178 13 21.1084 11.9126 22.2762 10.2509C23.017 9.19865 23.4527 7.91838 23.4571 6.5285L23.4745 6.19528C23.6314 4.06442 25.3962 2.38954 27.5488 2.38954C28.6251 2.38954 29.6099 2.81046 30.342 3.49444C31.074 4.17841 31.5577 5.12985 31.6362 6.19528C31.6623 6.84418 32.1678 7.38786 32.8214 7.38786C33.4489 7.38786 33.9544 6.8968 33.9979 6.2742C34.0067 6.20843 33.9849 5.94098 33.9849 5.94098Z"
                                              fill="white"/>
                                    </svg>
                                </div>
                                <div class="space-y-4">
                                    <a href="<?php the_permalink() ?>" class="space-y-2">
                                        <p class="text-neutral-12 font-bold text-lg leading-tight"><?php the_title() ?></p>
                                        <p class="text-neutral-12 font-medium text-sm"><?php echo get_the_excerpt() ?></p>
                                    </a>
                                    <p class="text-neutral-4 italic text-sm">por <?php the_author() ?>, <?php the_time( "d F Y" ); ?></p>
                                </div>
                            </div>
                        </div>
                    </div>
					<?php wp_reset_postdata(); endif; ?>
            </div>
        </div>
    </div>
</section>
<!--
<section class="py-12">
    <div class="py-12 min-h-full h-100 relative bg-no-repeat bg-center bg-cover"
         style="background-image: url('#')">
        <div class="container">
            <div class="flex flex-row justify-end space-x-2">
                <a href="#"
                   class="px-3 py-1 font-alternate font-bold text-sm text-neutral-12 bg-accent-2 rounded-lg">Noticias</a>
            </div>
            <div class="space-y-9">
                <div>
                    <svg width="70" height="27" viewBox="0 0 34 13" fill="none"
                         xmlns="http://www.w3.org/2000/svg">
                        <path d="M33.9849 5.94098C33.7016 2.61315 30.9303 0 27.5488 0C25.3701 0 23.444 1.08735 22.2762 2.74907C21.5877 3.7312 21.1563 4.90624 21.0953 6.19089C21.091 6.29174 21.0866 6.39696 21.0866 6.49781C21.0866 8.77336 19.2565 10.6148 16.9993 10.6148C16.9949 10.6148 16.9949 10.6148 16.9949 10.6148H16.9905C14.7377 10.6148 12.9032 8.77336 12.9032 6.49781C12.9032 6.39696 12.8988 6.29174 12.8945 6.19089C12.8378 4.90624 12.4064 3.7312 11.7136 2.74907C10.5588 1.08735 8.63282 0 6.45406 0C3.07263 0 0.301245 2.61315 0.0180063 5.94098C0.0180063 5.94098 -0.00378132 6.20843 0.000576201 6.2742C0.0441514 6.89241 0.549624 7.38786 1.17711 7.38786C1.83509 7.38786 2.34056 6.84418 2.36235 6.19528C2.44079 5.12985 2.92447 4.17841 3.65654 3.49444C4.39296 2.81046 5.3734 2.38954 6.44971 2.38954C8.60232 2.38954 10.3671 4.0688 10.524 6.19528L10.5414 6.5285C10.5458 7.91838 10.9815 9.19865 11.7223 10.2509C12.8901 11.9126 14.8205 13 16.9949 13C16.9993 13 16.9993 13 16.9993 13H17.0036C19.178 13 21.1084 11.9126 22.2762 10.2509C23.017 9.19865 23.4527 7.91838 23.4571 6.5285L23.4745 6.19528C23.6314 4.06442 25.3962 2.38954 27.5488 2.38954C28.6251 2.38954 29.6099 2.81046 30.342 3.49444C31.074 4.17841 31.5577 5.12985 31.6362 6.19528C31.6623 6.84418 32.1678 7.38786 32.8214 7.38786C33.4489 7.38786 33.9544 6.8968 33.9979 6.2742C34.0067 6.20843 33.9849 5.94098 33.9849 5.94098Z"
                              fill="white"/>
                    </svg>
                </div>
                <div class="space-y-9">
                    <p class="text-neutral-12 font-alternate font-bold text-5xl leading-tight">TITULO</p>
                    <p class="text-neutral-12 font-medium text-lg">DESCRIPCIÓN</p>
                </div>
            </div>
        </div>
    </div>
</section>
-->