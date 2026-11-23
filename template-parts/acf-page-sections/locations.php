<?php

if ( empty($appearance_modifiers) ) $appearance_modifiers = array();
if ( empty($additional_css_classes) ) $additional_css_classes = '';
if ( empty($columns_per_row) ) $columns_per_row = '3';

$locations = get_field( 'locations', 'option');

?>
<section class="layout_block locations <?php echo esc_attr( implode( ' ', $appearance_modifiers ) ); ?> <?php echo esc_attr( $additional_css_classes ); ?>">
	<div class="wrap">
		<?php
		get_template_part( 'template-parts/section_title', null, array(
			'pre_title'           => $pre_title,
			'pre_title_animation' => 'fadeInRight',
			'title'               => $title,
			'title_animation'     => 'fadeInLeft'),
		);
		?>
		
<?php if ( !empty($intro_text) ) { ?>
		<div class="intro_text wow fadeInUpSmall">
			<?php echo $intro_text; ?>	
		</div>
<?php } ?>
		
<?php if ( !empty($locations) && is_array($locations) && count($locations) ) { ?>
		<div class="columns columns-<?php echo $columns_per_row; ?> columns-top_level">
<?php foreach ( $locations as $i => $location ) : ?>
			<div class="column wow fadeInUpSmall" data-wow-delay="<?php echo $i * 150; ?>ms">
				<?php echo wp_get_attachment_image( $location['title_image'], 'medium', null, array('alt' => $location['title'], 'class' => 'title_image') ); ?>
				
<?php if ( !empty( $location['title'] ) ) { ?>
				<p class="title"><?php echo $location['title']; ?></p>
<?php } ?>
				
				<?php echo $location['intro_text']; ?>
				
<?php
if ( !empty( $location['contact_information'] ) && is_array( $location['contact_information'] ) && count( $location['contact_information'] ) ) {
	foreach ( $location['contact_information'] as $c ) {
		if ( !empty( $c['title'] ) && in_array( strtolower( $c['title'] ), array('address', 'phone') ) ) {
?>
				<?php echo $c['content']; ?>
<?php
		}
	}
}
?>
				
				<?php get_template_part( 'template-parts/buttons', null, array( 'buttons' => array( $location['button'] ) ) ); ?>
			</div>
<?php endforeach; ?>
		</div>
<?php } ?>
	</div>
</section>
