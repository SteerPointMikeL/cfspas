<?php

if ( empty($appearance_modifiers) ) $appearance_modifiers = array();
if ( empty($additional_css_classes) ) $additional_css_classes = '';
if ( empty($gallery_position) ) $gallery_position = 'left';
if ( empty($content) ) $content = '';

$video_links_with_image_gallery_id = wp_unique_id('video_links_with_image_gallery_id-');

?>
<div id="<?php echo $video_links_with_image_gallery_id; ?>" class="layout_block video_links_with_image_gallery <?php echo esc_attr( implode( ' ', $appearance_modifiers ) ); ?> <?php echo esc_attr( $additional_css_classes ); ?>">
	<div class="wrap">
		<div class="columns columns-2 columns-top_level <?php echo esc_attr( $gallery_position ); ?>">
			<div class="column column-1 column-content"><div class="layer_2">
				<?php get_template_part( 'template-parts/section_title', null, array( 'title' => $title ) ); ?>
				
				<?php echo $content; ?>
				
<?php
if ( is_array($video_links) && count($video_links) ) {
	wp_enqueue_style( 'glightbox' );
	wp_enqueue_script( 'glightbox' );
?>
				<div class="button_container">
<?php
	foreach ( $video_links as $video_link ) {
		$href = '';
		switch ( $video_link['video_type'] ) {
			case 'file' :
				$href = $video_link['file'];
				
				break;
			case 'url' : 
				$href = $video_link['url'];
				
				break;
			case 'embed_code' : 
				$glightbox_iframe_id = wp_unique_id('glightbox_iframe-');
				
				$href = '#' . $glightbox_iframe_id;
				
				break;
		}
?>
					<a href="<?php echo esc_url( $href ); ?>" class="sp_button video_link">
						<i class="icon-play-circle"></i>
						
						<div class="layer_2">
							<p class="title"><?php echo $video_link['button_heading']; ?></p>
							
							<p><?php echo $video_link['button_text']; ?></p>
						</div>
					</a>
<?php
		if ( $video_link['video_type'] === 'embed_code' ) {
			if ( str_contains( $video_link['embed_code'], 'lite-youtube' ) )  {
				wp_enqueue_style('lite-youtube-embed');
				wp_enqueue_script('lite-youtube-embed');
			}
?>
					<div id="<?php echo $glightbox_iframe_id; ?>" class="video_container" style="display: none;">
						<?php echo $video_link['embed_code']; ?>
					</div>
<?php } ?>
					
<?php } ?>
				</div>
				
				<script>
				jQuery(document).ready(function($){
					
					var lightboxVideo = GLightbox({
						selector: '#<?php echo $video_links_with_image_gallery_id; ?> .video_link',
					});
					
				});
				</script>
<?php } ?>
				
			</div></div>
			
			<div class="column column-2 column-gallery">
<?php if ( is_array($images) && count($images) ) { ?>
				<div class="image_gallery">
<?php foreach ( $images as $image ) { ?>
					<div class="gallery_image">
						<?php echo wp_get_attachment_image( $image, 'medium_large', null, array('class' => 'image') ); ?>
					</div>
<?php } ?>
				</div>
<?php } ?>
			</div>
		</div>
	</div>
	
	<script>
	jQuery(document).ready(function($){
		
		var lightboxVideo = GLightbox({
			selector: '.video_link',
		});
		
	});
	</script>
</div>
