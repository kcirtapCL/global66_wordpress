<?php
$parents = get_categories(
	array(
		'parent'     => 0,
		'hide_empty' => false,
		'exclude'    => array( 1 )
	)
);

$actual   = get_category( get_query_var( "cat" ) );
$children = get_categories(
	array(
		'parent'     => $actual->parent,
		'hide_empty' => false
	)
);

if ( is_singular() ) {
	$current_page_id    = get_the_ID();
	$current_page_title = get_the_title();

	foreach ( $parents as $parent ) {
		if ( $parent->name === $current_page_title ) {
			$actual = $parent;
			break;
		}
	}
	$children = get_categories(
		array(
			'parent'     => $actual->term_id,
			'hide_empty' => false
		)
	);
}
?>
<ul class="category-filter flex flex-row items-center justify-center space-x-12">
	<?php foreach ( $children as $child ): if ( $actual->term_id === $child->term_id ): ?>
        <li class="active">
            <span class="text-neutral-1"><?php echo $child->name ?></span>
        </li>
	<?php else: ?>
        <li>
            <a href="<?php echo get_category_link( $child->term_id ) ?>" target="_self"
               class="text-neutral-1"><?php echo $child->name ?></a>
        </li>
	<?php endif; endforeach; ?>
</ul>

