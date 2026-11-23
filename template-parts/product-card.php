<?php
/**
 * Product card. Expects to be called inside a product loop (uses the current post).
 *
 * $args:
 *   button_text  - card button text (default "View Details")
 *   show_details - show collection/seats/jets line
 *   show_logo    - show brand logo
 */

$button_text  = !empty( $args['button_text'] ) ? $args['button_text'] : __( 'View Details', SP_TEXT_DOMAIN );
$show_details = isset( $args['show_details'] ) ? filter_var( $args['show_details'], FILTER_VALIDATE_BOOLEAN ) : true;
$show_logo    = isset( $args['show_logo'] ) ? filter_var( $args['show_logo'], FILTER_VALIDATE_BOOLEAN ) : true;

$product_id = get_the_ID();
$permalink = get_permalink();
$brand_logo = $show_logo ? sp_get_product_brand_logo( $product_id, 'medium' ) : '';
$image = sp_get_product_image( $product_id, 'front', 'sp_medium_less_large' );
$details = $show_details ? sp_get_product_card_details( $product_id ) : array();
$group = $details['group'] ?? '';
unset( $details['group'] );

?>
<article id="product-<?php echo $product_id; ?>" class="product_card">
<?php if ( $brand_logo ) { ?>
	<div class="brand_logo_container"><?php echo $brand_logo; ?></div>
<?php } ?>

	<a href="<?php echo esc_url( $permalink ); ?>" class="image_container" tabindex="-1" aria-hidden="true">
		<?php echo $image; ?>
	</a>

	<p class="title"><a href="<?php echo esc_url( $permalink ); ?>"><?php the_title(); ?></a></p>

<?php if ( $group ) { ?>
	<p class="group"><?php echo esc_html( wp_strip_all_tags( $group ) ); ?></p>
<?php } ?>

<?php if ( $details ) { ?>
	<ul class="details">
<?php foreach ( $details as $key => $detail ) { ?>
		<li class="detail-<?php echo esc_attr( $key ); ?>"><?php echo $detail; ?></li>
<?php } ?>
	</ul>
<?php } ?>

	<div class="button_container">
		<a href="<?php echo esc_url( $permalink ); ?>" class="sp_button"><?php echo esc_html( $button_text ); ?><span class="screen-reader-text">: <?php echo esc_html( wp_strip_all_tags( get_the_title() ) ); ?></span></a>
	</div>
</article>
