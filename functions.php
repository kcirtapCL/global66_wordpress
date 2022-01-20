<?php
define( 'SINGLE_PATH', get_stylesheet_directory() . '/single' );

add_theme_support( 'post-thumbnails' );
add_theme_support( 'post-formats', array( 'link', 'gallery', 'image', 'quote', 'video' ) );
add_theme_support( 'nav-menus' );
add_theme_support( 'title-tag' );
add_theme_support( 'wp-block-styles' );
add_theme_support( 'responsive-embeds' );
add_theme_support( 'custom-logo', array(
	'height'               => 100,
	'width'                => 100,
	'flex-width'           => true,
	'flex-height'          => true,
	'unlink-homepage-logo' => true
) );

remove_action( 'wp_head', 'wp_robots', 1 );
register_nav_menus(
	array(
		'menu-01' => esc_html__( 'Menu 01' ),
		'menu-02' => esc_html__( 'Menu 02' ),
		'menu-03' => esc_html__( 'Menu 03' )
	)
);

add_action( 'wp_enqueue_scripts', 'no_more_jquery' );
function no_more_jquery() {
	wp_deregister_script( 'jquery' );
}

add_action( 'wp_enqueue_scripts', 'one_scripts' );
function one_scripts() {
	wp_enqueue_style( 'global66', get_template_directory_uri() . '/style.css', array(), wp_get_theme()->get( 'Version' ) );
	wp_enqueue_style( 'fontAwesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css', array(), '' );

	wp_enqueue_script( 'jquery', 'https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js', array(), '', true );
	wp_enqueue_script( 'global66', get_template_directory_uri() . '/js/main.js', array(), wp_get_theme()->get( 'Version' ), true );
}

add_action( 'template_redirect', 'remove_wp_archives' );
function remove_wp_archives() {
	if ( is_category() || is_tag() || is_date() || is_author() ) {
		global $wp_query;
		$wp_query->set_404();
	}
}

