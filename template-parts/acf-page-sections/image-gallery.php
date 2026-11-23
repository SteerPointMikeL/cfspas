<?php

if ( empty($images) ) return false;

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
				<a href="#" data-filter="filter-<?php echo esc_attr( $term['slug'] ); ?>"><?php echo esc_html( $term['label'] ); ?></a>
			</li>
<?php } ?>
		</ul>
<?php } ?>
		
		<div id="<?php echo $image_gallery_id; ?>" class="columns columns-<?php echo $columns_per_row; ?> columns-image_gallery">
<?php
$i = 1; foreach ( $images as $image ) {
	$filter_terms = array_map( function($a) { return 'filter-' . $a['slug']; }, $image['categories_array'] );
	
	$image_url = wp_get_attachment_image_src( $image['image'], 'full' );
	if ( $image_url ) $image_url = $image_url[0];
?>
			<div id="image-<?php echo $i; ?>" class="column <?php echo implode(' ', $filter_terms); ?>">
				<?php echo wp_get_attachment_image( $image['image'], 'medium', null, array('class' => 'image') ); ?>
				
				<a href="<?php echo $image_url; ?>" class="full_coverage_link glightbox"><?php _e( 'View full size image', SP_TEXT_DOMAIN ); ?></a> 
			</div>
<?php $i++; } ?>
		</div>
	</div>
	
	<script>
	jQuery(document).ready(function($) {
		var $columns = $('#<?php echo $image_gallery_id; ?> .column');
		
		// allow each column to animate independently from one another by giving each a unique view transition name
		$columns.each(function() {
			$(this).css('view-transition-name', $(this).attr('id') );
		});
		
		$('#<?php echo $image_gallery_id; ?>-filters a').click(function(event) {
			event.preventDefault();
			
			var selector = $(this).attr('data-filter');
			
			$(this).parent().siblings().removeClass('active');
			$(this).parent().addClass('active');
			
			// fallback for unsupported browsers
			if (!document.startViewTransition) {
				applyFilter(selector);
				
				return;
			}
			
			document.startViewTransition(function() {
				applyFilter(selector);
			});
			
			function applyFilter(selector) {
				$columns.each(function() {
					if (selector === '*' || $(this).hasClass(selector)) {
						$(this).removeClass('hidden');
					} else {
						$(this).addClass('hidden');
					}
					
					// ensure image gallery only contains non-hidden images after filter change
					imageGallerylLightbox.reload();
				});
			}
		});
		
		var imageGallerylLightbox = GLightbox({
			selector: '#<?php echo $image_gallery_id; ?> .column:not(.hidden) .glightbox',
		});
		
	});
	</script>
</div>
