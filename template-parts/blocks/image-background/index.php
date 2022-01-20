<?php

/**
 * Image & Background Block Template.
 */

$id        = "g66_image-background";
$image     = get_field( "image" );
$position  = get_field( "position" );
$className = null;
if ( ! empty( $block['className'] ) ) {
	$className = $block['className'];
}

$backgroundColor = "#475694";
if ( ! empty( get_field( "primary_colors" ) ) ) {
	$backgroundColor = get_field( "primary_colors" )["value"];
} elseif ( ! empty( get_field( "neutral_colors" ) ) ) {
	$backgroundColor = get_field( "neutral_colors" )["value"];
} elseif ( ! empty( get_field( "accent_colors" ) ) ) {
	$backgroundColor = get_field( "accent_colors" )["value"];
} elseif ( ! empty( get_field( "semantic_colors" ) ) ) {
	$backgroundColor = get_field( "semantic_colors" )["value"];
}
$classFlex    = $position["value"] === "left" ? "flex-row" : "flex-row-reverse";
?>
<div id="<?php echo esc_attr( $id ); ?>" class="<?php echo esc_attr( $className ); ?>">
    <div class="block-content w-full h-full flex <?php echo $classFlex ?>">
        <div class="block-image w-3/5 flex items-center relative z-10">
            <span class="block bg-no-repeat bg-center bg-cover w-full h-3/5"
                  style="background-image: url('<?php echo $image["url"] ?>')"><?php echo $image["title"] ?></span>
        </div>
        <div class="block-text w-2/5 py-24 text-neutral-4 relative px-12">
			<?php echo get_field( "information" ); ?>
        </div>
    </div>
    <style>
        #<?php echo $id ?> .block-content {
            padding: 2rem 0;
        }
        #<?php echo $id ?> .block-content .block-image span {
            text-indent: -9999px;
        }
        #<?php echo $id ?> .block-content .block-text {
            background-color: <?php echo $backgroundColor; ?>;
        }
        #<?php echo $id ?> .block-content .block-text::before {
            content: "";
            top: 0;
            bottom: 0;
            width: 100px;
            height: 100%;
            position: absolute;
            background-color: <?php echo $backgroundColor; ?>;
            <?php echo $position["value"] === "left" ? "transform: translateX(-100%);" : "transform: translateX(100%);" ?>
            <?php echo $position["value"] === "left" ? "left: 0;" : "right: 0;" ?>
        }
        #<?php echo $id ?> + h2 {
            padding-top: 4rem;
        }
    </style>
</div>