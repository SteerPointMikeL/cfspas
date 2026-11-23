<?php

/* if ( empty($appearance_modifiers) ) $appearance_modifiers = array();
if ( empty($appearance_modifiers_more) ) $appearance_modifiers_more = array();
if ( empty($additional_css_classes) ) $additional_css_classes = '';
if ( empty($column_space_distribution) ) $column_space_distribution = '';
if ( empty($images_position) ) $images_position = 'left';
if ( empty($content) ) $content = ''; */

$appearance_modifiers      ??= array();
$appearance_modifiers_more ??= array();
$additional_css_classes    ??= '';
$column_space_distribution ??= '';
$images_position           ??= 'left';
$content                   ??= '';

$grid_item_reveal_animations = array(
	'fadeInDown',
	'fadeInRight',
	'fadeInLeft',
	'fadeInUp',
);

?>
<section class="layout_block content_with_image_grid_style_b <?php echo esc_attr( implode( ' ', array_merge( $appearance_modifiers, $appearance_modifiers_more ) ) ); ?> <?php echo esc_attr( $additional_css_classes ); ?> <?php echo esc_attr( $column_space_distribution ); ?>">
	<div class="wrap">
<?php if ( !empty($anchor_id) ) { ?>
		<div id="<?php echo esc_attr( $anchor_id ); ?>" class="anchor"></div>
<?php } ?>
		
		<div class="columns columns-2 columns-top_level <?php echo esc_attr( $images_position ); ?>">
			<div class="column column-2 column-image">
<?php if ( is_array($grid_items) && count($grid_items) ) { ?>
				<div class="grid_items grid_items-<?php echo count( max(4, $grid_items) ); ?>">
<?php foreach ( $grid_items as $i => $grid_item ) { ?>
					<div class="grid_item wow <?php echo $grid_item_reveal_animations[$i]; ?>">
						<?php echo wp_get_attachment_image( $grid_item['image'], 'medium', null, array('class' => 'image') ); ?>
						
<?php
if ( is_array( $grid_item['plots'] ) ) {
	foreach ( $grid_item['plots'] as $plot ) {
?>
						<div class="plot" style="<?php echo esc_attr( sprintf( 'left: %s%%;top: %s%%;', $plot['x_coordinate'], $plot['y_coordinate'] ) ); ?>">
							<i class="icon-dot-circle"></i>
							
							<p class="label"><?php echo $plot['label']; ?></p>
						</div>
<?php
	}
}
?>
					</div>
<?php } ?>
				</div>
<?php } ?>
			</div>
			
			<div class="column column-1 column-content wow <?php echo $images_position === 'right' ? 'fadeInLeft' : 'fadeInRight'; ?>"><div class="layer_2">
				<?php get_template_part( 'template-parts/section_title', null, array( 'pre_title' => $pre_title, 'title' => $title ) ); ?>
				
				<?php echo $content; ?>
				
				<?php get_template_part('template-parts/buttons', null, array( 'buttons' => $buttons ) ); ?>
			</div></div>
		</div>
	</div>
</section>
