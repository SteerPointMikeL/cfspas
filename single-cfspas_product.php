<?php
/**
 * Single product (cfspas_product).
 *
 * Section order mirrors the original product pages: intro (image, brand, title, price,
 * availability, buttons), specifications, call to action, 3D viewer, about, video,
 * optional per-product page sections, features, optional features, related products,
 * pricing request form and pricing disclaimer.
 */

global $h1_already_used;

get_header();

if ( have_posts() ) : the_post();

$product_id = get_the_ID();
$option = function( $name, $default = '' ) {
	$value = function_exists( 'get_field' ) ? get_field( $name, 'option' ) : '';

	return ( $value === null || $value === '' || $value === false ) ? $default : $value;
};
$field = function( $name, $default = '' ) use ( $product_id ) {
	$value = function_exists( 'get_field' ) ? get_field( $name, $product_id ) : '';

	return ( $value === null || $value === '' || $value === false ) ? $default : $value;
};

$type_label = sp_get_product_type_singular_label( $product_id );
$title_with_type = sp_get_product_title_with_type( $product_id );
$collection = sp_get_product_collection( $product_id );
$brand = sp_get_product_brand( $product_id );
$type = sp_get_product_type( $product_id );

$request_pricing_text = $option( 'product_request_pricing_button_text', __( 'Request Sale Pricing', SP_TEXT_DOMAIN ) );
$financing_link = $option( 'product_financing_page' );

$gallery = $field( 'gallery', array() );
$front_image = sp_get_product_image( $product_id, 'front', 'large', array( 'loading' => 'eager', 'fetchpriority' => 'high' ) );
$top_image = sp_get_product_image( $product_id, 'top', 'large' );
$brand_logo = sp_get_product_brand_logo( $product_id, 'medium' );
$availability = sp_get_product_availability( $product_id );
$specs = sp_get_product_specs( $product_id );

$pricing = array_filter( array(
	__( 'Color', SP_TEXT_DOMAIN )            => $field( 'color_option' ),
	__( 'Year', SP_TEXT_DOMAIN )             => $field( 'manufacture_year' ),
	__( 'Warranty', SP_TEXT_DOMAIN )         => $field( 'warranty' ),
	__( 'MSRP', SP_TEXT_DOMAIN )             => $field( 'msrp' ),
	__( 'Regular Price', SP_TEXT_DOMAIN )    => $field( 'regular_price' ),
	__( 'Sale Price', SP_TEXT_DOMAIN )       => $field( 'sale_price' ),
	__( 'Monthly Payments', SP_TEXT_DOMAIN ) => $field( 'monthly_payment' ),
) );

$standard_features = $field( 'standard_features', array() );
$optional_features = $field( 'optional_features', array() );

$h1_already_used = true;
?>

<main id="main" class="single_product <?php echo $type ? esc_attr( 'product_type-' . $type->slug ) : ''; ?>">

	<?php /* Intro */ ?>
	<section class="layout_block product_intro">
		<div class="wrap">
			<div class="columns columns-2 columns-top_level">
				<div class="column column-image">
<?php if ( $gallery ) {
	wp_enqueue_style( 'glightbox' );
	wp_enqueue_script( 'glightbox' );
	$gallery_id = wp_unique_id( 'product_gallery-' );
?>
					<div id="<?php echo $gallery_id; ?>" class="product_gallery">
<?php foreach ( $gallery as $i => $image_id ) { ?>
						<a href="<?php echo esc_url( wp_get_attachment_image_url( $image_id, 'full' ) ); ?>" class="glightbox <?php echo $i === 0 ? 'main_image' : 'thumbnail'; ?>" data-gallery="<?php echo $gallery_id; ?>">
							<?php echo wp_get_attachment_image( $image_id, $i === 0 ? 'large' : 'thumbnail', false, array( 'class' => 'image' ) ); ?>
						</a>
<?php } ?>
					</div>
					<script>
					jQuery(document).ready(function($) {
						GLightbox({ selector: '#<?php echo $gallery_id; ?> .glightbox' });
					});
					</script>
<?php } else { ?>
					<?php echo $front_image; ?>
<?php } ?>
				</div>

				<div class="column column-content">
<?php if ( $brand_logo ) { ?>
					<div class="brand_logo_container"><?php echo $brand_logo; ?></div>
<?php } ?>

<?php if ( $field( 'model_year' ) ) { ?>
					<p class="model_year"><?php echo esc_html( $field( 'model_year' ) ); ?></p>
<?php } ?>

					<h1 class="section_title product_title"><?php the_title(); ?></h1>

<?php if ( $field( 'price_text' ) ) { ?>
					<p class="price"><span class="label"><?php _e( 'Our Price*', SP_TEXT_DOMAIN ); ?></span> <?php echo esc_html( $field( 'price_text' ) ); ?></p>
<?php } ?>

