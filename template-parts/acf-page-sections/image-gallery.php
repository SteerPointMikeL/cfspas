<?php

if ( empty($images) ) return false;

wp_enqueue_script( 'isotope' );

wp_enqueue_style( 'glightbox' );
wp_enqueue_script( 'glightbox' );

if ( empty($appearance_modifiers) ) $appearance_modifiers = array();
if ( empty($additional_css_classes) ) $additional_css_classes = '';
if ( empty($columns_per_row) ) $columns_per_row = '4';

$image_gallery_id = wp_unique_id('image_gallery-');

?>
<div class="layout_block image_gallery <?php echo esc_attr( implode( ' ', $appearance_modifiers ) ); ?> <?php echo esc_attr( $additional_css_classes ); ?>">
	<div class="wrap">
		<?php get_template_part( 'template-parts/section_title', null, array('pre_title' => $pre_title, 'title' => $title) ); ?>
		
<?php if ( !empty($intro_text) ) { ?>
		<div class="intro_text">
			<?php echo $intro_text; ?>	
		</div>
<?php } ?>
		
<?php
// Build list of terms for use in filter
$terms = array();
foreach ( $images as &$image ) {
	$image['categories_array'] = array();
	
	if ( empty( $image['categories'] ) ) continue;
	
	$image['categories_array'] = explode( ',', $image['categories'] );
	
	foreach ( $image['categories_array'] as &$category ) {
		$category = trim( $category );
		$category = array(
			'label' => $category,
			'slug'  => sanitize_title( $category ),
		);
		
		if ( in_array( $category['label'], wp_list_pluck( $terms, 'label' ) ) ) continue; // no duplicates
		
		$terms[] = $category;
	}
}
unset($image); // remove lingering reference in final array field
?>
		
<?php if ( count($terms) ) { ?>
		<ul id="<?php echo $image_gallery_id; ?>-filters" class="filters">
			<li class="active"><a href="#" data-filter="*">All</a></li>
<?php foreach ( $terms as $term ) { ?>
			<li>
				<a href="#" data-filter=".isotope-filter-<?php echo esc_attr( $term['slug'] ); ?>"><?php echo esc_html( $term['label'] ); ?></a>
			</li>
<?php } ?>
		</ul>
<?php } ?>
		
		<div id="<?php echo $image_gallery_id; ?>" class="grid columns-<?php echo $columns_per_row; ?> clearfix">
<?php
foreach ( $images as $image ) {
	$filter_terms = array_map( function($a) { return 'isotope-filter-' . $a['slug']; }, $image['categories_array'] );
	
	$image_url = wp_get_attachment_image_src( $image['image'], 'full' );
	if ( $image_url ) $image_url = $image_url[0];
?>
			<div class="grid-item <?php echo implode(' ', $filter_terms); ?>">
				<?php echo wp_get_attachment_image( $image['image'], 'medium', null, array('class' => 'image') ); ?>
				
				<a href="<?php echo $image_url; ?>" class="full_coverage_link glightbox"><?php _e( 'View full size image', SP_TEXT_DOMAIN ); ?></a> 
			</div>
<?php } ?>
		</div>
	</div>
	
	<script>
	jQuery(document).ready(function($) {
		var $imageGallery = $('#<?php echo $image_gallery_id; ?>');
		
		$imageGallery.isotope({
			itemSelector: '.grid-item',
			layoutMode: 'fitRows',
		});
		
		$('#<?php echo $image_gallery_id; ?>-filters a').click(function(event) {
			event.preventDefault();
			
			var selector = $(this).attr('data-filter');
			
			$(this).parent().siblings().removeClass('active');
			$(this).parent().addClass('active');
			
			$imageGallery.isotope({ filter: selector });
			
			<?php /* Note: this fix will need to be adapted from simplelightbox to glightbox
			// restrict list of images simplelightbox can navigate through to visible items 
			gallery.initialSelector = '#<?php echo $image_gallery_id; ?> .grid-item'+selector+' .glightbox';
			gallery.refresh(); */ ?>
		});
		
		var imageGallerylLightbox = GLightbox({
			selector: '#<?php echo $image_gallery_id; ?> .grid-item .glightbox',
		});
		
	});
	</script>
</div>
