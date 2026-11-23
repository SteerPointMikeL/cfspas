<?php

wp_enqueue_style( 'glightbox' );
wp_enqueue_script( 'glightbox' );

if ( empty($appearance_modifiers) ) $appearance_modifiers = array();
if ( empty($appearance_modifiers_more) ) $appearance_modifiers_more = array();
if ( empty($additional_css_classes) ) $additional_css_classes = '';
if ( empty($column_space_distribution) ) $column_space_distribution = '';
if ( empty($media_position) ) $media_position = 'left';
if ( empty($content) ) $content = '';

$content_with_video_id = wp_unique_id('content_with_video-');

?>
<section id="<?php echo $content_with_video_id; ?>" class="layout_block content_with_image content_with_video_style_b <?php echo esc_attr( implode( ' ', array_merge($appearance_modifiers, $appearance_modifiers_more) ) ); ?> <?php echo esc_attr( $additional_css_classes ); ?> <?php echo esc_attr( $column_space_distribution ); ?>">
<?php
$background = wp_get_attachment_image_src( $background, 'full', null, array( 'class' => 'background' ) );
if ( is_array($background) ) $background = $background[0];
if ( $background ) {
?>
	<div class="background" style="background-image: url(<?php echo esc_url( $background ); ?>);"></div>
<?php } ?>
	
	<div class="wrap"><div class="layer_2">
		<div class="wow fadeInUpSmall">
			<?php get_template_part( 'template-parts/section_title', null, array( 'pre_title' => $pre_title, 'title' => $title ) ); ?>
			
<?php if ( !empty($intro_text) ) { ?>
			<div class="intro_text">
				<?php echo $intro_text; ?>	
			</div>
<?php } ?>
		</div>
		
		<div class="columns columns-2 columns-top_level <?php echo esc_attr( $media_position ); ?>">
			<div class="column column-1 column-image wow <?php echo $media_position == 'right' ? 'fadeInRight' : 'fadeInLeft'; ?>">
<?php if ( !empty($title) ) { ?>
				<p class="section_title responsive"><?php echo $title; ?></p>
<?php } ?>
				
				<?php get_template_part( 'template-parts/video', null, array( 'video' => $video ) ); ?>
			</div>
			
			<div class="column column-2 column-content wow <?php echo $media_position == 'right' ? 'fadeInLeft' : 'fadeInRight'; ?>">
				
				<?php echo $content; ?>
				
			</div>
		</div>
	</div></div>
	
	<script>
	jQuery(document).ready(function($){
		
		var lightboxVideo = GLightbox({
			selector: '#<?php echo $content_with_video_id; ?> .video_link',
		});
		
	});
	</script>
</section>
