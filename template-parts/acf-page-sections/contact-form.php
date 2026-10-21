<?php

if ( empty($appearance_modifiers) ) $appearance_modifiers = array();
if ( empty($additional_css_classes) ) $additional_css_classes = '';

if ( empty($show_title) ) {
	$show_title = 'false';
} else if ( is_array($show_title) ) {
	$show_title = $show_title[0];
}

if ( empty($show_description) ) {
	$show_description = 'false';
} else if ( is_array($show_description) ) {
	$show_description = $show_description[0];
}

?>
<section class="layout_block contact_form <?php echo esc_attr( implode( ' ', $appearance_modifiers ) ); ?> <?php echo esc_attr( $additional_css_classes ); ?>">
	<div class="wrap">
		<div class="columns columns-2 columns-top_level">
			<div class="column column-content"><div class="layer_2">
				<?php get_template_part( 'template-parts/section_title', null, array( 'pre_title' => $pre_title, 'title' => $title ) ); ?>
				
<?php if ( !empty($intro_text) ) { ?>
				<div class="intro_text">
					<?php echo $intro_text; ?>
				</div>
<?php } ?>
			</div></div>
			
			<div class="column column-form">
				<div class="form_container">
<?php if ( !empty($gravityforms_form_id) ) { ?>
					<?php echo do_shortcode('[gravityforms id="' . $gravityforms_form_id . '" title="' . $show_title . '" description="' . $show_description . '" ajax=true]'); ?>
<?php } ?>
				</div>
			</div>
		</div>
	</div>
</section>
