<?php

wp_enqueue_script( 'isotope' );

if ( empty($appearance_modifiers) ) $appearance_modifiers = array();
if ( empty($additional_css_classes) ) $additional_css_classes = '';
if ( empty($columns_per_row) ) $columns_per_row = '4';

$document_grid_id = wp_unique_id('document_grid-');

?>
<div class="layout_block documents <?php echo esc_attr( implode( ' ', $appearance_modifiers ) ); ?> <?php echo esc_attr( $additional_css_classes ); ?>">
	<div class="wrap">
		<?php get_template_part( 'template-parts/section_title', null, array('pre_title' => $pre_title, 'title' => $title) ); ?>
		
<?php if ( !empty($intro_text) ) { ?>
		<div class="intro_text">
			<?php echo $intro_text; ?>	
		</div>
<?php } ?>
		
<?php
$terms = get_terms( array( 'taxonomy' => 'cfspas_document_brand' ) );
if ( count($terms) ) {
?>
		<ul id="<?php echo $image_gallery_id; ?>-filters" class="filters">
			<li class="active"><a href="#" data-filter="*">All</a></li>
<?php foreach ( $terms as $term ) { ?>
			<li>
				<a href="#" data-filter=".isotope-filter-<?php echo esc_attr( $term->slug ); ?>"><?php echo esc_html( $term->name ); ?></a>
			</li>
<?php } ?>
		</ul>
<?php } ?>
		
<?php
$documents = new WP_Query( array( 'post_type' => 'cfspas_document' ) );
if ( $documents->have_posts() ) :
?>
		<div id="<?php echo $document_grid_id; ?>" class="grid columns-<?php echo $columns_per_row; ?> clearfix">
<?php
while ( $documents->have_posts() ) : $documents->the_post();
	$filter_terms = array_map( function($a) { return 'isotope-filter-' . $a->slug; }, get_the_terms( get_the_ID(), 'cfspas_document_brand' ) );
?>
			<div class="grid-item <?php echo implode(' ', $filter_terms); ?>">
				<a href="" class="sp_button"><i class="icon-pdf"></i> <?php _e( 'Read More', SP_TEXT_DOMAIN ); ?></a> 
			</div>
<?php endwhile; wp_reset_postdata(); ?>
		</div>
		
		<script>
		jQuery(document).ready(function($) {
			var $documentGrid = $('#<?php echo $document_grid_id; ?>');
			
			$documentGrid.isotope({
				itemSelector: '.grid-item',
				layoutMode: 'fitRows',
			});
			
			$('#<?php echo $document_grid_id; ?>-filters a').click(function(event) {
				event.preventDefault();
				
				var selector = $(this).attr('data-filter');
				
				$(this).parent().siblings().removeClass('active');
				$(this).parent().addClass('active');
				
				$documentGrid.isotope({ filter: selector });
			});
			
		});
		</script>
<?php endif; ?>
	</div>
</div>
