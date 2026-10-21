<?php

if ( empty($appearance_modifiers) ) $appearance_modifiers = array();
if ( empty($additional_css_classes) ) $additional_css_classes = '';
if ( empty($column_space_distribution) ) $column_space_distribution = '';
if ( empty($image_position) ) $image_position = 'left';
if ( empty($content) ) $content = '';

wp_enqueue_style( 'owl-carousel' );
wp_enqueue_script( 'owl-carousel' );

$image_slider_id = wp_unique_id('image_slider-');

?>
<section class="layout_block content_with_image_slider <?php echo esc_attr( implode( ' ', $appearance_modifiers ) ); ?> <?php echo esc_attr( $additional_css_classes ); ?> <?php echo esc_attr( $column_space_distribution ); ?>">
	<div class="wrap">
		<div class="columns columns-2 columns-top_level <?php echo esc_attr( $image_position ); ?>">
			<div class="column column-1 column-image">
<?php if ( !empty($title) ) { ?>
				<p class="section_title responsive"><?php echo $title; ?></p>
<?php } ?>
				
<?php if ( !empty($images) && is_array($images) && count($images) ) { ?>
				<div id="<?php echo $image_slider_id; ?>" class="owl-carousel">
<?php foreach ( $images as $image ) { ?>
					<div class="carousel-item">
						<?php echo wp_get_attachment_image( $image['image'], 'medium_large', null, array('class' => 'image') ); ?>


<?php if ( !empty( $image['caption'] ) ) { ?>
						<div class="caption">
							<?php echo $image['caption']; ?>
						</div>
<?php } ?>
					</div>
<?php } ?>
				</div>
<?php } ?>
			</div>
			
			<div class="column column-2 column-content">
				<?php get_template_part( 'template-parts/section_title', null, array( 'title' => $title ) ); ?>
				
				<?php echo $content; ?>
				
			</div>
		</div>
	</div>
	
	<script>
	jQuery(document).ready(function($){
		
		$('#<?php echo $image_slider_id; ?>').owlCarousel({
			items: 1,
			margin: 12,
			responsiveRefreshRate: 50,
			navSpeed: 500,
			navText: ['<i class="icon-chevron-left"></i>', '<i class="icon-chevron-right"></i>'],
			rewind: true,
			dots: false,
			nav: true,
		});
		
	});
	</script>
</section>
