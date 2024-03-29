<?php
get_header();
the_post();
$categories = get_the_terms( get_the_ID(), "category" );
?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <div class="header">
        <div class="container">
            <div class="pt-48 pb-10 space-y-3">
                <div class="flex flex-row justify-between items-center">
                    <div class="flex flex-row items-center space-x-4">
						<?php foreach ( $categories as $category ) { ?>
                            <span class="font-bold text-<?php echo $category->description ?>"><?php echo $category->name ?></span>
						<?php } ?>
                    </div>
                    <div class="flex flex-row items-center space-x-4">
                        <p class="read-time font-medium text-neutral-4"><?php echo reading_time() ?></p>
                        <span class="w-8 h-8 block bg-no-repeat bg-center bg-contain"
                              style="background-image: url('<?php echo get_template_directory_uri() ?>/images/svg/icon-read_time.svg')"></span>
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
    <div class="content py-24">
        <div class="container">
            <div>
				<?php the_content() ?>
            </div>
            <div class="border-t border-neutral-2 mt-6 pt-6">
                <p class="font-light italic text-sm"><?php echo get_configurations( "disclaimer" ) ?></p>
            </div>
        </div>
    </div>
</article>
<?php get_template_part( 'template-parts/related_posts' ); ?>
<?php get_footer() ?>
