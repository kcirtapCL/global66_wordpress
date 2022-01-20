<?php

/**
 * Number & Text Block Template.
 */

$id        = "g66_number-text";
$className = null;
if ( ! empty( $block['className'] ) ) {
	$className = $block['className'];
}

$classBase = "block-content w-full h-full flex";
$classBase .= get_field( "position" )["value"] === "left" ? " flex-row" : " flex-row-reverse";

?>
<div id="<?php echo esc_attr( $id ); ?>" class="<?php echo esc_attr( $className ); ?>">
    <div class="<?php echo esc_attr( $classBase ) ?>">
        <div class="flex items-center justify-center w-1/3 relative">
            <span class="text-9xl absolute text-neutral-2 opacity-20"><?php echo get_field( "number" ); ?></span>
            <p class="number font-bold text-xl text-neutral-1 text-center"><?php echo get_field( "text" ); ?></p>
        </div>
        <div class="block-text w-2/3 text-neutral-2"><?php echo get_field( "information" ); ?></div>
    </div>
    <style>
        #<?php echo $id ?> {
            --tw-space-y-reverse: 0;
            margin-top: calc(2rem * calc(1 - var(--tw-space-y-reverse)));
            margin-bottom: calc(2rem * var(--tw-space-y-reverse));
        }
        #<?php echo $id ?> .block-content .block-text ul {
            list-style-type: disc;
        }
        #<?php echo $id ?> .block-content .block-text ol {
            list-style-type: decimal;
        }
        #<?php echo $id ?> .block-content .block-text ul li,
        #<?php echo $id ?> .block-content .block-text ol li {
            --tw-space-y-reverse: 0;
            margin-top: calc(1rem * calc(1 - var(--tw-space-y-reverse)));
            margin-bottom: calc(1rem * var(--tw-space-y-reverse));
        }
    </style>
</div>
