<?php

if ( empty($appearance_modifiers) ) $appearance_modifiers = array();
if ( empty($additional_css_classes) ) $additional_css_classes = '';
if ( empty($columns_per_row) ) $columns_per_row = '3';
if ( empty($buttons_position) ) $buttons_position = 'before_video';

?>
<div class="layout_block video_large <?php echo esc_attr( implode( ' ', $appearance_modifiers ) ); ?> <?php echo esc_attr( $additional_css_classes ); ?>">
	<div class="wrap">
		<div class="wow fadeInUpSmall">
			<?php get_template_part( 'template-parts/section_title', null, array( 'pre_title' => $pre_title, 'title' => $title ) ); ?>
			
<?php if ( !empty($intro_text) ) { ?>
			<div class="intro_text">
				<?php echo $intro_text; ?>
			</div>
<?php } ?>
			
			<?php if ( $buttons_position === 'before_video' ) get_template_part( 'template-parts/buttons', null, array( 'buttons' => $buttons ) ); ?>
		</div>
		
		<div class="wow fadeInUpSmall" data-wow-delay="300ms">
			<?php get_template_part('template-parts/video', null, array( 'video' => $video ) ); ?>
		</div>
		
		<div class="wow fadeInUpSmall">
			<?php if ( $buttons_position === 'after_video' ) get_template_part( 'template-parts/buttons', null, array( 'buttons' => $buttons ) ); ?>
			
<?php if ( !empty($after_video_text) ) { ?>
			<div class="after_video_text">
				<?php echo $after_video_text; ?>
			</div>
<?php } ?>
		</div>
	</div>
</div>

