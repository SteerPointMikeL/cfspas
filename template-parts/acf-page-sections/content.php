<?php

if ( empty($appearance_modifiers) ) $appearance_modifiers = array();
if ( empty($additional_css_classes) ) $additional_css_classes = '';
if ( empty($content) ) $content = '';

?>
<section class="layout_block content_editor <?php echo esc_attr( implode( ' ', $appearance_modifiers ) ); ?> <?php echo esc_attr( $additional_css_classes ); ?>">
	<div class="wrap clearfix">
		<?php get_template_part( 'template-parts/section_title', null, array( 'title' => $title ) ); ?>
		
		<div class="content">
			
			<?php echo $content; ?>
			
		</div>
	</div>
</section>
