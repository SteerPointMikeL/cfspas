<?php

if ( empty($appearance_modifiers) ) $appearance_modifiers = array();
if ( empty($additional_css_classes) ) $additional_css_classes = '';
if ( empty($content) ) $content = '';
if ( empty($background_attachment) ) $background_attachment = 'scroll';

?>
<section class="layout_block interstitial_section <?php echo esc_attr( implode( ' ', $appearance_modifiers ) ); ?> <?php echo esc_attr( $additional_css_classes ); ?> background_attachment-<?php echo esc_attr( $background_attachment ); ?>"<?php if ( !empty($background) ) { ?> style="background-image: url(<?php echo wp_get_attachment_image_url( $background, 'full' ); ?>"<?php } ?>>
	
<?php if ( !empty($overlay) ) { ?>
	<div class="overlay"></div>
<?php } ?>
	
	<div class="wrap clearfix"><div class="layer_2">
		<?php get_template_part( 'template-parts/section_title', null, array( 'pre_title' => $pre_title, 'title' => $title ) ); ?>
		
		<div class="content">
			
			<?php echo $content; ?>
			
		</div>
		
		<?php get_template_part( 'template-parts/buttons', null, array( 'buttons' => $buttons ) ); ?>
	</div></div>
</section>
