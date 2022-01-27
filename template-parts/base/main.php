<section class="header personal">
    <div class="flex w-full min-h-screen pt-52 bg-no-repeat bg-center bg-cover"
         style="background-image: url(<?php echo get_field( 'background' )['url'] ?>)">
        <div class="container mx-auto">
            <div class="flex flex-col items-center space-y-14">
                <div class="w-full max-w-xl">
					<?php get_template_part( 'template-parts/selector-page' ) ?>
                </div>
                <div class="flex flex-col items-center space-y-6 max-w-xl">
                    <h1 class="font-bold text-7xl text-neutral-12"><?php echo get_field( 'title' ) ?></h1>
                    <p class="text-neutral-12 text-center"><?php echo get_field( 'description' ) ?></p>
                </div>
                <div>
					<?php get_template_part( 'template-parts/search' ) ?>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="py-12">
    <div class="container mx-auto">
        <div>
			<?php get_template_part( 'template-parts/tags_categories' ); ?>
        </div>
    </div>
</section>
<div id="app-custom">
	<?php get_template_part( 'template-parts/categories' ); ?>
</div>
<?php get_template_part( 'template-parts/social_network' ); ?>
