<?php

if ( empty($appearance_modifiers) ) $appearance_modifiers = array();
if ( empty($additional_css_classes) ) $additional_css_classes = '';
if ( empty($columns_per_row) ) $columns_per_row = '3';

?>
<section class="layout_block dealerships <?php echo esc_attr( implode( ' ', $appearance_modifiers ) ); ?> <?php echo esc_attr( $additional_css_classes ); ?>">
	<div class="wrap">
		<?php get_template_part( 'template-parts/section_title', null, array( 'pre_title' => $pre_title, 'title' => $title ) ); ?>
		
<?php if ( !empty($intro_text) ) { ?>
		<div class="intro_text">
			<?php echo $intro_text; ?>	
		</div>
<?php } ?>
		
<?php if ( !empty($columns) ) { ?>
		<div class="columns columns-<?php echo $columns_per_row; ?> columns-top_level">
<?php foreach ( $columns as $column ) : ?>
			<div class="column">
<?php if ( !empty( $column['title_image'] ) ) { ?>
				<p class="title"><?php echo wp_get_attachment_image( $column['title_image'], 'medium', null, array('alt' => get_sub_field('title'), 'class' => 'title_image') ); ?></p>
<?php } else if ( !empty( $column['title'] ) ) { ?>
				<p class="title"><?php echo $column['title']; ?></p>
<?php } ?>
				
				<?php echo $column['content']; ?>
				
				<?php get_template_part( 'template-parts/buttons', null, array( 'buttons' => array( $column['button'] ) ) ); ?>
			</div>
<?php endforeach; ?>
		</div>
<?php } ?>
	</div>
</section>
