<?php

wp_enqueue_style( 'glightbox' );
wp_enqueue_script( 'glightbox' );

if ( empty($appearance_modifiers) ) $appearance_modifiers = array();
if ( empty($appearance_modifiers_more) ) $appearance_modifiers_more = array();
if ( empty($additional_css_classes) ) $additional_css_classes = '';
if ( empty($column_space_distribution) ) $column_space_distribution = '';
if ( empty($media_position) ) $media_position = 'left';
if ( empty($content) ) $content = '';
if ( empty($show_play_button) ) $show_play_button = '';

$content_with_video_id = wp_unique_id('content_with_video-');

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
<section id="<?php echo $content_with_video_id; ?>" class="layout_block content_with_image content_with_video <?php echo esc_attr( implode( ' ', array_merge($appearance_modifiers, $appearance_modifiers_more) ) ); ?> <?php echo esc_attr( $additional_css_classes ); ?> <?php echo esc_attr( $column_space_distribution ); ?>">
	<div class="wrap">
		<div class="columns columns-2 columns-top_level <?php echo esc_attr( $media_position ); ?>">
			<div class="column column-1 column-image">
<?php if ( !empty($title) ) { ?>
				<p class="section_title responsive"><?php echo $title; ?></p>
<?php } ?>
				
				<div class="video_thumbnail_container_outer">
					<div class="video_thumbnail_container">
						<?php echo wp_get_attachment_image( $video['thumbnail'], 'medium', null, array( 'class' => 'thumbnail' ) ); ?>
						
						<i class="icon-play"></i>
						
						<a href="<?php echo esc_url( $href ); ?>" class="full_coverage_link video_link"><?php echo !empty($title) ? $title : '&nbsp'; ?></a>
					</div>
			
<?php if ( $video['video_type'] === 'embed_code' ) { ?>
					<div id="<?php echo $glightbox_iframe_id; ?>" style="display: none;">
						<?php echo $video['embed_code']; ?>
					</div>
<?php } ?>
				</div>
			</div>
			
			<div class="column column-2 column-content">
				<?php get_template_part( 'template-parts/section_title', null, array( 'pre_title' => $pre_title, 'title' => $title ) ); ?>
				
				<?php echo $content; ?>
				
<?php if ( $show_play_video_button ) { ?>
				<div class="button_container">
					<a href="<?php echo esc_url( $href ); ?>" class="sp_button video_link"><i class="icon-video"></i> <?php _e( 'Play Video', SP_TEXT_DOMAIN ); ?></a>
				</div>
<?php } ?>
			</div>
		</div>
	</div>
	
	<script>
	jQuery(document).ready(function($){
		
		var lightboxVideo = GLightbox({
			selector: '#<?php echo $content_with_video_id; ?> .video_link',
		});
		
	});
	</script>
</section>
