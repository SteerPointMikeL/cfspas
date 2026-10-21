<?php

if ( empty($appearance_modifiers) ) $appearance_modifiers = array();
if ( empty($additional_css_classes) ) $additional_css_classes = '';
if ( empty($columns_per_row) ) $columns_per_row = '3';

$video_grid_id = wp_unique_id('video_grid_id-');

?>
<div id="<?php echo $video_grid_id; ?>" class="layout_block video_grid <?php echo esc_attr( implode( ' ', $appearance_modifiers ) ); ?> <?php echo esc_attr( $additional_css_classes ); ?>">
	<div class="wrap">
		<?php get_template_part( 'template-parts/section_title', null, array( 'title' => $title ) ); ?>
		
<?php if ( !empty($intro_text) ) { ?>
		<div class="intro_text">
			<?php echo $intro_text; ?>
		</div>
<?php } ?>
		
<?php
if ( !empty($videos) && is_array($videos) && count($videos) ) {
	wp_enqueue_style( 'glightbox' );
	wp_enqueue_script( 'glightbox' );
?>
		<div class="columns columns-<?php echo $columns_per_row; ?> columns-top_level">
<?php
	foreach ( $videos as $video ) {
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
			<div class="column">
				<div class="video_thumbnail_container">
					<?php echo wp_get_attachment_image( $video['thumbnail'], 'medium', null, array( 'class' => 'thumbnail' ) ); ?>
					
					<i class="icon-play"></i>
				</div>
				
				<p class="title"><?php echo $video['title']; ?></p>
				
				<a href="<?php echo esc_url( $href ); ?>" class="video_link full_coverage_link"><?php echo $video['title'] ;?></a>
				
<?php
		if ( $video['video_type'] === 'embed_code' ) {
			if ( str_contains( $video['embed_code'], 'lite-youtube' ) )  {
				wp_enqueue_style('lite-youtube-embed');
				wp_enqueue_script('lite-youtube-embed');
			}
?>
				<div id="<?php echo $glightbox_iframe_id; ?>" class="video_container" style="display: none;">
					<?php echo $video['embed_code']; ?>
				</div>
<?php } ?>
			</div>
<?php } ?>
		</div>
		
		<div class="button_container">
			<a href="/videos/" class="sp_button">See More Videos</a>
		</div>
		
<?php } ?>
	</div>
	
	<script>
	jQuery(document).ready(function($){
		
		var lightboxVideo = GLightbox({
			selector: '#<?php echo $video_grid_id; ?> .video_link',
		});
		
	});
	</script>
</div>

