<?php

if ( empty($appearance_modifiers) ) $appearance_modifiers = array();
if ( empty($additional_css_classes) ) $additional_css_classes = '';
if ( empty($image_position) ) $image_position = 'left';
if ( empty($content) ) $content = '';

?>
<section class="layout_block interstitial_section <?php echo esc_attr( implode( ' ', $appearance_modifiers ) ); ?> <?php echo esc_attr( $additional_css_classes ); ?>">
	<div class="wrap">
		<div class="columns columns-2 columns-top_level <?php echo esc_attr( $image_position ); ?>">
			<div class="column column-1 column-image">
<?php if ( !empty($title) ) { ?>
				<p class="section_title responsive"><?php echo $title; ?></p>
<?php } ?>
				
				<?php echo wp_get_attachment_image( $image, 'medium_large', null, array('class' => 'image') ); ?>
			</div>
			
			<div class="column column-2 column-content">
				<?php get_template_part( 'template-parts/section_title', null, array( 'title' => $title ) ); ?>
				
				<?php echo $content; ?>
				
			</div>
		</div>
	</div>
</section>
