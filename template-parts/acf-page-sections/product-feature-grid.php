<?php

if ( empty($products) ) return false;

if ( empty($appearance_modifiers) ) $appearance_modifiers = array();
if ( empty($additional_css_classes) ) $additional_css_classes = '';
if ( empty($columns_per_row) ) $columns_per_row = '4';

?>
<section class="layout_block product_feature_grid <?php echo esc_attr( implode( ' ', $appearance_modifiers ) ); ?> <?php echo esc_attr( $additional_css_classes ); ?>">
	<div class="wrap">
		<?php get_template_part( 'template-parts/section_title', null, array( 'title' => $title ) ); ?>
		
<?php if ( !empty($intro_text) ) { ?>
		<div class="intro_text">
			<?php echo $intro_text; ?>	
		</div>
<?php } ?>
		
		<div class="columns columns-<?php echo $columns_per_row; ?> columns-top_level">
<?php foreach ( $products as $product ) : ?>
			<div class="column">
<?php
if ( !empty( $product['image'] ) ) {
	$image_src = wp_get_attachment_image_src( $product['image'], 'full' );
	
	if ( is_array($image_src) && count($image_src) ) {
?>
				<div class="image_container">

					<?php echo wp_get_attachment_image( $product['image'], 'medium', null, array( 'class' => 'image' ) ); ?>
					
				</div>
<?php
	}
}
?>
				
<?php if ( !empty( $product['pre_title'] ) ) { ?>
				<p class="pre_title"><?php echo $product['pre_title']; ?></p>
<?php } ?>
				
<?php if ( !empty( $product['title'] ) ) { ?>
				<p class="title"><?php echo $product['title']; ?></p>
<?php } ?>
				
<?php if ( !empty( $product['content'] ) ) { ?>
				<div class="content">
					
					<?php echo $product['content']; ?>
					
				</div>
<?php } ?>
				
<?php
$href = '';
if ( !empty( $product['button']['link_type'] ) ) {
	if ( $product['button']['link_type'] === 'page_link' && !empty( $product['button']['page_link'] ) ) {
		$href = $product['button']['page_link'];
	} else if ( $product['button']['link_type'] === 'url' && !empty( $product['button']['url'] ) )  {
		$href = $product['button']['url'];
	}
}

if ( !empty($href) ) {
?>
				<div class="button_container">
					<a href="<?php echo esc_url( $href ); ?>" class="sp_button"><?php echo !empty($product['button']['button_text']) ? $product['button']['button_text'] : __( 'Learn More', SP_TEXT_DOMAIN ); ?></a>
				</div>
				
				<a href="<?php echo esc_url( $href ); ?>" class="full_coverage_link"><?php echo !empty($product['button']['button_text']) ? $product['button']['button_text'] : __( 'Learn More', SP_TEXT_DOMAIN ); ?></a>
<?php } ?>
			</div>
<?php endforeach; ?>
		</div>
		
		<?php get_template_part( 'template-parts/buttons', null, array( 'buttons' => $buttons ) ); ?>
	</div>
</section>
