<?php

if ( empty($appearance_modifiers) ) $appearance_modifiers = array();
if ( empty($additional_css_classes) ) $additional_css_classes = '';
if ( empty($column_space_distribution) ) $column_space_distribution = '';
if ( empty($image_position) ) $image_position = 'left';
if ( empty($content) ) $content = '';

?>
<section class="layout_block content_with_image_grid <?php echo esc_attr( implode( ' ', $appearance_modifiers ) ); ?> <?php echo esc_attr( $additional_css_classes ); ?> <?php echo esc_attr( $column_space_distribution ); ?>">
	<div class="wrap">
		<div class="columns columns-2 columns-top_level <?php echo esc_attr( $image_position ); ?>">
			<div class="column column-1 column-content">
				<?php get_template_part( 'template-parts/section_title', null, array( 'pre_title' => $pre_title, 'title' => $title ) ); ?>
				
				<?php echo $content; ?>
				
				<?php get_template_part('template-parts/buttons', null, array( 'buttons' => $buttons ) ); ?>
			</div>
			
			<div class="column column-2 column-image">
<?php if ( is_array($grid_items) && count($grid_items) ) { ?>
				<div class="grid_items">
<?php foreach ( $grid_items as $grid_item ) { ?>
					<div class="grid_item">
<?php if ( $grid_item['content_type'] === 'image' ) { ?>
						<?php echo wp_get_attachment_image( $grid_item['image'], 'medium', null, array('class' => 'image') ); ?>
<?php } else if ( $grid_item['content_type'] === 'link' ) { ?>		
						<?php get_template_part('template-parts/buttons', null, array( 'buttons' => array( $grid_item['link']['button'] ), 'class' => '', 'button_text_format' => '<i class="icon-' . $grid_item['link']['icon_css_class'] . '"></i> %s') ); ?>
<?php } ?>
					</div>
<?php } ?>
				</div>
<?php } ?>
			</div>
		</div>
	</div>
</section>
