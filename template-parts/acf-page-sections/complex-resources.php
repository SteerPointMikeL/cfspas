<?php

if ( empty($appearance_modifiers) ) $appearance_modifiers = array();
if ( empty($additional_css_classes) ) $additional_css_classes = '';
if ( empty($intro_text) ) $intro_text = '';
if ( empty($content) ) $content = '';

?>
<section class="layout_block complex_resources <?php echo esc_attr( implode( ' ', $appearance_modifiers ) ); ?> <?php echo esc_attr( $additional_css_classes ); ?> <?php echo esc_attr( $column_space_distribution ); ?>">
	<div class="wrap">
		<?php get_template_part( 'template-parts/section_title', null, array( 'title' => $intro_title ) ); ?>
		
		<div class="intro_text_outer">
			<div class="intro_text">
				<?php echo $intro_text; ?>
			</div>
			
			<?php get_template_part( 'template-parts/buttons', null, array( 'buttons' => array( $button ) ) ); ?>
		</div>
	</div>
	
	<div class="wrap columns_wrap">
		<?php get_template_part('template-parts/video', null, array( 'video' => $video ) ); ?>
		
		<div class="columns columns-2 columns-top_level <?php echo esc_attr( $media_position ); ?>">
			<div class="column column-1 column-images">
<?php if ( !empty($images) && is_array($images) && count($images) ) { ?>
				<div class="columns columns-2 columns-inner">
<?php foreach ( $images as $image ) { ?>
					<div class="column">
						<?php echo wp_get_attachment_image( $image, 'medium', null, array('class' => 'image') ); ?>
					</div>
<?php } ?>
				</div>
<?php } ?>
			</div>
			
			<div class="column column-2 column-content">
				<?php get_template_part( 'template-parts/section_title', null, array( 'pre_title' => $pre_title, 'title' => $title ) ); ?>
				
				<?php echo $content; ?>
				
				<?php get_template_part( 'template-parts/buttons', null, array( 'buttons' => $buttons ) ); ?>
			</div>
		</div>
	</div>
</section>
