<ul class="category-filter flex flex-row items-center justify-center space-x-12">
	<?php foreach ( get_general_category() as $child ): if ( get_general_category(true)->term_id === $child->term_id ): ?>
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

