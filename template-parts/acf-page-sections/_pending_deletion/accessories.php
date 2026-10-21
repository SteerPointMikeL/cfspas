<?php

if ( empty($accessories) ) return false;

if ( empty($appearance_modifiers) ) $appearance_modifiers = array();
if ( empty($additional_css_classes) ) $additional_css_classes = '';
if ( empty($columns_per_row) ) $columns_per_row = '5';

?>
<section class="layout_block accessories <?php echo esc_attr( implode( ' ', $appearance_modifiers ) ); ?> <?php echo esc_attr( $additional_css_classes ); ?>">
	<div class="wrap">
		<?php get_template_part( 'template-parts/section_title', null, array( 'title' => $title ) ); ?>
		
<?php if ( !empty($intro_text) ) { ?>
		<div class="intro_text">
			<?php echo $intro_text; ?>	
		</div>
<?php } ?>
		
		<div class="columns columns-<?php echo $columns_per_row; ?> columns-top_level">
<?php foreach ( $accessories as $accessory ) : ?>
			<div class="column">
				<div class="image_container">
					<?php echo wp_get_attachment_image( $accessory['image'], 'medium', null, array('class' => 'image') ); ?>
				</div>
				
<?php if ( !empty( $accessory['pre_title'] ) ) { ?>
				<p class="pre_title"><?php echo $accessory['pre_title']; ?></p>
<?php } ?>
				
<?php if ( !empty( $accessory['title'] ) ) { ?>
				<p class="title"><?php echo $accessory['title']; ?></p>
<?php } ?>
				
<?php
$href = '';
if ( !empty( $accessory['link_type'] ) ) {
	if ( $accessory['link_type'] === 'page_link' && !empty( $accessory['page_link'] ) ) {
		$href = $accessory['page_link'];
	} else if ( $accessory['link_type'] === 'url' && !empty( $accessory['url'] ) ) {
		$href = $accessory['url'];
	}
}

if ( !empty($href) ) {
?>
				<a href="<?php echo esc_url( $href ); ?>" class="full_coverage_link"><?php echo !empty( $accessory['title'] ) ? $accessory['title'] : '&nbsp;'; ?></a></p>
<?php } ?>
			</div>
<?php endforeach; ?>
		</div>
		
		<?php get_template_part( 'template-parts/buttons', null, array( 'buttons' => $buttons ) ); ?>
	</div>
</section>
