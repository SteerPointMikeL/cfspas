<?php

if ( empty($appearance_modifiers) ) $appearance_modifiers = array();
if ( empty($additional_css_classes) ) $additional_css_classes = '';
if ( empty($columns_per_row) ) $columns_per_row = '3';

?>
<div class="layout_block video_grid_style_b <?php echo esc_attr( implode( ' ', $appearance_modifiers ) ); ?> <?php echo esc_attr( $additional_css_classes ); ?>">
	<div class="wrap">
		<div class="columns columns-2 columns-featured_video">
			<div class="column column-1 column-content">
				<?php get_template_part( 'template-parts/section_title', null, array( 'pre_title' => $pre_title, 'title' => $title ) ); ?>
				
<?php if ( !empty($intro_text) ) { ?>
				<div class="intro_text">
					<?php echo $intro_text; ?>
				</div>
<?php } ?>
				
				<?php get_template_part( 'template-parts/buttons', null, array( 'buttons' => $buttons ) ); ?>
			</div>
			
			<div class="column columns-2 column-video">
<?php if ( !empty($videos) && is_array($videos) && count($videos) ) { ?>
				<?php get_template_part('template-parts/video', null, array( 'video' => $videos[0] ) ); ?>
<?php } ?>
			</div>
		</div>
		
<?php if ( !empty($videos) && is_array($videos) && count($videos) > 1 ) { ?>
		<div class="columns columns-<?php echo $columns_per_row; ?> columns-top_level">
<?php
foreach ( $videos as $i => $video ) {
	if ( $i < 1 ) continue;
?>
			<div class="column">
				<p class="title"><?php echo $video['title']; ?></p>
				
				<?php get_template_part('template-parts/video', null, array( 'video' => $video ) ); ?>
			</div>
<?php } ?>
		</div>
<?php } ?>
	</div>
</div>
