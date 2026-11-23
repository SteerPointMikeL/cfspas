<?php

if ( empty($appearance_modifiers) ) $appearance_modifiers = array();
if ( empty($appearance_modifiers_more) ) $appearance_modifiers_more = array();
if ( empty($additional_css_classes) ) $additional_css_classes = '';
if ( empty($column_space_distribution) ) $column_space_distribution = '';
if ( empty($image_position) ) $image_position = 'left';
if ( empty($content) ) $content = '';

?>
<section class="layout_block content_with_image_repeater <?php echo esc_attr( implode( ' ', array_merge( $appearance_modifiers, $appearance_modifiers_more ) ) ); ?> <?php echo esc_attr( $additional_css_classes ); ?> <?php echo esc_attr( $column_space_distribution ); ?>">
	<div class="wrap">
		<div class="wow fadeInUpSmall">
			<?php get_template_part( 'template-parts/section_title', null, array( 'pre_title' => $pre_title, 'title' => $title ) ); ?>
			
			<div class="intro_text_outer">
				<div class="intro_text">
					<?php echo $intro_text; ?>
				</div>
				
				<?php get_template_part( 'template-parts/buttons', null, array( 'buttons' => array( $button ) ) ); ?>
			</div>
		</div>
	</div>
	
<?php
if ( !empty($content_with_image_pairs) && is_array($content_with_image_pairs) && count($content_with_image_pairs) ) {
	foreach ( $content_with_image_pairs as $c ) {
?>
	<div class="wrap content_with_image_pair_wrap"><div class="layer_2">
		<div class="columns columns-2 columns-top_level <?php echo esc_attr( $c['image_position'] ); ?>">
			<div class="column column-1 column-image wow <?php echo $c['image_position'] === 'right' ? 'fadeInRight' : 'fadeInLeft'; ?>">
				<?php echo wp_get_attachment_image( $c['image'], 'medium_large', null, array('class' => 'image') ); ?>
			</div>
			
			<div class="column column-2 column-content wow <?php echo $c['image_position'] === 'right' ? 'fadeInLeft' : 'fadeInRight'; ?>"><div class="layer_2">
<?php if ( !empty( $c['icon_css_class'] ) ) { ?>
				<p><i class="icon-<?php echo esc_attr( $c['icon_css_class'] ); ?>"></i></p>
<?php } ?>
				
<?php if ( !empty( $title) ) { ?>
				<p class="title"><?php echo $c['title']; ?></p>
<?php } ?>
				
				<?php echo $c['content']; ?>
			</div></div>
		</div>
	</div></div>
<?php
	}
}
?>
</section>
