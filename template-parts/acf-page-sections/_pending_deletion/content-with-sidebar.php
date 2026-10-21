<?php

if ( empty($appearance_modifiers) ) $appearance_modifiers = array();
if ( empty($additional_css_classes) ) $additional_css_classes = '';
if ( empty($content) ) $content = '';

?>
<section class="layout_block content_with_sidebar <?php echo esc_attr( implode( ' ', $appearance_modifiers ) ); ?> <?php echo esc_attr( $additional_css_classes ); ?>">
	<div class="wrap clearfix">
		<div class="columns columns-2 columns-top_level">
			<div class="column column-content">
				<?php get_template_part( 'template-parts/section_title', null, array( 'title' => $title ) ); ?>
				
				<?php echo $content; ?>
				
			</div>
			
			<div class="column column-sidebar">
				
				<?php get_sidebar( $sidebar ); ?>
				
			</div>
		</div>
	</div>
</section>
