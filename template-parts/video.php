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
		if ( str_contains( $video['embed_code'], 'lite-youtube' ) )  {
			wp_enqueue_style('lite-youtube-embed');
			wp_enqueue_script('lite-youtube-embed');
		} else if ( str_contains($video['embed_code'], 'lite-vimeo' ) ) {
			wp_enqueue_script('lite-vimeo');
		}
		
		$glightbox_iframe_id = wp_unique_id('glightbox_iframe-');
		
		$href = '#' . $glightbox_iframe_id;
		
		break;
}
?>
		<div id="<?php echo $video_id; ?>" class="video_thumbnail_container_outer">
			<div class="video_thumbnail_container">
<?php
// manual thumbnail
$thumbnail = wp_get_attachment_image( $video['thumbnail'], 'medium', null, array( 'class' => 'thumbnail' ) );
if ( $thumbnail ) {
?>
				<?php echo $thumbnail; ?>
<?php
// vimeo thumbnail
} else if ( $video['video_type'] === 'url' && parse_url( trim($href), PHP_URL_HOST ) === 'vimeo.com' ) {
	if ( preg_match( '#(?:https?://)?(?:www\.)?(?:player\.)?vimeo\.com/(?:[a-z]*/)*([0-9]{6,11})[?]?.*#i', $href, $vimeo_id ) ) {
?>
				<img src="https://vumbnail.com/<?php echo $vimeo_id[1]; ?>.jpg" alt="" class="thumbnail" />
<?php
	}
}
?>
				
				<i class="icon-play"></i>
				
				<a href="<?php echo esc_url( $href ); ?>" class="full_coverage_link video_link"><?php echo !empty($title) ? $title : '&nbsp'; ?></a>
			</div>
			
<?php if ( $video['video_type'] === 'embed_code' ) { ?>
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
