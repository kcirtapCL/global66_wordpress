<?php
$actual_parent = null;
$main_category = get_categories(
	array(
		'parent'     => 0,
		'hide_empty' => false,
		'exclude'    => array( 1 )
	)
);

foreach ( $main_category as $mainCat ):
	$actual_parent = get_post()->post_title === $mainCat->name ? $mainCat->term_id : 0;
endforeach;

$child_categories = get_categories(
	array(
		'parent' => $actual_parent
	)
);
?>
<ul class="category-filter flex flex-row items-center justify-center space-x-12">
	<?php
	foreach ( $child_categories as $childCat ):
		echo '<li>';
		echo '<a href="javascript:void(0);" data-category="#/category/' . $childCat->term_id . '/' . $childCat->category_nicename . '" target="_self" class="text-neutral-1">' . $childCat->name . ' - ' . $childCat->term_id . '</a>';
		echo '</li>';
	endforeach;
	?>
</ul>

