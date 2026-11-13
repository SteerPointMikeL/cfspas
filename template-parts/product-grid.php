<?php
/**
 * Grid of product cards, with optional filter tabs (by collection, brand or type).
 *
 * Called from sp_render_product_grid(). $args:
 *   args     - normalized grid arguments (see sp_get_product_grid_defaults())
 *   products - WP_Query of cfspas_product posts
 */

$grid_args = $args['args'];
$products = $args['products'];

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

$columns = min( 6, max( 1, intval( $grid_args['columns'] ) ?: 3 ) );
$grid_id = wp_unique_id( 'product_grid-' );

// filter tabs
$filter_taxonomies = array(
	'collection' => 'cfspas_product_collection',
	'brand'      => 'cfspas_product_brand',
	'type'       => 'cfspas_product_type',
);
$filter_taxonomy = $filter_taxonomies[ $grid_args['filter_by'] ] ?? '';
$filter_terms = array();

if ( $filter_taxonomy ) {
	foreach ( $products->posts as $product ) {
		foreach ( sp_get_product_terms( $product->ID, $filter_taxonomy ) as $term ) {
			$filter_terms[ $term->slug ] = $term;
		}
	}

	// filters only make sense with more than one option
	if ( count( $filter_terms ) < 2 ) $filter_terms = array();
}

if ( $filter_terms ) wp_enqueue_script( 'isotope' );

?>
<div id="<?php echo $grid_id; ?>" class="product_grid <?php echo esc_attr( $grid_args['class'] ); ?>">
<?php if ( $filter_terms ) { ?>
	<ul class="filters">
		<li class="active"><a href="#" data-filter="*"><?php _e( 'All', SP_TEXT_DOMAIN ); ?></a></li>
<?php foreach ( $filter_terms as $term ) { ?>
		<li><a href="#" data-filter=".isotope-filter-<?php echo esc_attr( $term->slug ); ?>"><?php echo esc_html( $term->name ); ?></a></li>
<?php } ?>
	</ul>
<?php } ?>

	<div class="columns columns-<?php echo $columns; ?> columns-products">
<?php
while ( $products->have_posts() ) : $products->the_post();
	$classes = array( 'column' );

	if ( $filter_terms ) {
		foreach ( sp_get_product_terms( get_the_ID(), $filter_taxonomy ) as $term ) {
			$classes[] = 'isotope-filter-' . $term->slug;
		}
	}
?>
		<div class="<?php echo esc_attr( implode( ' ', $classes ) ); ?>">
			<?php get_template_part( 'template-parts/product-card', null, array(
				'button_text'  => $grid_args['button_text'],
				'show_details' => $grid_args['show_details'],
				'show_logo'    => $grid_args['show_logo'],
			) ); ?>
		</div>
<?php endwhile; ?>
	</div>

<?php if ( $filter_terms ) { ?>
	<script>
	jQuery(document).ready(function($) {
		var $grid = $('#<?php echo $grid_id; ?> .columns-products');

		$grid.isotope({
			itemSelector: '.column',
			layoutMode: 'fitRows',
			percentPosition: true,
		});

		$('#<?php echo $grid_id; ?> .filters a').on('click', function(event) {
			event.preventDefault();

			$(this).parent().addClass('active').siblings().removeClass('active');

			$grid.isotope({ filter: $(this).attr('data-filter') });
		});
	});
	</script>
<?php } ?>
</div>
