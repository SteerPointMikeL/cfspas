<?php

if ( empty($appearance_modifiers) ) $appearance_modifiers = array();
if ( empty($appearance_modifiers_more) ) $appearance_modifiers_more = array();
if ( empty($additional_css_classes) ) $additional_css_classes = '';

?>
<section class="layout_block material_options <?php echo esc_attr( implode( ' ', array_merge( $appearance_modifiers, $appearance_modifiers_more) ) ); ?> <?php echo esc_attr( $additional_css_classes ); ?>">
	<div class="wrap">
<?php if ( !empty($anchor_id) ) { ?>
		<div id="<?php echo esc_attr( $anchor_id ); ?>" class="anchor"></div>
<?php } ?>
		
		<div class="wow fadeInUpSmall">
			<?php get_template_part( 'template-parts/section_title', null, array( 'pre_title' => $pre_title, 'title' => $title ) ); ?>
			
<?php if ( !empty($intro_text) ) { ?>
			<div class="intro_text">
				<?php echo $intro_text; ?>	
			</div>
<?php } ?>
		</div>
		
<?php
if ( !empty($options_groups) && is_array($options_groups) && count($options_groups) ) {
	foreach ( $options_groups as $group ) {
?>		
		<div class="options_group">
<?php if ( !empty( $group['title'] ) ) { ?>
			<p class="title"><?php echo $group['title']; ?></p>
<?php } ?>
			
<?php if ( !empty( $group['options'] ) && is_array( $group['options'] ) && count( $group['options'] ) ) { ?>
			<div class="options">
<?php foreach ( $group['options'] as $i => $option ) : ?>
				<div class="option wow fadeIn" data-wow-delay="<?php echo $i * 150; ?>ms">
					<div class="image_container">
						<?php echo wp_get_attachment_image( $option['image'], 'medium', null, array('class' => 'image') ); ?>
						
<?php if ( !empty( $option['title'] ) ) { ?>
					<p class="title"><?php echo $option['title']; ?></p>
<?php } ?>
					</div>
				</div>
<?php endforeach; ?>
			</div>
<?php } ?>
		</div>
<?php
	}
}
?>
	</div>
</section>
