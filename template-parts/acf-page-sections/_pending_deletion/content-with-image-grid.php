<?php

if ( empty($appearance_modifiers) ) $appearance_modifiers = array();
if ( empty($additional_css_classes) ) $additional_css_classes = '';
if ( empty($content) ) $content = '';
if ( empty($content_after_images) ) $content_after_images = '';

?>
<section class="layout_block content_with_image_grid <?php echo esc_attr( implode( ' ', $appearance_modifiers ) ); ?> <?php echo esc_attr( $additional_css_classes ); ?>">
	<div class="wrap clearfix">
		<?php get_template_part( 'template-parts/section_title', null, array( 'title' => $title ) ); ?>
		
		<div class="content">
			
			<?php echo $content; ?>
			
		</div>
		
<?php if ( !empty( $images) ) { ?>
		<div class="columns columns-top_level columns-3 columns-images">
<?php foreach ( $images as $image ) { ?>
			<div class="column">
				<?php echo wp_get_attachment_image( $image, 'medium_large', null, array('class' => 'image') ); ?>
			</div>
<?php } ?>
		</div>
<?php } ?>
			
			<div class="content">
				
				<?php echo $content_after_images; ?>
				
			</div>
			
			<?php get_template_part( 'template-parts/buttons', null, array( 'buttons' => $buttons ) ); ?>
			
		</div>
	</div>
</section>
