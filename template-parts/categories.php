<?php
$main_category = get_categories(
	array(
		'parent'     => 0,
		'hide_empty' => false,
		'exclude'    => array( 1 )
	)
);