<?php if ( $pricing ) { ?>
					<dl class="pricing">
<?php foreach ( $pricing as $label => $value ) { ?>
						<div class="pricing_row">
							<dt><?php echo esc_html( $label ); ?>:</dt>
							<dd><?php echo esc_html( $value ); ?></dd>
						</div>
<?php } ?>
					</dl>
<?php } ?>

<?php if ( $availability['text'] ) { ?>
					<p class="availability">
						<i class="icon-map-marker" aria-hidden="true"></i>
<?php if ( $availability['link'] ) { ?>
						<a href="<?php echo esc_url( $availability['link'] ); ?>"><?php echo wp_kses_post( $availability['text'] ); ?></a>
<?php } else { ?>
						<?php echo wp_kses_post( $availability['text'] ); ?>
<?php } ?>
					</p>
<?php } ?>

					<div class="button_container">
						<a href="#form" class="sp_button"><?php echo esc_html( $request_pricing_text ); ?></a>
<?php if ( $financing_link && !$field( 'hide_financing_button' ) ) { ?>
						<a href="<?php echo esc_url( $financing_link ); ?>" class="sp_button alternate"><?php _e( 'Financing Options', SP_TEXT_DOMAIN ); ?></a>
<?php } ?>
					</div>
				</div>
			</div>
		</div>
	</section>

<?php /* Specifications */ ?>
<?php if ( $specs || $top_image ) { ?>
	<section class="layout_block product_specs light_grey_background">
		<div class="wrap">
			<div class="columns columns-<?php echo $top_image ? 2 : 1; ?> columns-top_level">
				<div class="column column-content">
					<?php get_template_part( 'template-parts/section_title', null, array(
						'pre_title' => $field( 'specifications_pre_title', __( 'Model Overview', SP_TEXT_DOMAIN ) ),
						'title'     => $field( 'tagline', sprintf( __( '%s Specifications', SP_TEXT_DOMAIN ), get_the_title() ) ),
					) ); ?>

<?php if ( $specs ) { ?>
					<dl class="specs">
<?php foreach ( $specs as $spec ) { ?>
						<div class="spec">
							<dt><?php echo esc_html( $spec['label'] ); ?></dt>
<?php foreach ( $spec['values'] as $value ) { ?>
							<dd><?php echo $value; ?></dd>
<?php } ?>
						</div>
<?php } ?>
					</dl>
<?php } ?>

<?php
$specs_disclaimer = $option( 'product_specs_disclaimer', __( 'All dimensions are approximate. Volume is based on average fill. Specifications are subject to change without notice.', SP_TEXT_DOMAIN ) );
if ( $specs && $specs_disclaimer ) {
?>
					<p class="disclaimer"><?php echo esc_html( $specs_disclaimer ); ?></p>
<?php } ?>

<?php if ( $field( 'brochure_url' ) ) { ?>
					<div class="button_container">
						<a href="<?php echo esc_url( $field( 'brochure_url' ) ); ?>" class="sp_button" target="_blank" rel="noopener"><?php echo esc_html( $field( 'brochure_button_text', __( 'Download Brochure', SP_TEXT_DOMAIN ) ) ); ?></a>
					</div>
<?php } ?>
				</div>

<?php if ( $top_image ) { ?>
				<div class="column column-image">
					<?php echo $top_image; ?>
				</div>
<?php } ?>
			</div>
		</div>
	</section>
<?php } ?>

<?php /* Call to action */ ?>
<?php
$cta_title = $option( 'product_cta_title', __( 'Find the Right %s for Your Lifestyle', SP_TEXT_DOMAIN ) );
if ( $cta_title ) {
?>
	<section class="layout_block product_cta dark_blue_background centered">
		<div class="wrap">
			<p class="section_title"><?php echo esc_html( sprintf( $cta_title, $type_label ) ); ?></p>

			<div class="button_container">
				<a href="#form" class="sp_button"><?php echo esc_html( $option( 'product_cta_button_text', __( 'Speak to an Expert Today', SP_TEXT_DOMAIN ) ) ); ?></a>
			</div>
		</div>
	</section>
<?php } ?>

<?php /* 3D viewer */ ?>
<?php if ( $field( 'viewer_3d' ) ) { ?>
	<section class="layout_block product_viewer_3d centered">
		<div class="wrap">
			<?php get_template_part( 'template-parts/section_title', null, array( 'pre_title' => '', 'title' => sprintf( __( 'View the %s in Your Own Space', SP_TEXT_DOMAIN ), $title_with_type ) ) ); ?>

<?php if ( $option( 'product_viewer_3d_intro_text' ) ) { ?>
			<div class="intro_text"><?php echo $option( 'product_viewer_3d_intro_text' ); ?></div>
<?php } ?>

			<div class="viewer_3d_container">
				<?php echo do_shortcode( $field( 'viewer_3d' ) ); ?>
			</div>
		</div>
	</section>
<?php } ?>

