<div class="splide">
    <div class="splide__track">
        <ul class="splide__list category-filter">
			<?php foreach ( get_general_category() as $child ): if ( get_general_category( true )->term_id === $child->term_id ): ?>
                <li class="active splide__slide">
                    <span class="text-neutral-1"><?php echo $child->name ?></span>
                </li>
			<?php else: ?>
                <li class="splide__slide">
                    <a href="<?php echo get_category_link( $child->term_id ) ?>" target="_self"
                       class="text-neutral-1"><?php echo $child->name ?></a>
                </li>
			<?php endif; endforeach; ?>
        </ul>
    </div>
</div>



