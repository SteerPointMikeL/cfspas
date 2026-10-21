<?php

if ( empty($appearance_modifiers) ) $appearance_modifiers = array();
if ( empty($additional_css_classes) ) $additional_css_classes = '';
if ( empty($column_space_distribution) ) $column_space_distribution = '';
if ( empty($media_position) ) $media_position = 'left';
if ( empty($content) ) $content = '';

?>
<section class="layout_block content_with_image content_with_video <?php echo esc_attr( implode( ' ', $appearance_modifiers ) ); ?> <?php echo esc_attr( $additional_css_classes ); ?> <?php echo esc_attr( $column_space_distribution ); ?>">
	<div class="wrap">
		<div class="columns columns-2 columns-top_level <?php echo esc_attr( $media_position ); ?>">
			<div class="column column-1 column-image">
<?php if ( !empty($title) ) { ?>
				<p class="section_title responsive"><?php echo $title; ?></p>
<?php } ?>
				
				<?php get_template_part('template-parts/video', null, array( 'video' => $video ) ); ?>
			</div>
			
			<div class="column column-2 column-content">
				<?php get_template_part( 'template-parts/section_title', null, array( 'title' => $title ) ); ?>
				
				<?php echo $content; ?>
				
			</div>
		</div>
	</div>
</section>
