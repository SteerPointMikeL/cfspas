<?php

if ( empty($appearance_modifiers) ) $appearance_modifiers = array();
if ( empty($appearance_modifiers_more) ) $appearance_modifiers_more = array();
if ( empty($additional_css_classes) ) $additional_css_classes = '';
if ( empty($anchor_id) ) $anchor_id = 'form';

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
<section class="layout_block contact_form_style_b <?php echo esc_attr( implode( ' ', $appearance_modifiers ) ); ?> <?php echo esc_attr( implode( ' ', $appearance_modifiers_more ) ); ?> <?php echo esc_attr( $additional_css_classes ); ?>">
	<div class="wrap"><div class="layer_2"><div class="layer_3">
		<div id="<?php echo $anchor_id; ?>" class="anchor"></div>
		
		<div class="wow fadeInUpSmall">
			<?php get_template_part( 'template-parts/section_title', null, array( 'pre_title' => $pre_title, 'title' => $title ) ); ?>
			
<?php if ( !empty($intro_text) ) { ?>
			<div class="intro_text">
				<?php echo $intro_text; ?>
			</div>
<?php } ?>
		</div>
		
		<div class="form_container wow fadeInUpSmall" data-wow-delay="300ms">
<?php if ( !empty($gravityforms_form_id) ) { ?>
			<?php echo do_shortcode('[gravityforms id="' . $gravityforms_form_id . '" title="' . $show_title . '" description="' . $show_description . '" ajax=true]'); ?>
<?php } ?>
		</div>
	</div></div></div>
</section>
