<!DOCTYPE html>
<html <?php language_attributes() ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="robots" content="index,follow"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<?php wp_head() ?>
</head>
<body <?php body_class() ?> data-base="<?php echo get_bloginfo( 'url' ) ?>">
<?php wp_body_open() ?>
<header class="top-12 inset-x-0 mx-auto absolute z-50">
    <div class="container mx-auto">
        <div class="flex flex-row items-center justify-between">
            <div class="flex flex-row items-center space-x-10">
                <div>
                    <a href="<?php echo esc_url( home_url( '/' ) ) ?>"
                       title="<?php echo get_bloginfo( 'name' ) ?>"><?php the_custom_logo() ?></a>
                </div>
				<?php wp_nav_menu( array( 'theme_location' => 'menu-01', 'menu_class' => 'main-menu' ) ); ?>
            </div>
            <div class="flex flex-row items-center space-x-5">
				<?php wp_nav_menu( array( 'theme_location' => 'menu-02', 'menu_class' => 'main-account' ) ); ?>
                <ul>
                    <li>
						<?php $translations = pll_the_languages( array( 'raw' => 1 ) ) ?>
                        <div class="dropdown relative cursor-pointer">
							<?php foreach ( $translations as $translate ): ?>
								<?php if ( $translate['current_lang'] ): ?>
                                    <img src="<?php echo get_template_directory_uri() ?>/images/svg/gc_country_flag_<?php echo $translate['slug'] ?>.svg"
                                         alt="<?php echo $translate['name'] ?>" class="object-cover"/>
								<?php endif; ?>
							<?php endforeach; ?>
                            <ul class="w-0 h-auto top-12 right-0 absolute z-50 bg-neutral-12 rounded-lg overflow-hidden transition-all duration-200 ease-in-out">
								<?php foreach ( $translations as $translate ): ?>
                                    <li>
                                        <a href="<?php echo $translate['url'] ?>"
                                           class="flex px-4 py-2 items-center space-x-2 hover:bg-neutral-10">
                                            <img src="<?php echo get_template_directory_uri() ?>/images/svg/gc_country_flag_<?php echo $translate['slug'] ?>.svg"
                                                 alt="<?php echo $translate['name'] ?>" class="object-cover"/>
                                            <span class="font-semibold text-neutral-1"><?php echo $translate['name'] ?></span>
                                        </a>
                                    </li>
								<?php endforeach; ?>
                            </ul>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</header>
