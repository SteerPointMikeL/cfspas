<?php

if ( empty($appearance_modifiers) ) $appearance_modifiers = array();
if ( empty($additional_css_classes) ) $additional_css_classes = '';
if ( empty($columns_per_row) ) $columns_per_row = 3;
if ( empty($pre_title) ) $pre_title = '';
if ( empty($title) ) $title = '';
if ( empty($buttons) ) $buttons = array();

$product_grid = sp_render_product_grid( array(
	'type'        => $product_types ?? '',
	'brand'       => $product_brands ?? '',
	'collection'  => $product_collections ?? '',
	'ids'         => $specific_products ?? '',
	'limit'       => !empty($number_of_products) ? $number_of_products : -1,
	'orderby'     => $order_by ?? '',
	'columns'     => $columns_per_row,
	'filter_by'   => $filter_by ?? '',
	'button_text' => $card_button_text ?? '',
) );

// nothing to show
if ( empty($product_grid) ) return;

?>
<section class="layout_block product_grid_section <?php echo esc_attr( implode( ' ', $appearance_modifiers ) ); ?> <?php echo esc_attr( $additional_css_classes ); ?>">
	<div class="wrap">
		<?php get_template_part( 'template-parts/section_title', null, array( 'pre_title' => $pre_title, 'title' => $title ) ); ?>

<?php if ( !empty($intro_text) ) { ?>
		<div class="intro_text">
			<?php echo $intro_text; ?>
		</div>
<?php } ?>

		<?php echo $product_grid; ?>

		<?php get_template_part( 'template-parts/buttons', null, array( 'buttons' => $buttons ) ); ?>
	</div>
</section>
