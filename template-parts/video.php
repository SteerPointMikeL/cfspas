<?php

extract($args);

if ( empty($video) || empty( $video['video_type'] ) ) return false;

wp_enqueue_style( 'glightbox' );
wp_enqueue_script( 'glightbox' );

$video_id = wp_unique_id('video-');

$href = '';
switch ( $video['video_type'] ) {
	case 'file' :
		$href = $video['file'];
		
		break;
	case 'url' : 
		$href = $video['url'];
		
		break;
	case 'embed_code' : 
		$glightbox_iframe_id = wp_unique_id('glightbox_iframe-');
		
		$href = '#' . $glightbox_iframe_id;
		
		break;
}
?>
		<div id="<?php echo $video_id; ?>" class="video_thumbnail_container_outer">
			<div class="video_thumbnail_container">
				<?php echo wp_get_attachment_image( $video['thumbnail'], 'medium', null, array( 'class' => 'thumbnail' ) ); ?>
				
				<i class="icon-play"></i>
				
				<a href="<?php echo esc_url( $href ); ?>" class="video_link full_coverage_link"><?php echo !empty($title) ? $title : '&nbsp'; ?></a>
			</div>
			
<?php
if ( $video['video_type'] === 'embed_code' ) {
	if ( str_contains( $video['embed_code'], 'lite-youtube' ) )  {
		wp_enqueue_style('lite-youtube-embed');
		wp_enqueue_script('lite-youtube-embed');
	}
?>
			<div id="<?php echo $glightbox_iframe_id; ?>" style="display: none;">
				<?php echo $video['embed_code']; ?>
			</div>
<?php } ?>
			
			<script>
			jQuery(document).ready(function($){
				
				var lightboxVideo = GLightbox({
					selector: '#<?php echo $video_id; ?> .video_link',
				});
				
			});
			</script>
		</div>
