<?php

if ( empty($appearance_modifiers) ) $appearance_modifiers = array();
if ( empty($additional_css_classes) ) $additional_css_classes = '';
if ( empty($columns_per_row) ) $columns_per_row = '3';

?>
<div class="layout_block video_grid <?php echo esc_attr( implode( ' ', $appearance_modifiers ) ); ?> <?php echo esc_attr( $additional_css_classes ); ?>">
	<div class="wrap">
		<?php get_template_part( 'template-parts/section_title', null, array( 'title' => $title ) ); ?>
		
<?php if ( !empty($intro_text) ) { ?>
		<div class="intro_text">
			<?php echo $intro_text; ?>
		</div>
<?php } ?>
		
<?php if ( !empty($videos) && is_array($videos) && count($videos) ) { ?>
		<div class="columns columns-<?php echo $columns_per_row; ?> columns-top_level">
<?php foreach ( $videos as $video ) { ?>
			<div class="column">
				<?php get_template_part('template-parts/video', null, array( 'video' => $video ) ); ?>
				
				<p class="title"><?php echo $video['title']; ?></p>
			</div>
<?php } ?>
		</div>
<?php } ?>

		<?php get_template_part( 'template-parts/buttons', null, array( 'buttons' => $buttons ) ); ?>
	</div>
</div>

