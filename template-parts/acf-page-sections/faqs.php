<?php

if ( empty($appearance_modifiers) ) $appearance_modifiers = array();
if ( empty($additional_css_classes) ) $additional_css_classes = '';

wp_enqueue_script( 'jquery-ui-accordion' );

$faqs_id = wp_unique_id('faqs_id-');

?>
<section class="layout_block faqs <?php echo esc_attr( implode( ' ', $appearance_modifiers ) ); ?> <?php echo esc_attr( $additional_css_classes ); ?>">
	<div class="wrap">
		<div class="wow fadeInUpSmall">
			<?php get_template_part( 'template-parts/section_title', null, array( 'pre_title' => $pre_title, 'title' => $title ) ); ?>
			
<?php if ( !empty($intro_text) ) { ?>
			<div class="intro_text">
				<?php echo $intro_text; ?>	
			</div>
<?php } ?>
		</div>
		
<?php if ( !empty($faqs) && is_array($faqs) && count($faqs) ) { ?>
		<div id="<?php echo $faqs_id; ?>" class="accordion_container">
<?php foreach ( $faqs as $i => $faq ) { ?>
			<p class="ui-accordion-header question wow fadeInUpSmall" data-wow-delay="<?php echo $i * 75; ?>ms"><i class="icon-plus-circle"></i><i class="icon-minus-circle"></i> <?php echo $faq['question']; ?></p>
			
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
