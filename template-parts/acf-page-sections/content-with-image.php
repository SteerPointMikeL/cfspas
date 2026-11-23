<?php

if ( empty($appearance_modifiers) ) $appearance_modifiers = array();
if ( empty($additional_css_classes) ) $additional_css_classes = '';
if ( empty($column_space_distribution) ) $column_space_distribution = '';
if ( empty($image_position) ) $image_position = 'left';
if ( empty($content) ) $content = '';

?>
<section class="layout_block content_with_image <?php echo esc_attr( implode( ' ', $appearance_modifiers ) ); ?> <?php echo esc_attr( $additional_css_classes ); ?> <?php echo esc_attr( $column_space_distribution ); ?>">
	<div class="wrap">
		<div class="columns columns-2 columns-top_level <?php echo esc_attr( $image_position ); ?>">
			<div class="column column-1 column-image">
<?php if ( !empty($title) ) { ?>
				<p class="section_title responsive"><?php echo $title; ?></p>
<?php } ?>
				
				<?php echo wp_get_attachment_image( $image, 'medium_large', null, array( 'class' => sprintf('image wow %s', $image_position === 'right' ? 'fadeInRight' : 'fadeInLeft' ) ) ); ?>
				
<?php if ( !empty($link) ) { ?>
				<?php get_template_part('template-parts/buttons', null, array( 'buttons' => array( $link['button'] ), 'class' => 'wow fadeInUp', 'button_text_format' => '<i class="icon-' . $link['icon_css_class'] . '"></i> %s') ); ?>
<?php } ?>
				
<?php if ( !empty($image_caption) ) { ?>
				<div class="image_caption wow fadeInUp">
					<?php echo $image_caption; ?>
				</div>
<?php } ?>
			</div>
			
			<div class="column column-2 column-content wow <?php echo $image_position === 'right' ? 'fadeInLeft' : 'fadeInRight'; ?>">
				<?php get_template_part( 'template-parts/section_title', null, array( 'pre_title' => $pre_title, 'title' => $title ) ); ?>
				
				<?php echo $content; ?>
				
				<?php get_template_part('template-parts/buttons', null, array( 'buttons' => $buttons ) ); ?>
			</div>
		</div>
	</div>
</section>
