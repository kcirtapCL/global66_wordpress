<?php $related = related_posts(); ?>
<?php if ( $related->have_posts() ): ?>
	<div class="related py-16">
		<div class="container mx-auto">
			<div class="space-y-20">
				<div class="text-center">
					<h2 class="font-bold text-4xl text-neutral-2">Contenido relacionado</h2>
				</div>
				<div class="grid grid-cols-1 lg:grid-cols-3 grid-flow-row auto-rows-max gap-y-4 lg:gap-y-0 lg:gap-x-24">
					<?php while ( $related->have_posts() ): $related->the_post(); ?>
						<div class="overflow-related bg-no-repeat bg-center bg-cover relative"
						     style="background-image: url(<?php echo thumbnail_post( get_the_ID() ) ?>)">
							<div class="flex flex-col justify-between w-full h-100 p-6 relative z-10">
								<div class="flex flex-row flex-wrap justify-end items-center space-x-1">
									<?php $category_related = get_the_terms( get_the_ID(), "category" ); ?>
									<?php foreach ( $category_related as $key => $category ) { ?>
										<?php if ( $key > 1 ) { break; } ?>
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
					<?php endwhile;
					wp_reset_postdata(); ?>
				</div>
			</div>
		</div>
	</div>
<?php endif; ?>