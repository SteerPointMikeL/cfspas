<?php

if ( empty($appearance_modifiers) ) $appearance_modifiers = array();
if ( empty($appearance_modifiers_more) ) $appearance_modifiers_more = array();
if ( empty($additional_css_classes) ) $additional_css_classes = '';
if ( empty($image_position) ) $image_position = 'left';

?>
<section class="layout_block brand_with_image <?php echo esc_attr( implode( ' ', array_merge( $appearance_modifiers, $appearance_modifiers_more)  ) ); ?> <?php echo esc_attr( $additional_css_classes ); ?>">
	<div class="wrap">
		<div class="wow fadeInUpSmall">
			<?php get_template_part( 'template-parts/section_title', null, array( 'pre_title' => $pre_title, 'title' => $title ) ); ?>
			
			<div class="intro_text_outer">
				<div class="intro_text">
					<?php echo $intro_text; ?>
				</div>
				
				<?php get_template_part( 'template-parts/buttons', null, array( 'buttons' => array( $button ) ) ); ?>
			</div>
		</div>
		
		<div class="columns columns-2 columns-top_level">
			<div class="column column-1 column-image">
				<?php echo wp_get_attachment_image( $image, 'medium_large', null, array( 'class' => sprintf('image wow %s', $image_position === 'right' ? 'fadeInRight' : 'fadeInLeft' ) ) ); ?>
			</div>
			
<?php if ( !empty($brand) ) { ?>
			<div class="column column-2 column-content wow <?php echo $image_position === 'right' ? 'fadeInLeft' : 'fadeInRight'; ?>">
<?php if ( !empty( $brand['brand_logo'] ) ) { ?>
				<p><?php echo wp_get_attachment_image( $brand['brand_logo'], 'medium', null, array('alt' => get_sub_field('title'), 'class' => 'brand_logo') ); ?></p>
<?php } ?>
				
<?php if ( !empty( $brand['image'] ) ) { ?>
				<p><?php echo wp_get_attachment_image( $brand['image'], 'medium', null, array('alt' => get_sub_field('title'), 'class' => 'image') ); ?></p>
<?php } ?>
				
<?php if ( !empty( $brand['title'] ) ) { ?>
				<p class="title"><?php echo $brand['title']; ?></p>
<?php } ?>

<?php if ( !empty( $brand['tag_label'] ) ) { ?>
				<p class="tag_label"><i class="icon-tags"></i> <?php echo $brand['tag_label']; ?></p>
<?php } ?>
				
				<?php if ( !empty( $brand['content'] ) ) echo $brand['content']; ?>
				
				<?php get_template_part( 'template-parts/buttons', null, array( 'buttons' => array( $brand['button'] ) ) ); ?>
			</div>
<?php } ?>
		</div>
	</div>
</section>
