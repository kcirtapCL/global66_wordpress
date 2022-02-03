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
register_nav_menus(
	array(
		'menu-01' => esc_html__( 'Menu 01' ),
		'menu-02' => esc_html__( 'Menu 02' ),
		'menu-03' => esc_html__( 'Menu 03' )
	)
);
add_action( 'init', 'widgets_init' );
add_action( 'wp_enqueue_scripts', 'no_more_jquery' );
add_action( 'wp_enqueue_scripts', 'one_scripts' );
add_action( 'template_redirect', 'remove_wp_archives' );
add_action( 'admin_enqueue_scripts', 'admin_style' );
add_action( 'acf/init', 'acf_init_block_image_background' );
add_action( 'acf/init', 'acf_init_block_number_text' );
remove_action( 'wp_head', 'wp_robots', 1 );

add_filter( 'upload_mimes', 'bp_mime_type', 1, 1 );
add_filter( 'nav_menu_css_class', 'special_nav_class', 10, 2 );
add_filter( 'excerpt_length', 'custom_excerpt' );
add_filter( 'single_template', 'single_template' );

/**
 * @return void
 */
function no_more_jquery() {
	wp_deregister_script( 'jquery' );
}

/**
 * @return void
 */
function one_scripts() {
	wp_enqueue_style( 'fontAwesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css', array(), '' );
	wp_enqueue_style( 'global66', get_template_directory_uri() . '/style.css', array(), wp_get_theme()->get( 'Version' ) );

	wp_enqueue_script( 'jquery', 'https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js', array(), '' );
	wp_enqueue_script( 'global66', get_template_directory_uri() . '/js/main.js', array(), wp_get_theme()->get( 'Version' ), true );
}

/**
 * @return void
 */
function remove_wp_archives() {
	if ( is_tag() || is_date() || is_author() ) {
		global $wp_query;
		$wp_query->set_404();
	}
}

/**
 * @return void
 */
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

/**
 * @param $mime_types
 *
 * @return mixed
 */
function bp_mime_type( $mime_types ) {
	$mime_types['svg'] = 'image/svg+xml';

	return $mime_types;
}

/**
 * @param $classes
 * @param $item
 *
 * @return mixed
 */
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

/**
 * @return int
 */
function custom_excerpt(): int {
	return 24;
}

/**
 * https://developer.wordpress.org/reference/hooks/wp_mail_content_type/
 *
 * @return string
 */
function set_html_mail_content_type(): string {
	return 'text/html';
}

/**
 * @param $post_id
 *
 * @return false|string
 */
function thumbnail_post( $post_id ) {
	if ( has_post_thumbnail( $post_id ) ) {
		return get_the_post_thumbnail_url( $post_id );
	}

	return get_template_directory_uri() . '/images/default-thumbnail.png';
}

/**
 * @param $post_id
 * @param int $limit
 *
 * @return array
 */
function child_categories( $post_id, int $limit = 0 ): array {
	$child_category    = [];
	$parent_categories = wp_get_post_categories( $post_id );

	foreach ( $parent_categories as $category ):
		$decode           = get_category( $category );
		$child_category[] = (object) array(
			'id'          => $decode->term_id,
			'name'        => $decode->name,
			'description' => $decode->description
		);
	endforeach;

	return $limit !== 0 ? array_slice( $child_category, 0, $limit ) : $child_category;
}

/**
 * @return string
 */
function reading_time(): string {
	global $post;

	$content    = get_post_field( 'post_content', $post->ID );
	$word_count = str_word_count( strip_tags( $content ) );
	$reading    = ceil( $word_count / 200 );
	$timer      = $reading == 1 ? ' minuto' : ' minutos';

	return $reading . $timer;
}

/**
 * @return mixed|null
 */
function related_posts() {
	global $post;

	return get_field( 'selected_posts', $post->ID );
}

/**
 * @return WP_Query
 */
function social_network(): WP_Query {
	return new WP_Query( array(
		'post_type'   => 'redes_sociales',
		'post_status' => 'publish',
		'meta_key'    => 'order',
		'order'       => 'ASC',
		'orderby'     => 'meta_value'
	) );
}

/**
 * @return false|int|void
 */
function active_selector() {
	if ( is_singular() ) {
		return is_singular() ? get_the_ID() : 0;
	}
	$parents       = get_categories(
		array(
			'parent'     => 0,
			'hide_empty' => false,
			'exclude'    => array( 1 )
		)
	);
	$actual_parent = get_category( get_the_category()[0]->parent )->name;

	foreach ( $parents as $parent ) {
		if ( $parent->name === $actual_parent ) {
			return get_page_by_title( $actual_parent )->ID;
		}
	}
}

/**
 * @param bool $actual
 *
 * @return array|int|mixed|object|WP_Error|null
 */
function get_general_category( bool $actual = false ) {
	$actual_category = get_category( get_query_var( "cat" ) );
	$parents         = get_categories(
		array(
			'parent'     => 0,
			'hide_empty' => false,
			'exclude'    => array( 1 )
		)
	);

	if ( is_singular() ) {
		$current_page_title = get_the_title();

		foreach ( $parents as $parent ) {
			if ( $parent->name === $current_page_title ) {
				$actual_category = $parent;
			}
		}

		$children = get_categories(
			array(
				'parent'     => $actual_category->term_id,
				'hide_empty' => true
			)
		);
	} else {
		$children = get_categories(
			array(
				'parent'     => $actual_category->parent,
				'hide_empty' => true
			)
		);
	}

	return $actual ? $actual_category : $children;
}

/**
 * @param $category_id
 * @param bool $color
 *
 * @return mixed|string
 */
function decode_category( $category_id, bool $color = true ) {
	$category = get_category( $category_id )->description;
	$decode   = explode( " // ", $category );

	if ( $color ) {
		return $decode[0];
	}

	return $decode[1];
}

/**
 * @param $field
 *
 * @return mixed
 */
function get_configurations( $field = null ) {
	$current_language   = pll_current_language();
	$page_configuration = get_page_by_title( "Configuración" )->ID;

	return get_field( $current_language, $page_configuration )[ $field ];
}

/**
 * @param $data
 *
 * @return void
 */
function console_log( $data ) {
	echo "<pre>";
	var_dump( $data );
	echo "</pre>";
}

/************ POST TEMPLATE ************/
/**
 * @param $single
 *
 * @return mixed|string
 */
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
/**
 * @return void
 */
function admin_style() {
	echo '<style>';
	echo '.color-picker_box { display: inline-block; vertical-align: middle; }';
	echo '.color-picker_box span { display: inline-block; vertical-align: middle; margin-right: 4px; }';
	echo '.color-picker_box span:nth-child(1) { width: 26px; height: 26px; margin-bottom: 4px; }';
	echo '.color-picker_box span:nth-child(2) { font-size: 14px; font-weight: 600; }';
	echo '</style>';
}

/************ CUSTOM BLOCKS ************/
/**
 * @return void
 */
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

/**
 * @return void
 */
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
/**
 * @param $string
 *
 * @return string
 */
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
