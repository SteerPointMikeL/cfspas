<?php

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
		<ul id="<?php echo $document_grid_id; ?>-filters" class="filters">
			<li class="active"><a href="#" data-filter="*">All</a></li>
<?php foreach ( $terms as $term ) { ?>
			<li>
				<a href="#" data-filter="filter-<?php echo esc_attr( $term->slug ); ?>"><?php echo esc_html( $term->name ); ?></a>
			</li>
<?php } ?>
		</ul>
<?php } ?>
		
<?php
$documents = new WP_Query( array( 'post_type' => 'cfspas_document', 'orderby' => 'name', 'order' => 'ASC', 'posts_per_page' => -1 ) );
if ( $documents->have_posts() ) :
?>
		<div id="<?php echo $document_grid_id; ?>" class="columns columns-<?php echo $columns_per_row; ?> columns-documents">
<?php
while ( $documents->have_posts() ) : $documents->the_post();
	$brands = get_the_terms( get_the_ID(), 'cfspas_document_brand' );
	if ( !is_wp_error($brands) && count($brands) ) {
		$brand_image = get_field( 'brand_image', 'cfspas_document_brand_' . $brands[0]->term_id );
		$brand_name = $brands[0]->name;
	}
	
	$filter_terms = array_map( function($a) { return 'filter-' . $a->slug; }, $brands );
?>
			<div class="column <?php echo implode(' ', $filter_terms); ?>">
				<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
<?php if ( !empty($brand_image) ) { ?>
					<?php echo wp_get_attachment_image( $brand_image, 'medium', null, array('class' => 'brand_image') ); ?>
<?php } ?>
					
					<p class="title"><?php the_title(); ?></p>
					
					<ul class="metadata">
						<?php if ( !empty($brand_name) ) { ?><li><i class="icon-tags"></i> <?php echo $brand_name; ?></li><?php } ?>
						<?php if ( get_field('document_type') ) { ?><li><i class="icon-pdf"></i> <?php the_field('document_type'); ?></li><?php } ?>
					</ul>
					
					<?php 
					get_template_part( 'template-parts/buttons', null, array(
						'buttons' => array(
							'link_type'   => 'url',
							'url'         => get_field('document_url'),
							'target'      => '_blank',
							'button_text' => __( 'Read More', SP_TEXT_DOMAIN ),
						),
						'button_text_format' => '<i class="icon-pdf"></i> %s',
					) );
					?>
				</article>
			</div>
<?php endwhile; wp_reset_postdata(); ?>
		</div>
		
		<script>
		jQuery(document).ready(function($) {
			var $columns = $('#<?php echo $document_grid_id; ?> .column');
			
			// allow each column to animate independently from one another by giving each a unique view transition name
			$columns.each(function() {
				$(this).css('view-transition-name', $(this).find('article').attr('id') );
			});
			
			$('#<?php echo $document_grid_id; ?>-filters a').click(function(event) {
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
					});
				}
			});
		});
		</script>
<?php endif; ?>
	</div>
</div>