<?php /* About */ ?>
<?php if ( trim( get_the_content() ) ) { ?>
	<section class="layout_block product_about">
		<div class="wrap">
			<div class="columns columns-2 columns-top_level">
				<div class="column column-content">
					<?php get_template_part( 'template-parts/section_title', null, array( 'pre_title' => __( 'About', SP_TEXT_DOMAIN ), 'title' => sprintf( __( 'About the %s', SP_TEXT_DOMAIN ), $title_with_type ) ) ); ?>

					<div class="content">
						<?php the_content(); ?>
					</div>

					<div class="button_container">
						<a href="#form" class="sp_button"><?php echo esc_html( $request_pricing_text ); ?></a>
					</div>
				</div>

<?php if ( $field( 'about_image' ) ) { ?>
				<div class="column column-image">
					<?php echo wp_get_attachment_image( $field( 'about_image' ), 'large', false, array( 'class' => 'image' ) ); ?>
				</div>
<?php } ?>
			</div>
		</div>
	</section>
<?php } ?>

<?php /* Video */ ?>
<?php
$video = $field( 'video', array() );
if ( !empty( $video['video_type'] ) ) {
?>
	<section class="layout_block product_video centered">
		<div class="wrap">
			<?php get_template_part( 'template-parts/section_title', null, array( 'pre_title' => '', 'title' => sprintf( __( 'Watch the %s Video', SP_TEXT_DOMAIN ), $title_with_type ) ) ); ?>

			<?php get_template_part( 'template-parts/video', null, array( 'video' => $video, 'title' => sprintf( __( 'Play %s video', SP_TEXT_DOMAIN ), wp_strip_all_tags( $title_with_type ) ) ) ); ?>
		</div>
	</section>
<?php } ?>

<?php /* Additional per-product page sections (e.g. SmartTub® promo) */ ?>
<?php if ( function_exists( 'sp_load_acf_page_sections' ) ) sp_load_acf_page_sections( $field( 'page_sections', array() ) ); ?>

<?php /* Features */ ?>
<?php if ( $standard_features ) { ?>
	<section class="layout_block product_features">
		<div class="wrap">
			<?php get_template_part( 'template-parts/section_title', null, array( 'pre_title' => '', 'title' => sprintf( __( 'Features of the %s', SP_TEXT_DOMAIN ), $title_with_type ) ) ); ?>

			<?php echo sp_render_feature_grid( $standard_features, 3 ); ?>
		</div>
	</section>
<?php } ?>

<?php if ( $optional_features ) { ?>
	<section class="layout_block product_features product_features-optional">
		<div class="wrap">
			<?php get_template_part( 'template-parts/section_title', null, array( 'pre_title' => '', 'title' => sprintf( __( 'Optional Features of the %s', SP_TEXT_DOMAIN ), $title_with_type ) ) ); ?>

			<?php echo sp_render_feature_grid( $optional_features, 3 ); ?>
		</div>
	</section>
<?php } ?>

<?php /* Related products: same collection (or brand when there's no collection) and type */ ?>
<?php
if ( !$field( 'hide_related_products' ) && ( $collection || $brand ) ) {
	$related_group = $collection ?: $brand;
	$related_grid = sp_render_product_grid( array(
		'type'            => $type ? $type->term_id : '',
		'collection'      => $collection ? $collection->term_id : '',
		'brand'           => $collection ? '' : $brand->term_id,
		'exclude_current' => true,
		'columns'         => 4,
	) );

	if ( $related_grid ) {
?>
	<section class="layout_block product_related light_grey_background">
		<div class="wrap">
			<?php get_template_part( 'template-parts/section_title', null, array( 'pre_title' => '', 'title' => sprintf( __( 'Browse the %s', SP_TEXT_DOMAIN ), $related_group->name ) ) ); ?>

			<?php echo $related_grid; ?>
		</div>
	</section>
<?php
	}
}
?>

<?php /* Pricing request form */ ?>
	<div id="form" class="anchor"></div>
<?php
if ( function_exists( 'sp_render_acf_page_section' ) ) sp_render_acf_page_section( 'contact-form', array(
	'appearance_modifiers'   => array(),
	'additional_css_classes' => 'product_contact_form',
	'pre_title'              => $option( 'product_contact_pre_title', __( 'Get in Touch', SP_TEXT_DOMAIN ) ),
	'title'                  => $option( 'product_contact_title', __( 'Get Special Sale Pricing', SP_TEXT_DOMAIN ) ),
	'intro_text'             => $option( 'product_contact_intro_text' ),
	'gravityforms_form_id'   => $option( 'product_contact_form' ),
	'show_title'             => 'false',
	'show_description'       => 'false',
	// lets the form pre-fill a "Model Interested In" field set to "Allow field to be populated dynamically" with parameter name "product_name"
	'field_values'           => 'product_name=' . rawurlencode( wp_strip_all_tags( get_the_title() ) ),
) );
?>

<?php if ( $option( 'product_pricing_disclaimer' ) ) { ?>
	<section class="layout_block product_disclaimer less_padding_top">
		<div class="wrap">
			<div class="disclaimer"><?php echo $option( 'product_pricing_disclaimer' ); ?></div>
		</div>
	</section>
<?php } ?>

</main>

<?php
endif;

get_footer();
