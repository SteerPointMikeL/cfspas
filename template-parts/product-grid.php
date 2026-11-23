<?php

$grid_args = $args['args'];
$products  = $args['products'];

if ( !$products->have_posts() ) {
	if ( !empty( $grid_args['empty_message'] ) ) {
?>
<div class="product_grid product_grid-empty <?php echo esc_attr( $grid_args['class'] ); ?>">
	<p><?php echo esc_html( $grid_args['empty_message'] ); ?></p>
</div>
<?php
	}
	
	return;
}

$columns_per_row = min( 6, max( 1, intval( $grid_args['columns'] ) ?: 3 ) );

?>
<div class="product_grid <?php echo esc_attr( $grid_args['class'] ); ?>">
	<div class="columns columns-<?php echo $columns_per_row; ?> columns-products">
<?php while ( $products->have_posts() ) : $products->the_post(); ?>
		<div class="column">
			<article id="product-<?php echo get_the_ID(); ?>" class="product_card">
<?php
	$brand_image_id = sp_get_product_brand_image_id();
	if ( $brand_image_id ) {
?>
				<?php echo wp_get_attachment_image( $brand_image_id, 'medium', null, array('class' => 'image brand_image') ); ?>
<?php } ?>
		
<?php
	$header_fields = get_field('header');
	if ( !empty( $header_fields['image'] ) ) {
?>
				<?php echo wp_get_attachment_image( $header_fields['image'], 'medium', null, array('class' => 'image') ); ?>
<?php } ?>
				
				<p class="title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></p>
				
				<div class="details">
<?php
$category = sp_get_the_terms_children_first( get_the_ID(), 'cfspas_product_brand' );
if ( !is_wp_error($category) ) {
?>
					<p class="category"><i class="icon-tags"></i> <?php echo $category[0]->name; ?></p>
<?php } ?>
					
<?php
	$specifications_fields = get_field('specifications_section');
	if ( !empty( $specifications_fields['specifications'] ) && is_array( $specifications_fields['specifications'] ) && count( $specifications_fields['specifications'] ) ) {
?>
					<ul class="specifications">
<?php
	foreach ( $specifications_fields['specifications'] as $s ) {
		if ( !$s['card_visibility'] ) continue;
		
		$icon_css_class = !empty( $s['icon_css_class'] ) ? $s['icon_css_class'] : sp_guess_icon_from_name( $s['name'] );
?>
						<li>
<?php if ( $icon_css_class ) { ?>
							<i class="icon-<?php echo esc_attr( $icon_css_class ); ?>"></i>
<?php } ?>
							
							<?php echo $s['value']; ?>
						</li>
<?php } ?>
					</ul>
<?php } ?>
				</div>
				
				<?php
				get_template_part( 'template-parts/buttons', null, array( 'buttons' => array(
					'button_text' => __( 'View Details', SP_TEXT_DOMAIN ),
					'link_type'   => 'url',
					'url'         => get_the_permalink()
				) ) );
				?>
			</article>
		</div>
<?php endwhile; ?>
	</div>
</div>
