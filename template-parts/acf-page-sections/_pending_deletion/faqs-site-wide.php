<?php

if ( empty($appearance_modifiers) ) $appearance_modifiers = array();
if ( empty($additional_css_classes) ) $additional_css_classes = '';

$faqs_categories_data = get_field('faqs_categories', 'option');

// Get index of selected category inside entries from FAQ Options page by finding first matching instance of category name field
$faqs_category_data_found_index = null;
if ( is_array($faqs_categories_data) ) {
	foreach ( $faqs_categories_data as $key => $value ) {
		if ( $value['name'] === $faqs_category ) {
			$faqs_category_data_found_index = $key;
			
			break;
		}
	}
}

wp_enqueue_script( 'jquery-ui-accordion' );

$faqs_id = wp_unique_id('faqs_id-');

?>
<section class="layout_block faqs <?php echo esc_attr( implode( ' ', $appearance_modifiers ) ); ?> <?php echo esc_attr( $additional_css_classes ); ?>">
	<div class="wrap">
		<?php get_template_part( 'template-parts/section_title', null, array( 'title' => $title ) ); ?>
		
<?php if ( !empty($intro_text) ) { ?>
		<div class="intro_text">
			<?php echo $intro_text; ?>	
		</div>
<?php } ?>
		
<?php if ( isset( $faqs_category_data_found_index) ) { ?>
		<div id="<?php echo $faqs_id; ?>" class="accordion_container">
<?php foreach ( $faqs_categories_data[$faqs_category_data_found_index]['faqs'] as $faq ) { ?>
			<p class="ui-accordion-header question"><i class="icon-chevron-down"></i><i class="icon-chevron-up"></i> <?php echo $faq['question']; ?></p>
			
			<div class="ui-accordion-content">	
				<?php echo $faq['answer']; ?>
			</div>
<?php } ?>
		</div>
		
		<script>
		jQuery(document).ready(function($) {
			$('#<?php echo $faqs_id; ?>').accordion({
				active: false,
				collapsible: true,
				heightStyle: 'content',
			});
		});
		</script>
<?php } ?>
	</div>
</section>