add_action( 'init', 'widgets_init' );
function widgets_init() {
	if ( ! function_exists( 'register_sidebars' ) ) {
		return;
	}

	register_sidebars( array(
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
}

add_filter( 'upload_mimes', 'bp_mime_type', 1, 1 );
function bp_mime_type( $mime_types ) {
	$mime_types['svg'] = 'image/svg+xml';

	return $mime_types;
}

add_filter( 'nav_menu_css_class', 'special_nav_class', 10, 2 );
function special_nav_class( $classes, $item ) {
	if ( in_array( 'current-menu-item', $classes ) ) {
		$classes[] = 'active';
	}
	if ( in_array( 'current-menu-ancestor', $classes ) ) {
		$classes[] = 'active';
	}
	if ( in_array( 'menu-item-type-custom', $classes ) ) {
		$classes[] = clean_string( strtolower( $item->title ) );
	}

	return $classes;
}

// https://developer.wordpress.org/reference/hooks/wp_mail_content_type/
function wpdocs_set_html_mail_content_type(): string {
	return 'text/html';
}

function thumbnail_post( $post_id ) {
	if ( has_post_thumbnail( $post_id ) ) {
		return get_the_post_thumbnail_url( $post_id );
	}

	return get_template_directory_uri() . '/images/default-thumbnail.png';
}

function reading_time(): string {
	global $post;

	$content    = get_post_field( 'post_content', $post->ID );
	$word_count = str_word_count( strip_tags( $content ) );
	$reading    = ceil( $word_count / 200 );
	$timer      = $reading == 1 ? ' minuto' : ' minutos';

	return $reading . $timer;
}

function related_posts(): WP_Query {
	global $post;

	$tags     = wp_get_post_tags( $post->ID );
	$tags_IDs = array();
	foreach ( $tags as $tag ) {
		$tags_IDs[] = $tag->term_id;
	}

	return new WP_Query( array(
		'tag__in'        => $tags_IDs,
		'post__not_in'   => array( $post->ID ),
		'posts_per_page' => 3
	) );
}

function social_network(): WP_Query {
	return new WP_Query( array(
		'post_type'   => 'redes_sociales',
		'post_status' => 'publish',
		'meta_key'    => 'order',
		'orderby'     => 'meta_value',
		'order'       => 'ASC'
	) );
}

/************ POST TEMPLATE ************/
add_filter( 'single_template', 'single_template' );
function single_template( $single ) {
	global $post;

	if ( file_exists( SINGLE_PATH . '/single-' . $post->ID . '.php' ) ) {
		return SINGLE_PATH . '/single-' . $post->ID . '.php';
	}

	foreach ( get_the_category() as $cat ) {
		if ( file_exists( SINGLE_PATH . '/single-cat-' . $cat->slug . '.php' ) ) {
			return SINGLE_PATH . '/single-cat-' . $cat->slug . '.php';
		} elseif ( file_exists( SINGLE_PATH . '/single-cat-' . $cat->term_id . '.php' ) ) {
			return SINGLE_PATH . '/single-cat-' . $cat->term_id . '.php';
		}
	}

	if ( file_exists( SINGLE_PATH . '/single.php' ) ) {
		return SINGLE_PATH . '/single.php';
	}

	return $single;
}


/************ CUSTOM ADMIN ************/
add_action( 'admin_enqueue_scripts', 'admin_style' );
function admin_style() {
	echo '<style>';
	echo '.color-picker_box { display: inline-block; vertical-align: middle; }';
	echo '.color-picker_box span { display: inline-block; vertical-align: middle; margin-right: 4px; }';
	echo '.color-picker_box span:nth-child(1) { width: 26px; height: 26px; margin-bottom: 4px; }';
	echo '.color-picker_box span:nth-child(2) { font-size: 14px; font-weight: 600; }';
	echo '</style>';
}

/************ CUSTOM BLOCKS ************/
add_action( 'acf/init', 'acf_init_block_image_background' );
function acf_init_block_image_background() {
	if ( function_exists( 'acf_register_block_type' ) ) {
		acf_register_block_type( array(
			'name'            => 'g66_image-background',
			'title'           => __( 'G66 Image & Background' ),
			'description'     => __( 'Image & Background' ),
			'category'        => 'theme',
			'icon'            => 'align-left',
			'keywords'        => array( 'image' ),
			'mode'            => 'edit',
			'render_template' => 'template-parts/blocks/image-background/index.php'
		) );
	}
}

add_action( 'acf/init', 'acf_init_block_number_text' );
function acf_init_block_number_text() {
	if ( function_exists( 'acf_register_block_type' ) ) {
		acf_register_block_type( array(
			'name'            => 'g66_number-text',
			'title'           => __( 'G66 Number Text' ),
			'description'     => __( 'Number & Text' ),
			'category'        => 'theme',
			'icon'            => 'editor-ol',
			'keywords'        => array( 'number', 'text' ),
			'mode'            => 'edit',
			'render_template' => 'template-parts/blocks/number-text/index.php'
		) );
	}
}

/************ QUERY'S ************/

/************ RESET STRING ************/
function clean_string( $string ): string {
	$string = trim( $string );
	$string = str_replace(
		array( 'á', 'à', 'ä', 'â', 'ª', 'Á', 'À', 'Â', 'Ä' ),
		array( 'a', 'a', 'a', 'a', 'a', 'A', 'A', 'A', 'A' ),
		$string
	);
	$string = str_replace(
		array( 'é', 'è', 'ë', 'ê', 'É', 'È', 'Ê', 'Ë' ),
		array( 'e', 'e', 'e', 'e', 'E', 'E', 'E', 'E' ),
		$string
	);
	$string = str_replace(
		array( 'í', 'ì', 'ï', 'î', 'Í', 'Ì', 'Ï', 'Î' ),
		array( 'i', 'i', 'i', 'i', 'I', 'I', 'I', 'I' ),
		$string
	);
	$string = str_replace(
		array( 'ó', 'ò', 'ö', 'ô', 'Ó', 'Ò', 'Ö', 'Ô' ),
		array( 'o', 'o', 'o', 'o', 'O', 'O', 'O', 'O' ),
		$string
	);
	$string = str_replace(
		array( 'ú', 'ù', 'ü', 'û', 'Ú', 'Ù', 'Û', 'Ü' ),
		array( 'u', 'u', 'u', 'u', 'U', 'U', 'U', 'U' ),
		$string
	);
	$string = str_replace(
		array( 'ñ', 'Ñ', 'ç', 'Ç' ),
		array( 'n', 'N', 'c', 'C', ),
		$string
	);

	$string = str_replace(
		array( ' ' ),
		'-',
		$string
	);

	return strtolower( $string );
}