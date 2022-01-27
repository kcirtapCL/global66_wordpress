<?php
$actual_parent = 0;
$main_category = get_categories(
	array(
		'parent'     => 0,
		'hide_empty' => false,
		'exclude'    => array( 1 )
	)
);

foreach ( $main_category as $mainCat ):
	if ( get_post()->post_title === $mainCat->name ) {
		$actual_parent = $mainCat->term_id;
		break;
	}
endforeach;

$child_categories = get_categories(
	array(
		'parent' => $actual_parent
	)
);
?>
<ul class="category-filter flex flex-row items-center justify-center space-x-12">
    <li class="active">
        <a href="javascript:void(0)" data-category="#/category/<?php echo $actual_parent ?>/home" class="text-neutral-1">Inicio</a>
    </li>
	<?php
	foreach ( $child_categories as $childCat ):
		echo '<li>';
		echo '<a href="javascript:void(0);" data-category="#/category/' . $childCat->term_id . '/' . $childCat->category_nicename . '" class="text-neutral-1">' . $childCat->name . '</a>';
		echo '</li>';
	endforeach;
	?>
</ul>

